<?php

namespace App\Http\Controllers;


use App\Models\ShortUrl;

class RedirectController extends Controller
{
    //
    public function show(string $shortUrl)
    {
        $shortUrlRecord = ShortUrl::where('short_url', $shortUrl)->firstOrFail();

        return redirect($shortUrlRecord->original_url);
    }
}
