<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl font-bold text-slate-900">Lupa Password?</h2>
        <p class="text-xs text-slate-500 mt-1">Masukkan alamat email Anda untuk menerima link reset password</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">
                Alamat Email
            </label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="nama@example.com"
                   class="w-full rounded-xl border-slate-200 text-sm focus:border-blue-500 focus:ring-blue-500 shadow-sm transition">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full py-2.5 px-4 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md shadow-blue-500/20 transition">
                Kirim Link Reset Password
            </button>
        </div>
    </form>

    <div class="mt-6 pt-6 border-t border-slate-100 text-center">
        <a href="{{ route('login') }}" class="text-xs font-semibold text-blue-600 hover:text-blue-800 transition">
            &larr; Kembali ke halaman Login
        </a>
    </div>
</x-guest-layout>
