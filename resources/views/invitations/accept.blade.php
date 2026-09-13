
<x-guest-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Accept Invitation
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <h3 class="text-lg font-semibold mb-2">
                    Create your account
                </h3>

                <p class="text-gray-600 mb-6">
                    You have been invited as a
                    <strong>{{ ucfirst($invitation->role) }}</strong>.
                </p>

                <form
                    method="POST"
                    action="{{ route('invitations.accept', $invitation->token) }}"
                >
                    @csrf

                    <div class="mb-4">
                        <label for="name">
                            Name
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            required
                            class="block mt-1 w-full border-gray-300 rounded-md"
                        >

                        @error('name')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email">
                            Email
                        </label>

                        <input
                            id="email"
                            type="email"
                            value="{{ $invitation->email }}"
                            disabled
                            class="block mt-1 w-full border-gray-300 rounded-md bg-gray-100"
                        >
                    </div>

                    <div class="mb-4">
                        <label for="password">
                            Password
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            required
                            class="block mt-1 w-full border-gray-300 rounded-md"
                        >

                        @error('password')
                            <p class="text-red-600 text-sm mt-1">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation">
                            Confirm Password
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            class="block mt-1 w-full border-gray-300 rounded-md"
                        >
                    </div>

                    <button
                        type="submit"
                        class="px-4 py-2 bg-gray-800 text-white rounded"
                    >
                        Accept Invitation
                    </button>

                </form>

            </div>
        </div>
    </div>

</x-guest-layout>