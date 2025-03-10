<?php

namespace App\Services\Fortify;

use App\Models\User;
use App\Rules\PasswordRules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @return User \App\Models\User
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name'     => ['required', 'string', 'max:50'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique(User::class)],
            'password' => PasswordRules::ruleWithConfirm(),
        ])->validate();

        return User::create([
            'name'     => $input['name'],
            'email'    => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
