<?php

namespace App\Http\Controllers;
use Illuminate\View\View;
use App\Models\Invitation;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvitationAcceptanceController extends Controller
{
    public function show(string $token):view
    {
        $invitation = Invitation::where('token', $token)->whereNull('accepted_at')
        ->where('expires_at', '>',now())->firstorfail();

        return view('invitations.accept', compact('invitation'));
    }

    public function store(Request $request, string $token): RedirectResponse
    {
        $invitation = Invitation::where('token', $token)
        ->whereNull('accepted_at')
        ->where('expires_at', '>', now())
        ->firstOrFail();

         $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    DB::transaction(function () use ($invitation, $validated) {
        $user = User::create([
            'name' => $validated['name'],
            'email' => $invitation->email,
            'password' => Hash::make($validated['password']),
            'company_id' => $invitation->company_id,
            'role' => $invitation->role,
        ]);


        $invitation->update([
            'accepted_at' =>now(),
        ]);

        Auth::login($user);

    });

    return redirect()->route('dashboard')->with('success', 'Your Account has been created Successfully');
}
}
