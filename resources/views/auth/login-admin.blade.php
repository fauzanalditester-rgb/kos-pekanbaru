<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SewaVIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-blue-900 min-h-screen flex items-center justify-center">
    <div class="bg-[#111827] p-8 rounded-2xl shadow-xl w-full max-w-md border border-blue-500/30">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-blue-600 rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-500/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Admin</h1>
            <p class="text-blue-400 text-sm mt-1">Manajemen Operasional</p>
        </div>

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login.admin.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required 
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500"
                    value="{{ old('email') }}">
            </div>

            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Password</label>
                <input type="password" name="password" required 
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-blue-500"
>
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-4 h-4 bg-gray-800 border-gray-700 rounded text-blue-500">
                <label for="remember" class="ml-2 text-gray-400 text-sm">Ingat saya</label>
            </div>

            <button type="submit" 
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl transition-colors shadow-lg shadow-blue-500/30">
                Masuk sebagai Admin
            </button>
        </form>

        <div class="mt-4 text-center space-y-1">
            <a href="/login-superadmin" class="text-xs text-gray-500 hover:text-gray-400 block">← Login sebagai Super Admin</a>
            <a href="/login-customer" class="text-xs text-gray-500 hover:text-gray-400 block">Login sebagai Customer →</a>
        </div>
    </div>
</body>
</html>
