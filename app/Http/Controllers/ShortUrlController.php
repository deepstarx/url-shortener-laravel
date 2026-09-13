<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShortUrlRequest;
use Illuminate\View\View;
use App\Services\ShortUrlService;
use App\Models\ShortUrl;
use App\Models\User;
use App\Models\Company;
use Illuminate\Http\RedirectResponse;

class ShortUrlController extends Controller
{
    //
    public function index():View
    {
        $user = auth()->user();
        $urls = ShortUrl::visibleTo($user)
            ->latest()->paginate(10);

        $teamMembers = collect(); 
        if ($user->isAdmin())
          { 
             $teamMembers = User::where('company_id', $user->company_id) 
             ->orderBy('name') ->get();
          }

        $companies = collect(); if ($user->isSuperAdmin())
          {
             $companies = Company::withCount([ 'users', 'shortUrls', ]) 
             ->orderBy('name') ->get();
          }

          $totalCompanies = 0;
          $totalUsers = 0;
          $totalUrls = 0;

          if ($user->isSuperAdmin()) 
            
          {
             $totalCompanies = Company::count();
             $totalUsers = User::whereNotNull('company_id')->count();
             $totalUrls = ShortUrl::count();
          }

        return view('urls.index', compact( 'urls', 'teamMembers', 'companies', 'totalCompanies', 'totalUsers', 'totalUrls' )); }

        // return view('urls.index', compact('urls'));
    
    
    public function create(): View
    {
         return view('urls.create');
    }

    public function store(StoreShortUrlRequest $request, ShortUrlService $shortUrlService): RedirectResponse
    {
         $shortUrlService->create( $request->user(), $request->validated('original_url'));

         return redirect()->route('urls.index')->with('success', 'Short URL created successfully.');
    }
}
