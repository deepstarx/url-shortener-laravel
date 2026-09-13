```blade
<x-app-layout>

    <x-slot name="header">

        <div class="flex items-center justify-between">

            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Invite User
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Add a new user to your workspace
                </p>
            </div>

            <a href="{{ route('urls.index') }}" class="text-sm text-gray-600 hover:text-gray-900">
                ← Back to Dashboard
            </a>

        </div>

    </x-slot>


    @php
        $user = auth()->user();

        $isSuperAdmin = $user->isSuperAdmin();
        $isAdmin = $user->isAdmin();
    @endphp


    <div class="py-10">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">


            {{-- SUCCESS MESSAGE --}}

            @if (session('success'))
                <div
                    class="mb-6 rounded-lg bg-green-50
                            border border-green-200
                            px-4 py-3 text-green-700">

                    {{ session('success') }}

                </div>
            @endif


            {{-- VALIDATION ERRORS --}}

            @if ($errors->any())

                <div
                    class="mb-6 rounded-lg bg-red-50
                            border border-red-200
                            px-4 py-3 text-red-700">

                    <p class="font-semibold mb-2">
                        Please correct the following errors:
                    </p>

                    <ul class="list-disc list-inside text-sm space-y-1">

                        @foreach ($errors->all() as $error)
                            <li>
                                {{ $error }}
                            </li>
                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- MAIN CARD --}}

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">


                {{-- CARD HEADER --}}

                <div class="p-6 border-b border-gray-200">

                    <div class="flex items-center gap-4">

                        <div
                            class="w-12 h-12 rounded-lg
                                   flex items-center justify-center

                                   {{ $isSuperAdmin ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700' }}">

                            <span class="text-xl">
                                👤
                            </span>

                        </div>


                        <div>

                            <h3 class="text-lg font-semibold text-gray-900">

                                @if ($isSuperAdmin)
                                    Invite New Client
                                @else
                                    Invite Team Member
                                @endif

                            </h3>

                            <p class="text-sm text-gray-500 mt-1">

                                @if ($isSuperAdmin)
                                    Create a company and invite its Admin.
                                @else
                                    Invite an Admin or Member to your company.
                                @endif

                            </p>

                        </div>

                    </div>

                </div>


                {{-- FORM --}}

                <form method="POST" action="{{ route('invitations.store') }}" class="p-6">

                    @csrf


                    {{-- COMPANY NAME --}}
                    @if ($user->isSuperAdmin())
                        <div class="mb-4">
                            <label for="company_name" class="block font-medium text-sm text-gray-700">
                                Company Name
                            </label>

                            <input id="company_name" name="company_name" type="text"
                                value="{{ old('company_name') }}" required
                                class="block mt-1 w-full border-gray-300 rounded-md" placeholder="Company Name">

                            @error('company_name')
                                <p class="text-red-600 text-sm mt-1">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endif


                    {{-- EMAIL --}}

                    <div class="mb-6">

                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email Address
                        </label>


                        <input id="email" name="email" type="email" value="{{ old('email') }}" required
                            placeholder="user@example.com"
                            class="w-full px-4 py-3
                                   border border-gray-300
                                   rounded-lg
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500
                                   outline-none">


                        @error('email')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror


                        <p class="text-xs text-gray-500 mt-2">

                            The invitation link will be associated with this email address.

                        </p>

                    </div>


                    {{-- ROLE --}}

                    <div class="mb-6">

                        <label for="role" class="block text-sm font-medium text-gray-700 mb-2">
                            Role
                        </label>


                        <select id="role" name="role" required
                            class="w-full px-4 py-3
                                   border border-gray-300
                                   rounded-lg
                                   bg-white
                                   focus:ring-2
                                   focus:ring-blue-500
                                   focus:border-blue-500
                                   outline-none">

                            <option value="">
                                Select role
                            </option>


                            {{-- Admin can invite Admin or Member --}}

                            @if ($isAdmin)
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>

                                <option value="member" {{ old('role') === 'member' ? 'selected' : '' }}>
                                    Member
                                </option>
                            @endif


                            {{-- SuperAdmin can only invite Admin --}}

                            @if ($isSuperAdmin)
                                <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                            @endif

                        </select>


                        @error('role')
                            <p class="text-red-600 text-sm mt-2">
                                {{ $message }}
                            </p>
                        @enderror


                        <p class="text-xs text-gray-500 mt-2">

                            @if ($isSuperAdmin)
                                A new client company must have an Admin.
                            @else
                                Admins can manage the company, while Members can generate short URLs.
                            @endif

                        </p>

                    </div>


                    {{-- INVITATION INFORMATION --}}

                    <div class="mb-6 rounded-lg bg-gray-50
                               border border-gray-200 p-4">

                        <div class="flex gap-3">

                            <div class="text-gray-500">
                                ℹ
                            </div>

                            <div>

                                <p class="text-sm font-medium text-gray-700">
                                    Invitation process
                                </p>

                                <p class="text-sm text-gray-500 mt-1">

                                    The invited user will receive an invitation
                                    link and can use it to create their account
                                    and password.

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- BUTTONS --}}

                    <div class="flex flex-col sm:flex-row
                               sm:items-center gap-3">

                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg
                                   text-white text-sm font-semibold

                                   {{ $isSuperAdmin ? 'bg-yellow-500 hover:bg-yellow-600' : 'bg-blue-600 hover:bg-blue-700' }}">

                            Send Invitation

                        </button>


                        <a href="{{ route('urls.index') }}"
                            class="px-5 py-2.5 rounded-lg
                                   border border-gray-300
                                   text-gray-700 text-sm font-medium
                                   hover:bg-gray-50 text-center">

                            Cancel

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>
```
