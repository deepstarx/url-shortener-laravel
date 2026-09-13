
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>URL Shortener</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-50 text-gray-900">

    @php

        $user = auth()->user();

        $isSuperAdmin = $user->isSuperAdmin();

        $isAdmin = $user->isAdmin();

        $isMember = $user->isMember();

    @endphp


    <div class="min-h-screen flex">


        <!-- =========================================================
         SIDEBAR
    ========================================================== -->

        <aside class="hidden md:flex w-64 bg-white border-r border-gray-200
                  min-h-screen flex-col">


            <!-- Logo -->

            <div class="h-20 flex items-center px-6 border-b border-gray-200">

                <div>

                    <h1 class="text-xl font-bold text-gray-900">
                        URL Shortener
                    </h1>

                    <p class="text-xs text-gray-500 mt-1">
                        SaaS Dashboard
                    </p>

                </div>

            </div>


            <!-- Navigation -->

            <nav class="flex-1 px-4 py-6 space-y-2">


                <!-- Dashboard -->

                <a href="{{ route('urls.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg

                {{ $isSuperAdmin
                    ? 'bg-yellow-50 text-yellow-700'
                    : ($isAdmin
                        ? 'bg-blue-50 text-blue-700'
                        : 'bg-green-50 text-green-700') }}

                font-medium">

                    <span>▦</span>

                    Dashboard

                </a>


                <!-- URLs -->

                @if (!$isSuperAdmin)
                    <a href="{{ route('urls.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg
                           text-gray-600 hover:bg-gray-100">

                        <span>🔗</span>

                        Short URLs

                    </a>
                @endif


                <!-- Admin -->

                @if ($isAdmin)
                    <a href="{{ route('urls.index') }}#team"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg
                           text-gray-600 hover:bg-gray-100">

                        <span>👥</span>

                        Team Members

                    </a>
                @endif


                <!-- SuperAdmin -->

                @if ($isSuperAdmin)
                    <a href="{{ route('urls.index') }}#companies"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg
                           text-gray-600 hover:bg-gray-100">

                        <span>🏢</span>

                        Companies

                    </a>
                @endif


                <!-- Profile -->

            

            </nav>


            <!-- User -->

            <div class="border-t border-gray-200 p-4">

                <div class="mb-4">

                    <p class="text-sm font-semibold">
                        {{ $user->name }}
                    </p>

                    <p class="text-xs text-gray-500 truncate">
                        {{ $user->email }}
                    </p>

                </div>


                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg
                           text-sm text-red-600 hover:bg-red-50">
                        Logout
                    </button>

                </form>

            </div>

        </aside>



        <!-- =========================================================
         MAIN
    ========================================================== -->

        <main class="flex-1">


            <!-- TOP BAR -->

            <header
                class="h-20 bg-white border-b border-gray-200
                       flex items-center justify-between px-6 lg:px-8">


                <div>

                    <h2 class="text-xl font-semibold">
                        Dashboard
                    </h2>

                    <p class="text-sm text-gray-500">
                        Manage your URL Shortener workspace
                    </p>

                </div>


                <!-- Role -->

                @if ($isSuperAdmin)
                    <span
                        class="px-4 py-2 rounded-full text-sm font-medium
                             bg-yellow-100 text-yellow-700">

                        Super Admin

                    </span>
                @elseif ($isAdmin)
                    <span
                        class="px-4 py-2 rounded-full text-sm font-medium
                             bg-blue-100 text-blue-700">

                        Client Admin

                    </span>
                @else
                    <span
                        class="px-4 py-2 rounded-full text-sm font-medium
                             bg-green-100 text-green-700">

                        Client Member

                    </span>
                @endif

            </header>



            <!-- CONTENT -->

            <div class="p-6 lg:p-8">


                <!-- Success -->

                @if (session('success'))
                    <div
                        class="mb-6 rounded-lg bg-green-50
                            border border-green-200 px-4 py-3
                            text-green-700">

                        {{ session('success') }}

                    </div>
                @endif



                <!-- =================================================
                 METRICS
            ================================================== -->

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
                        gap-5 mb-8">


                    <!-- Total URLs -->

                    <div class="bg-white rounded-xl border border-gray-200
                            p-6 shadow-sm">

                        <p class="text-sm text-gray-500">
                            Total Short URLs
                        </p>

                        <p class="text-3xl font-bold mt-2">

                            {{ $urls->total() }}

                        </p>

                    </div>


                    <!-- Workspace -->

                    <div class="bg-white rounded-xl border border-gray-200
                            p-6 shadow-sm">

                        <p class="text-sm text-gray-500">
                            Workspace
                        </p>

                        <p class="text-xl font-bold mt-2">

                            @if ($isSuperAdmin)
                                All Companies
                            @else
                                {{ $user->company->name ?? 'My Company' }}
                            @endif

                        </p>

                    </div>


                    <!-- Account -->

                    <div class="bg-white rounded-xl border border-gray-200
                            p-6 shadow-sm">

                        <p class="text-sm text-gray-500">
                            Account Status
                        </p>

                        <p class="text-xl font-bold text-green-600 mt-2">
                            Active
                        </p>

                    </div>

                </div>



                <!-- =================================================
                 URL SECTION
            ================================================== -->

                <section class="bg-white rounded-xl border border-gray-200
                            shadow-sm">


                    <!-- Header -->

                    <div
                        class="p-6 border-b border-gray-200
                            flex flex-col sm:flex-row
                            sm:items-center sm:justify-between gap-4">


                        <div>

                            <h3 class="text-lg font-semibold">
                                Generated Short URLs
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">

                                @if ($isSuperAdmin)
                                    All URLs across all companies
                                @elseif ($isAdmin)
                                    URLs generated by your company
                                @else
                                    URLs generated by you
                                @endif

                            </p>

                        </div>


                        <!-- Generate -->

                        @if (!$isSuperAdmin)
                            <a href="{{ route('urls.create') }}"
                                class="inline-flex items-center justify-center
                                   px-5 py-2.5 rounded-lg
                                   text-white font-semibold text-sm

                                   {{ $isAdmin ? 'bg-blue-600 hover:bg-blue-700' : 'bg-green-600 hover:bg-green-700' }}">

                                + Generate Short URL

                            </a>
                        @endif

                    </div>



                    <!-- Table -->

                    <div class="overflow-x-auto">

                        <table class="min-w-full">

                            <thead class="bg-gray-50 border-b border-gray-200">

                                <tr>

                                    @if ($isSuperAdmin)
                                        <th
                                            class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500 uppercase">

                                            Company

                                        </th>

                                        <th
                                            class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500 uppercase">

                                            Creator

                                        </th>
                                    @endif


                                    <th
                                        class="px-6 py-4 text-left
                                           text-xs font-semibold
                                           text-gray-500 uppercase">

                                        Original URL

                                    </th>
                                    @if ($user->isAdmin())
                                        <th
                                            class="px-6 py-4 text-left
                                           text-xs font-semibold
                                           text-gray-500 uppercase">

                                            Creator</th>
                                    @endif


                                    <th
                                        class="px-6 py-4 text-left
                                           text-xs font-semibold
                                           text-gray-500 uppercase">

                                        Shortened Link

                                    </th>


                                    <th
                                        class="px-6 py-4 text-left
                                           text-xs font-semibold
                                           text-gray-500 uppercase">

                                        Date Created

                                    </th>

                                </tr>

                            </thead>


                            <tbody class="divide-y divide-gray-100">


                                @forelse ($urls as $url)
                                    <tr class="hover:bg-gray-50">


                                        @if ($isSuperAdmin)
                                            <td class="px-6 py-5 text-sm">

                                                {{ $url->company->name ?? 'N/A' }}

                                            </td>


                                            <td class="px-6 py-5 text-sm">

                                                {{ $url->user->name ?? 'N/A' }}

                                            </td>
                                        @endif


                                        <!-- Original -->

                                        <td class="px-6 py-5">

                                            <div class="max-w-md truncate" title="{{ $url->original_url }}">

                                                {{ $url->original_url }}

                                            </div>

                                        </td>

                                        {{-- if Admin creator visible --}}

                                        @if ($user->isAdmin())
                                            <td>
                                                <div class="font-medium text-gray-900">
                                                    {{ $url->user->name }}
                                                </div>
                                               
                                            </td>
                                        @endif
                                        <!-- Short URL -->

                                        <td class="px-6 py-5">

                                            <a href="{{ url($url->short_url) }}" target="_blank"
                                                class="font-medium

                                            {{ $isAdmin ? 'text-blue-600' : ($isMember ? 'text-green-600' : 'text-yellow-600') }}

                                            hover:underline">

                                                {{ url($url->short_url) }}

                                            </a>

                                        </td>


                                        <!-- Date -->

                                        <td class="px-6 py-5 text-gray-500">

                                            {{ $url->created_at->format('d M Y') }}

                                        </td>


                                    </tr>


                                @empty

                                    <tr>

                                        <td colspan="{{ $isSuperAdmin ? 5 : 3 }}" class="px-6 py-12 text-center">

                                            <p class="text-gray-500">
                                                No short URLs found.
                                            </p>

                                            @if (!$isSuperAdmin)
                                                <a href="{{ route('urls.create') }}"
                                                    class="inline-block mt-3
                                                       text-blue-600
                                                       hover:underline">
                                                    Generate your first URL
                                                </a>
                                            @endif

                                        </td>

                                    </tr>
                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    <!-- Pagination -->

                    @if ($urls->hasPages())
                        <div class="p-6 border-t border-gray-200">

                            {{ $urls->links() }}

                        </div>
                    @endif

                </section>



                <!-- =================================================
                 ADMIN TEAM
            ================================================== -->

                @if ($isAdmin)

                    <section id="team"
                        class="mt-8 bg-white rounded-xl
                           border border-gray-200 shadow-sm">


                        <div
                            class="p-6 border-b border-gray-200
                                flex items-center justify-between">

                            <div>

                                <h3 class="text-lg font-semibold">
                                    Team Management
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Manage users belonging to your company
                                </p>

                            </div>


                            <a href="{{ route('invitations.create') }}"
                                class="px-5 py-2.5 rounded-lg
                                   bg-blue-600 hover:bg-blue-700
                                   text-white text-sm font-semibold">

                                + Invite Team Member

                            </a>

                        </div>



                        <div class="overflow-x-auto">

                            <table class="min-w-full">

                                <thead class="bg-gray-50">

                                    <tr>

                                        <th class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500">
                                            Name
                                        </th>

                                        <th class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500">
                                            Email
                                        </th>

                                        <th class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500">
                                            Role
                                        </th>

                                        <th class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500">
                                            Status
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-100">


                                    @forelse ($teamMembers as $member)
                                        <tr class="hover:bg-gray-50">

                                            <td class="px-6 py-4 text-sm font-medium">

                                                {{ $member->name }}

                                            </td>


                                            <td class="px-6 py-4 text-sm text-gray-600">

                                                {{ $member->email }}

                                            </td>


                                            <td class="px-6 py-4">

                                                <span
                                                    class="px-2.5 py-1 rounded-full
                                                       text-xs

                                                       {{ $member->isAdmin() ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700' }}">

                                                    {{ ucfirst($member->role->value) }}

                                                </span>

                                            </td>


                                            <td class="px-6 py-4">

                                                <span
                                                    class="px-2.5 py-1 rounded-full
                                                       text-xs bg-green-100
                                                       text-green-700">

                                                    Active

                                                </span>

                                            </td>

                                        </tr>


                                    @empty

                                        <tr>

                                            <td colspan="4"
                                                class="px-6 py-10 text-center
                                                   text-gray-500">

                                                No team members found.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </section>

                @endif



                <!-- =================================================
                 SUPER ADMIN
            ================================================== -->

                @if ($isSuperAdmin)


                    <!-- Global Metrics -->

                    <div id="companies"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3
                           gap-5 mt-8">


                        <div
                            class="bg-white rounded-xl border
                                border-gray-200 p-6 shadow-sm">

                            <p class="text-sm text-gray-500">
                                Total Companies
                            </p>

                            <p class="text-3xl font-bold mt-2">
                                {{ $totalCompanies }}
                            </p>

                        </div>


                        <div
                            class="bg-white rounded-xl border
                                border-gray-200 p-6 shadow-sm">

                            <p class="text-sm text-gray-500">
                                Total Users
                            </p>

                            <p class="text-3xl font-bold mt-2">
                                {{ $totalUsers }}
                            </p>

                        </div>


                        <div
                            class="bg-white rounded-xl border
                                border-gray-200 p-6 shadow-sm">

                            <p class="text-sm text-gray-500">
                                Total URLs Generated
                            </p>

                            <p class="text-3xl font-bold mt-2">
                                {{ $totalUrls }}
                            </p>

                        </div>

                    </div>



                    <!-- Client Overview -->

                    <section
                        class="mt-8 bg-white rounded-xl
                                border border-gray-200 shadow-sm">


                        <div
                            class="p-6 border-b border-gray-200
                                flex items-center justify-between">

                            <div>

                                <h3 class="text-lg font-semibold">
                                    Client Overview
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Manage companies across the platform
                                </p>

                            </div>


                            <a href="{{ route('invitations.create') }}"
                                class="px-5 py-2.5 rounded-lg
                                   bg-yellow-500 hover:bg-yellow-600
                                   text-white text-sm font-semibold">

                                + Invite New Client

                            </a>

                        </div>



                        <div class="overflow-x-auto">

                            <table class="min-w-full">

                                <thead class="bg-gray-50">

                                    <tr>

                                        <th
                                            class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500">
                                            Company Name
                                        </th>

                                        <th
                                            class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500">
                                            Total Users
                                        </th>

                                        <th
                                            class="px-6 py-4 text-left
                                               text-xs font-semibold
                                               text-gray-500">
                                            Total URLs Generated
                                        </th>

                                    </tr>

                                </thead>


                                <tbody class="divide-y divide-gray-100">


                                    @forelse ($companies as $company)
                                        <tr class="hover:bg-gray-50">

                                            <td class="px-6 py-4 font-medium">

                                                {{ $company->name }}

                                            </td>


                                            <td class="px-6 py-4">

                                                {{ $company->users_count }}

                                            </td>


                                            <td class="px-6 py-4">

                                                {{ $company->short_urls_count }}

                                            </td>

                                        </tr>


                                    @empty

                                        <tr>

                                            <td colspan="3"
                                                class="px-6 py-10 text-center
                                                   text-gray-500">

                                                No companies found.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </section>

                @endif

            </div>

        </main>

    </div>

</body>

</html>
```
