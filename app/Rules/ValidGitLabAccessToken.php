<?php

namespace App\Rules;

use Closure;
use GuzzleHttp\Client;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidGitLabAccessToken implements ValidationRule
{
    protected function isValid($value): bool
    {
        $client = new Client();
        try {
            $response = $client->request('GET', 'https://bitlab.bit-academy.nl/api/v4/user', [
                'headers' => [
                    'Authorization' => 'Bearer '.$value,
                ],
            ]);

            return $response->getStatusCode() === 200;
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function isExpired($value): bool
    {
        $client = new Client();
        try {
            $response = $client->request('GET', 'https://bitlab.bit-academy.nl/api/v4/user', [
                'headers' => [
                    'Authorization' => 'Bearer '.$value,
                ],
            ]);

            return $response->getStatusCode() === 401;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function passes($attribute, $value): bool
    {
        return $this->isValid($value) && ! $this->isExpired($value);
    }

    public function message(): string
    {
        return 'The :attribute is not a valid BitLab Access Token.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->passes($attribute, $value)) {
            $fail($this->message());
        }
    }
}
