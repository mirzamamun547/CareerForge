<x-guest-layout>
    <x-slot name="title">Login - CareerForge</x-slot>

    <div class="auth-card rounded-3xl p-8 sm:p-10">

        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-3">
                <svg class="w-8 h-8 text-[#2563EB]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-8-2h4v2h-4V4zm8 15H4V8h16v11z"/>
                </svg>
                <span class="text-2xl font-extrabold text-[#0f172a] tracking-tight">CareerForge</span>
            </div>
            <h2 class="text-2xl font-extrabold text-[#0f172a] tracking-tight mt-6">Welcome Back!</h2>
            <p class="text-sm text-[#64748b] font-semibold mt-1">Login to your account</p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Email Address</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </span>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter your email">
                </div>
                @error('email') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Password</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </span>
                    <input type="password" id="password" name="password" required
                           class="auth-input w-full pl-10 pr-12 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter your password">
                    <button type="button" onclick="togglePassword('password', this)" class="password-toggle">
                        <svg class="eye-open w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="eye-closed hidden w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center gap-2">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-[#cbd5e1] text-[#2563EB] focus:ring-[#2563EB] cursor-pointer">
                <label for="remember" class="text-sm text-[#475569] font-medium cursor-pointer">Remember me</label>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-3 rounded-lg bg-[#2563EB] hover:bg-[#1d4ed8] text-white text-sm font-bold shadow-sm transition-all">
                Login
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6 pt-5 border-t border-[#e2e8f0]">
            <p class="text-sm text-[#64748b]">
                Don't have an account?
                <a href="/register" class="font-bold text-[#2563EB] hover:underline">Register</a>
            </p>
            <p class="text-xs text-[#94a3b8] mt-2">
                Logging in as an employer or admin?
                <a href="{{ route('login.select') }}" class="font-semibold text-[#2563EB] hover:underline">Choose your portal</a>
            </p>
        </div>

    </div>
</x-guest-layout>
