<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmailSubscriber;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    public function index(Request $request)
    {
        $subscribers = EmailSubscriber::when($request->get('q'), function ($query, $term) {
                $query->where(function ($w) use ($term) {
                    $w->where('email', 'like', "%{$term}%")->orWhere('name', 'like', "%{$term}%");
                });
            })
            ->orderBy('email')
            ->paginate(50)
            ->withQueryString();

        $stats = [
            'active' => EmailSubscriber::active()->count(),
            'unsubscribed' => EmailSubscriber::whereNotNull('unsubscribed_at')->count(),
        ];

        return view('admin.subscribers.index', compact('subscribers', 'stats'));
    }

    public function import(Request $request)
    {
        $request->validate([
            'emails' => 'nullable|string|max:200000',
            'file' => 'nullable|file|mimes:csv,txt|max:2048',
        ]);

        $raw = (string) $request->input('emails', '');

        if ($request->hasFile('file')) {
            $fileContent = file_get_contents($request->file('file')->getRealPath());
            $fileContent = preg_replace('/^\xEF\xBB\xBF/', '', $fileContent); // Excel's BOM
            $raw .= "\n".$fileContent;
        }

        $raw = mb_convert_encoding($raw, 'UTF-8', ['UTF-8', 'ISO-8859-1']);

        if (trim($raw) === '') {
            return back()->withErrors(['emails' => 'Paste some emails or choose a file first.']);
        }

        $added = $existing = $invalid = $skippedUnsub = 0;
        $seen = [];

        foreach (preg_split('/\r\n|\r|\n/', $raw) as $line) {
            $line = trim($line);

            if ($line === '') {
                continue;
            }

            $parts = array_map(fn ($p) => trim($p, " \t\"'"), preg_split('/[,;\t]/', $line));

            if (strtolower($parts[0]) === 'email') {
                continue; 
            }

            $email = null;
            $name = null;

            foreach ($parts as $part) {
                if ($email === null && filter_var($part, FILTER_VALIDATE_EMAIL)) {
                    $email = strtolower($part);
                } elseif ($name === null && $part !== '') {
                    $name = $part;
                }
            }

            if (! $email) {
                $invalid++;
                continue;
            }

            if (isset($seen[$email])) {
                continue;
            }
            $seen[$email] = true;

            $subscriber = EmailSubscriber::where('email', $email)->first();

            if ($subscriber) {
                $subscriber->unsubscribed_at ? $skippedUnsub++ : $existing++;
                continue; 
            }

            EmailSubscriber::create([
                'email' => $email,
                'name' => $name ? mb_substr($name, 0, 120) : null,
            ]);
            $added++;
        }

        $summary = ["{$added} added"];
        if ($existing) $summary[] = "{$existing} already on the list";
        if ($skippedUnsub) $summary[] = "{$skippedUnsub} skipped (unsubscribed earlier)";
        if ($invalid) $summary[] = "{$invalid} not valid emails";

        return back()->with('status', 'Import done: '.implode(' · ', $summary).'.');
    }

    public function destroy(EmailSubscriber $subscriber)
    {
        $subscriber->delete();

        return back()->with('status', 'Subscriber removed.');
    }
}