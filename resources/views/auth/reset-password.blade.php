<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Harsasetialiving</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 min-h-screen flex items-center justify-center">
    <div class="bg-[#111827] p-8 rounded-2xl shadow-xl w-full max-w-md border border-gray-800">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-[#0d9488] rounded-xl flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Reset Password</h1>
            <p class="text-gray-400 text-sm mt-1">Masukkan password baru Anda</p>
        </div>

        @if(session('status'))
            <div class="bg-green-500/10 border border-green-500/20 text-green-400 px-4 py-3 rounded-xl text-sm mb-4">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm mb-4">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            
            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required 
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]"
                    value="{{ old('email', request()->get('email')) }}">
            </div>

            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Password Baru</label>
                <input type="password" name="password" required 
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]"
                    placeholder="Minimal 8 karakter">
            </div>

            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" required 
                    class="w-full bg-gray-800 border border-gray-700 rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]"
                    placeholder="Ulangi password baru">
            </div>

            <button type="submit" 
                class="w-full bg-[#0d9488] hover:bg-[#0f766e] text-white font-semibold py-3 rounded-xl transition-colors">
                Reset Password
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="/login-simple" class="text-xs text-gray-500 hover:text-gray-400">← Kembali ke Login</a>
        </div>
    </div>
</body>
</html>
