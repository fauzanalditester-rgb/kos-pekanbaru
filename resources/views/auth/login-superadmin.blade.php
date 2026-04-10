<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - Harsasetialiving</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-purple-900 min-h-screen flex items-center justify-center">
    <div class="bg-[#111827] p-8 rounded-2xl shadow-xl w-full max-w-md border border-purple-500/30">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-purple-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-purple-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Super Admin</h1>
            <p class="text-purple-400 text-sm mt-1">Akses Penuh Sistem</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/20 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl text-sm mb-4 font-semibold">
                @if($errors->has('email'))
                    {{ $errors->first('email') }}
                @else
                    {{ $errors->first() }}
                @endif
            </div>
        @endif

        <form method="POST" action="{{ route('login.superadmin.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required 
                    class="w-full bg-gray-800 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-700' }} rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-purple-500"
>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-purple-500">
                <label for="remember" class="ml-2 text-gray-400 text-sm">Ingat saya</label>
            </div>

            <button type="submit" 
                class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-lg shadow-purple-500/30">
                Masuk sebagai Super Admin
            </button>
        </form>

        <div class="mt-4 text-center space-y-2">
            <a href="/forgot-password" class="text-xs text-purple-400 hover:text-purple-300 block">Lupa Password?</a>
            <a href="/login-admin" class="text-xs text-gray-500 hover:text-gray-400 block">Login sebagai Admin →</a>
        </div>
    </div>
</body>
</html>
