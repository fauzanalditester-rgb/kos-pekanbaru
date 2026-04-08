<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SewaVIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-[#111827] p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-800">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-[#0d9488] rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">SewaVIP</h1>
            <p class="text-gray-400 text-sm mt-1">Sistem Manajemen Kos</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.simple.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required 
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]"
                    value="{{ old('email') }}">
            </div>

            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]"
>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-[#0d9488]">
                <label for="remember" class="ml-2 text-gray-400 text-sm">Ingat saya</label>
            </div>

            <button type="submit" 
                class="w-full bg-[#0d9488] hover:bg-[#0f766e] text-white font-semibold py-3 rounded-xl transition-colors">
                Masuk
            </button>
        </form>

    </div>
</body>
</html>
