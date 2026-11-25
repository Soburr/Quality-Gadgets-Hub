<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\CampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignRecipient;
use App\Models\EmailSubscriber;
use App\Services\CampaignSender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = EmailCampaign::withCount([
                'recipients',
                'recipients as sent_count' => fn ($q) => $q->where('status', 'sent'),
            ])
            ->latest()
            ->paginate(20);

        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        return view('admin.campaigns.create', [
            'activeCount' => EmailSubscriber::active()->count(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:150',
            'body' => 'required|string|max:20000',
        ]);

        $campaign = EmailCampaign::create($validated);

        return redirect()->route('admin.campaigns.show', $campaign)
            ->with('status', 'Draft saved. Send yourself a test before sending to the list.');
    }

    public function show(EmailCampaign $campaign, CampaignSender $sender)
    {
        return view('admin.campaigns.show', [
            'campaign' => $campaign,
            'counts' => $sender->counts($campaign),
            'activeCount' => EmailSubscriber::active()->count(),
            'failures' => $campaign->recipients()->where('status', 'failed')->with('subscriber')->limit(20)->get(),
        ]);
    }

    public function test(Request $request, EmailCampaign $campaign)
    {
        $data = $request->validate(['test_email' => 'required|email']);

        $subscriber = new EmailSubscriber(['email' => $data['test_email'], 'name' => $request->user()->name]);

        try {
            Mail::to($data['test_email'])->send(new CampaignMail($campaign, $subscriber));
        } catch (\Throwable $e) {
            return back()->withErrors(['test_email' => 'Test failed: '.mb_substr($e->getMessage(), 0, 300)])->withInput();
        }

        return back()->with('status', 'Test sent to '.$data['test_email'].'. Check the inbox and spam folder.');
    }

    public function start(EmailCampaign $campaign)
    {
        $activeCount = EmailSubscriber::active()->count();

        if ($activeCount === 0) {
            return back()->withErrors(['start' => 'There are no active subscribers yet. Import a list first.']);
        }

        $flipped = EmailCampaign::whereKey($campaign->id)
            ->where('status', 'draft')
            ->update(['status' => 'sending', 'started_at' => now(), 'total' => $activeCount]);

        if ($flipped !== 1) {
            return back();
        }

        $now = now();

        EmailSubscriber::active()->chunkById(200, function ($subscribers) use ($campaign, $now) {
            EmailCampaignRecipient::insert($subscribers->map(fn ($s) => [
                'email_campaign_id' => $campaign->id,
                'email_subscriber_id' => $s->id,
                'status' => 'pending',
                'created_at' => $now,
                'updated_at' => $now,
            ])->all());
        });

        return redirect()->route('admin.campaigns.show', $campaign)
            ->with('status', "Ready to send to {$activeCount} people. Click Start sending and keep this tab open.");
    }

    public function sendBatch(EmailCampaign $campaign, CampaignSender $sender)
    {
        abort_unless($campaign->status === 'sending', 409);

        return response()->json($sender->sendBatch($campaign));
    }

    public function retryFailed(EmailCampaign $campaign)
    {
        $campaign->recipients()->where('status', 'failed')->update(['status' => 'pending', 'error' => null]);
        $campaign->update(['status' => 'sending', 'finished_at' => null]);

        return back()->with('status', 'Failed emails are back in the queue. Click Continue sending.');
    }

    public function destroy(EmailCampaign $campaign)
    {
        $campaign->delete();

        return redirect()->route('admin.campaigns.index')->with('status', 'Campaign deleted.');
    }
}