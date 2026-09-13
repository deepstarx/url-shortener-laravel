<?php

namespace App\Http\Controllers;
use App\Http\Requests\StoreInvitationRequest;
use App\Services\InvitationService;
use Illuminate\Http\RedirectResponse;
use App\Enums\UserRole;
use App\Models\Company;
use Illuminate\View\View;
use Illuminate\support\Facades\DB;

use Illuminate\Http\Request;

class InvitationController extends Controller
{
    //
    public function create(): View
    {
        return view('invitations.create');
    }



    public function store(StoreInvitationRequest $request, InvitationService $invitationService): RedirectResponse

    {
        $user = $request->user();
        $companyName = $request->validated('company_name');
        $email =$request->validated('email');
        $role = UserRole::from($request->validated('role'));

        DB::transaction(function () use ($user, $email, $role, $companyName, $invitationService) {
            
        if($user->isSuperAdmin())
            {
                $company = Company::create([
                    'name' => $companyName,
                ]);
                $companyId = $company->id;
            } else
            {
                $companyId = $user->company_id;
            }

            $invitationService->create($user, $email, $role, $companyId );
    });

    return redirect()->back()->with('success','Invitation created successfully');
}
}
