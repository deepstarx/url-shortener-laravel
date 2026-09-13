<?php

namespace App\Services;
use App\Models\User;
use App\Models\ShortUrl;
use Illuminate\Support\Str;

class ShortUrlService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user, string $originalUrl): ShortUrl
    {
        $shortUrl = $this->generateUniqueCode();

        return ShortUrl::create([
            'company_id' => $user->company_id,
            'user_id' => $user->id,
            'short_url' => $shortUrl,
            'original_url' => $originalUrl,
        ]);
    }

    private function generateUniqueCode(): string
    {
        do{
            $url = Str::random(8);
        } while (ShortUrl::where('short_url', $url)->exists());
        return $url;
    }
}
