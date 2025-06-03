<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
// Jika Anda menggunakan Jetstream, baris ini mungkin ada, jika tidak, bisa dihapus atau disesuaikan:
// use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules; // Trait ini menyediakan metode passwordRules()

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            // Karena 'nip' Anda set sebagai 'username' di config/fortify.php,
            // validasi username unik Fortify akan berlaku untuk NIP.
            // Anda juga bisa menambahkan aturan spesifik NIP di sini jika perlu.
            'nip' => ['required', 'string', 'max:255', 'unique:users,nip'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(), // Menggunakan aturan validasi password dari Fortify
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'nip' => $input['nip'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
            'role' => User::ROLE_EMPLOYEE, // Atau 'employee' secara langsung
        ]);
    }
}
