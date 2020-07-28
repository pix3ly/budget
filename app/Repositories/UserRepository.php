<?php

namespace App\Repositories;

use App\Models\APIKey;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository
{
    public function getValidationRulesForRegistration(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'currency' => 'required|exists:currencies,id'
        ];
    }

    public function getValidationRulesForPasswordReset(): array
    {
        return [
            'email' => 'required_without:password|email',
            'password' => 'required_without:email|confirmed'
        ];
    }

    public function getById(int $id): ?User
    {
        return User::where('id', $id)->first();
    }

    public function getByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function getByVerificationToken(string $token): ?User
    {
        return User::where('verification_token', $token)->first();
    }

    public function getByAPIKey(string $token): ?User
    {
        $apiKey = DB::selectOne(DB::raw('
            SELECT a1.*, COUNT(a2.id) AS newer_keys
            FROM api_keys a1
            LEFT JOIN api_keys a2 ON a1.user_id = a2.user_id AND a2.created_at > a1.created_at
            WHERE a1.token = ?
            GROUP BY a1.id
            HAVING newer_keys = 0;
        '), [$token]);

        if (!$apiKey) {
            return null;
        }

        $user = $this->getById($apiKey->user_id);

        return $user;
    }

    public function verifyById(int $id): void
    {
        $user = $this->getById($id);

        if (!$user) {
            throw new Exception('User (ID ' . $id . ') not found');
        }

        $user->update([
            'verification_token' => null
        ]);
    }

    public function create(string $name, string $email, string $password): User
    {
        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'verification_token' => Str::random(100)
        ]);
    }

    public function update(int $id, array $data): void
    {
        $user = $this->getById($id);

        if (!$user) {
            throw new Exception('Could not find user with ID ' . $id);
        }

        $user->fill($data)->save();
    }

    public function createAPIKey(int $userId): APIKey
    {
        $token = Str::random(50);

        return APIKey::create([
            'user_id' => $userId,
            'token' => $token
        ]);
    }
}
