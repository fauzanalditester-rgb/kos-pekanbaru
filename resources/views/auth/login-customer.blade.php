<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Login - SewaVIP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0d9488] min-h-screen flex items-center justify-center">
    <div class="bg-[#111827] p-8 rounded-2xl shadow-xl w-full max-w-md border border-[#0d9488]/30">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-[#0d9488] rounded-xl flex items-center justify-center mx-auto mb-4 shadow-lg shadow-[#0d9488]/30">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h1 class="text-2xl font-bold text-white">Customer</h1>
            <p class="text-[#0d9488] text-sm mt-1">Portal Penyewa</p>
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

        <form method="POST" action="{{ route('login.customer.post') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-gray-400 text-sm font-medium mb-2">Email</label>
                <input type="email" name="email" required 
                    class="w-full bg-gray-800 border {{ $errors->has('email') ? 'border-red-500' : 'border-gray-700' }} rounded-xl px-4 py-3 text-white focus:outline-none focus:border-[#0d9488]"
                    value="{{ old('email') }}">
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
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
                class="w-full bg-[#0d9488] hover:bg-[#0f766e] text-white font-semibold py-3 rounded-xl transition-colors shadow-lg shadow-[#0d9488]/30">
                Masuk sebagai Customer
            </button>
        </form>

        <div class="mt-4 text-center space-y-2">
            <a href="/forgot-password" class="text-xs text-[#0d9488] hover:text-[#0f766e] block">Lupa Password?</a>
            <a href="/login-admin" class="text-xs text-gray-500 hover:text-gray-400 block">← Login sebagai Admin</a>
        </div>
    </div>
</body>
</html>
