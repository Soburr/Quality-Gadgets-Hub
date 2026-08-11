<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::when($request->get('q'), fn ($q, $term) => $q->where('name', 'like', "%{$term}%")->orWhere('email', 'like', "%{$term}%"))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function toggleAdmin(User $user)
    {
        abort_if($user->id === Auth::id(), 400, "You can't remove your own admin access.");

        $user->update(['is_admin' => ! $user->is_admin]);

        return back()->with('status', $user->is_admin ? "{$user->name} is now an admin." : "{$user->name}'s admin access was removed.");
    }

    public function export()
    {
        $filename = 'qgh-users-'.now()->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () {
            $handle = fopen('php://output', 'w');

            fwrite($handle, "\xEF\xBB\xBF");

            fputcsv($handle, ['Name', 'Email', 'Role', 'Joined']);

            User::orderBy('name')->chunk(200, function ($users) use ($handle) {
                foreach ($users as $user) {
                    fputcsv($handle, [
                        $user->name,
                        $user->email,
                        $user->is_admin ? 'Admin' : 'Customer',
                        $user->created_at->format('Y-m-d'),
                    ]);
                }
            });

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}