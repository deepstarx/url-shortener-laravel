<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\UserRole;

class StoreInvitationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
       $user = $this->user();

      if(! $user){
         return false;
      }

      if($user->isSuperAdmin()){
        return $this->input('role') === UserRole::ADMIN->value;
      }

      if($user->isAdmin()){

        return in_array($this->input('role'),[ UserRole::ADMIN->value, UserRole::MEMBER->value],true);
      }
      return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' =>['required','email', 'max:255'],
            'role' =>['required', Rule::in([UserRole::ADMIN->value, UserRole::MEMBER->value])],
            'company_name' =>[ Rule::requiredIf(fn () => $this->user()?->isSuperAdmin()),
                             'nullable','string', 'max:255' ]
            
            //
        ];
    }
}
