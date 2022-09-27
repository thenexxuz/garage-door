<?php
namespace App\Helpers;

use Illuminate\Support\Str;

Trait Tokenable
{
    public function generateAndSaveApiAuthToken(): static
    {
        $token = Str::random(60);

        $this->api_token = $token;
        $this->save();

        return $this;
    }
}
