```blade
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Generate Short URL</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>


<body class="bg-gray-50 text-gray-900">

    <div class="min-h-screen flex">


        <!-- Sidebar -->

        <aside class="hidden md:flex w-64 bg-white border-r border-gray-200 min-h-screen flex-col">

            <div class="h-20 flex items-center px-6 border-b border-gray-200">

                <div>

                    <h1 class="text-xl font-bold">
                        URL Shortener
                    </h1>

                    <p class="text-xs text-gray-500 mt-1">
                        SaaS Dashboard
                    </p>

                </div>

            </div>


            <nav class="flex-1 px-4 py-6 space-y-2">

                <a href="{{ route('urls.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                       text-gray-600 hover:bg-gray-100">
                    <span>▦</span>
                    Dashboard
                </a>


                <a href="{{ route('urls.create') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                       bg-blue-50 text-blue-700 font-medium">
                    <span>🔗</span>
                    Generate URL
                </a>


                @if (auth()->user()->isAdmin())
                    <a href="{{ route('urls.index') }}#team"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg
                           text-gray-600 hover:bg-gray-100">
                        <span>👥</span>
                        Team Members
                    </a>
                @endif


                @if (auth()->user()->isSuperAdmin())
                    <a href="{{ route('urls.index') }}#companies"
                        class="flex items-center gap-3 px-4 py-3 rounded-lg
                           text-gray-600 hover:bg-gray-100">
                        <span>🏢</span>
                        Companies
                    </a>
                @endif


                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-lg
                       text-gray-600 hover:bg-gray-100">
                    <span>⚙</span>
                    Profile
                </a>

            </nav>


            <!-- User -->

            <div class="border-t border-gray-200 p-4">

                <p class="text-sm font-semibold">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-gray-500 truncate">
                    {{ auth()->user()->email }}
                </p>


                <form method="POST" action="{{ route('logout') }}" class="mt-4">

                    @csrf

                    <button type="submit"
                        class="w-full text-left px-4 py-2 rounded-lg
                           text-sm text-red-600 hover:bg-red-50">
                        Logout
                    </button>

                </form>

            </div>

        </aside>


        <!-- Main -->

        <main class="flex-1">

            <header
                class="h-20 bg-white border-b border-gray-200
                       flex items-center px-6 lg:px-8">

                <div>

                    <h2 class="text-xl font-semibold">
                        Generate Short URL
                    </h2>

                    <p class="text-sm text-gray-500">
                        Create a short link for your original URL
                    </p>

                </div>

            </header>


            <div class="p-6 lg:p-8">

                <div class="max-w-3xl">

                    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">

                        <div class="p-6 border-b border-gray-200">

                            <h3 class="text-lg font-semibold">
                                Create Short URL
                            </h3>

                            <p class="text-sm text-gray-500 mt-1">
                                Enter the URL you want to shorten.
                            </p>

                        </div>


                        <form method="POST" action="{{ route('urls.store') }}" class="p-6">

                            @csrf


                            <div>

                                <label for="original_url" class="block text-sm font-medium text-gray-700 mb-2">
                                    Original URL
                                </label>


                                <input type="url" id="original_url" name="original_url"
                                    value="{{ old('original_url') }}" placeholder="https://example.com" required
                                    class="w-full px-4 py-3 border border-gray-300
                                       rounded-lg focus:ring-2 focus:ring-blue-500
                                       focus:border-blue-500 outline-none">


                                @error('original_url')
                                    <p class="text-sm text-red-600 mt-2">
                                        {{ $message }}
                                    </p>
                                @enderror

                            </div>


                            <div class="flex items-center gap-3 mt-6">

                                <button type="submit"
                                    class="px-5 py-2.5 rounded-lg
                                       bg-blue-600 hover:bg-blue-700
                                       text-white font-semibold">
                                    Generate Short URL
                                </button>


                                <a href="{{ route('urls.index') }}"
                                    class="px-5 py-2.5 rounded-lg
                                       border border-gray-300
                                       text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </a>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </main>

    </div>

</body>

</html>
```
