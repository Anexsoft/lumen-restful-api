<?php
namespace App\Repositories;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\IIdentityRepository;
use App\Repositories\Exceptions\AccessDeniedException;

class IdentityRepository implements IIdentityRepository
{
    public function signin(string $email, string $password): array
    {
        // find user by email
        $entry = User::where('email', $email)->first();

        if ($entry) {
            // compare password
            if (Hash::check($password, $entry->password)) {
                $entry->api_token = Str::random(100);
                $entry->api_token_expiration = Carbon::now()->addHours(10);

                $entry->save();

                return [
                    'access_token' => $entry->api_token,
                    'expiration' => $entry->api_token_expiration,
                    'user' => [
                        'id' => $entry->id,
                        'name' => $entry->name,
                        'email' => $entry->email,
                    ],
                ];
            }
        }

        throw new AccessDeniedException('Acceso denegado');
    }
}
