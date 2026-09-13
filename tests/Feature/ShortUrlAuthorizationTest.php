<?php
use App\Models\Company;
use App\Models\ShortUrl;
use App\Models\User;
use \App\Enums\UserStatusEnum;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
it('allows an admin to see urls from their own company', function (){

 $companyA = Company::factory()->create();
 $companyB = Company::factory()->create();

 $adminA = User::factory()->admin($companyA)->create();
 $adminB = User::Factory()->admin($companyB)->create();

 ShortUrl::factory()->create([
    'company_id' => $companyA->id,
    'user_id' => $adminA->id,
    'short_url' => 'companyA',
    ]);

ShortUrl::factory()->create([
    'company_id' => $companyB->id,
    'user_id' => $adminB->id,
    'short_url' => 'companyB',
]);

 $this->actingAs($adminA)->get('/urls')
    ->assertSee('companyA')
    ->assertDontSee('companyB');
    
});


it('allows members to see urls created by themselves', function (){

 $company = Company::factory()->create();
 $memberA = User::factory()->member($company)->create();
 $memberB = User::factory()->member($company)->create();


 ShortUrl::factory()->create([
    'company_id' => $company->id,
    'user_id' => $memberA->id,
    'short_url' => 'memberA',
    ]);

ShortUrl::factory()->create([
    'company_id' => $company->id,
    'user_id' => $memberB->id,
    'short_url' => 'memberB',
]);

 $this->actingAs($memberA)->get('/urls')
    ->assertSee('memberA')
    ->assertDontSee('memberB');
});


it('allows Super admin to see all urls ', function (){

 $companyA = Company::factory()->create();
 $companyB = Company::factory()->create();

 $adminA = User::factory()->admin($companyA)->create();
 $adminB = User::Factory()->admin($companyB)->create();

 $superAdmin = User::factory()->create([
    'company_id' => null,
    'role' => \App\Enums\UserRole::SUPER_ADMIN,
 ]);

 ShortUrl::factory()->create([
    'company_id' => $companyA->id,
    'user_id' => $adminA->id,
    'short_url' => 'companyA',
    ]);

ShortUrl::factory()->create([
    'company_id' => $companyB->id,
    'user_id' => $adminB->id,
    'short_url' => 'companyB',
]);

 $this->actingAs($superAdmin)->get('/urls')
    ->assertSee('companyA')
    ->assertSee('companyB');
});

it('allows an admin to create a short url', function()
{
    $company = Company::factory()->create();
    $admin = User::factory()->admin($company)->create();

    $response =$this->actingAs($admin)->post('/urls',
     ['original_url' => 'https://example.com/some-long-page-url']);
    
    $response->assertRedirect(route('urls.index'))->assertSessionHas(
        'success', 'Short URL created successfully.');

        $this->assertDatabaseHAs('short_urls', [
            'company_id' => $company->id,
            'user_id' => $admin->id,
            'original_url' => 'https://example.com/some-long-page-url',
        ]);
});
    

it('allows member to create a short url', function()
{
    $company = Company::factory()->create();
    $member = User::factory()->member($company)->create();

    $response =$this->actingAs($member)->post('/urls',
     ['original_url' => 'https://example.com/some-long-page-url']);
    
    $response->assertRedirect(route('urls.index'))->assertSessionHas(
        'success', 'Short URL created successfully.');

        $this->assertDatabaseHas('short_urls', [
            'company_id' => $company->id,
            'user_id' => $member->id,
            'original_url' => 'https://example.com/some-long-page-url',
        ]);
});

it('prevents super admin from creating a short url', function()
{
    $superAdmin = User::factory()->create([
        'company_id' => null,
        'role' => \App\Enums\UserRole::SUPER_ADMIN,
     ]);

    $response =$this->actingAs($superAdmin)->post('/urls',
     ['original_url' => 'https://example.com/some-long-page-url']);
    
    $response->assertForbidden();

        $this->assertDatabaseMissing('short_urls', [
            'original_url' => 'https://example.com/some-long-page-url',
        ]);
});

it('rejects invalid original urls', function()
{
    $company = Company::factory()->create();
    $admin = User::factory()->admin($company)->create();

    $response =$this->actingAs($admin)->post('/urls',
     ['original_url' => 'invalid-url']);
    
    $response->assertSessionHasErrors('original_url');

        $this->assertDatabaseCount('short_urls', 0); 
});

it('rejects a missing original url', function()
{
    $company = Company::factory()->create();
    $admin = User::factory()->admin($company)->create();

    $response =$this->actingAs($admin)->post('/urls', []);
    
    $response->assertSessionHasErrors('original_url');

        $this->assertDatabaseCount('short_urls', 0); 
});

it('publicaly resolves a short url and redirects it to the original url' , function(){
    $company = Company::factory()->create();
    $admin = User::factory()->admin($company)->create();

    $shortUrl = ShortUrl::factory()->create([
        'company_id' => $company->id,
        'user_id' => $admin->id,
        'short_url' => 'Ab12Cd34',
        'original_url' => 'https://example.com/some-long-page-url',
    ]);

    $response = $this->get('/Ab12Cd34');
    $response->assertRedirect('https://example.com/some-long-page-url');
});

