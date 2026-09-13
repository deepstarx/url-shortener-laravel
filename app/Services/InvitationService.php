<?php

namespace App\Services;

use App\Models\User;
use App\Enums\UserRole;
use Illuminate\Support\Str;
use App\Models\Invitation;

class InvitationService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $creator, string $email, UserRole $role, int $companyId): Invitation
    {
        return Invitation::create([
            'company_id' => $companyId,
            'email' => $email,
            'role' => $role->value,
            'token' => Str::random(64),
            'expires_at' => now()->addHours(48),
            'created_by' => $creator->id,
        ]);
    
    }
}
