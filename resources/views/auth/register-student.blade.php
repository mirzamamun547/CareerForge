<x-guest-layout>
    <x-slot name="title">Student Registration - CareerForge</x-slot>

    <div class="auth-card rounded-3xl p-8 sm:p-10">

        <!-- Logo & Header -->
        <div class="text-center mb-7">
            <div class="flex items-center justify-center gap-3">
                <svg class="w-8 h-8 text-[#2563EB]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-8-2h4v2h-4V4zm8 15H4V8h16v11z"/>
                </svg>
                <span class="text-2xl font-extrabold text-[#0f172a] tracking-tight">CareerForge</span>
            </div>
            <h2 class="text-xl font-extrabold text-[#0f172a] mt-6">Student Registration</h2>
            <p class="text-xs text-[#64748b] font-semibold mt-1">Create your student account</p>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="student">

            <!-- Profile Picture -->
            <div>
                <label class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Profile Picture <span class="text-gray-400 font-medium">(Optional)</span></label>
                <label class="upload-area rounded-lg p-3 flex flex-col items-center gap-1.5 cursor-pointer bg-white border border-[#cbd5e1]">
                    <img id="profile-preview" src="" alt="Preview" class="w-14 h-14 rounded-full object-cover hidden">
                    <div class="upload-placeholder flex flex-col items-center gap-1">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center border border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9CA3AF" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.827 6.175A2.31 2.31 0 0 1 5.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 0 0-1.134-.175 2.31 2.31 0 0 1-1.64-1.055l-.822-1.316a2.192 2.192 0 0 0-1.736-1.039 48.774 48.774 0 0 0-5.232 0 2.192 2.192 0 0 0-1.736 1.039l-.821 1.316Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 12.75a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                            </svg>
                        </div>
                        <span style="font-size: 11px;" class="text-[#64748b] font-semibold">Click to upload photo</span>
                    </div>
                    <input type="file" name="profile_picture" accept="image/*" class="hidden" onchange="previewFile(this, 'profile-preview')">
                </label>
            </div>

            <!-- Full Name -->
            <div>
                <label for="name" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Full Name</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </span>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter your full name">
                </div>
                @error('name') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Email Address</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </span>
                    <input type="email" name="email" id="email" value="{{ old('email') }}" required
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter your email">
                </div>
                @error('email') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Phone Number -->
            <div>
                <label for="phone" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Phone Number</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                        </svg>
                    </span>
                    <input type="tel" name="phone" id="phone" value="{{ old('phone') }}" required
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter your phone number">
                </div>
                @error('phone') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- University -->
            <div>
                <label for="university" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">University</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21v-8.25M15.75 21v-8.25M8.25 21v-8.25M3 9l9-6 9 6m-1.5 12V10.332A48.36 48.36 0 0 0 12 9.75c-2.551 0-5.056.2-7.5.582V21" />
                        </svg>
                    </span>
                    <input type="text" name="university" id="university" value="{{ old('university') }}" required
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter your university">
                </div>
                @error('university') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Department -->
            <div>
                <label for="department" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Department</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.098 19.902a3.75 3.75 0 0 0 5.304 0l6.401-6.402M6.75 21A3.75 3.75 0 0 1 3 17.25V4.125C3 3.504 3.504 3 4.125 3h5.25c.621 0 1.125.504 1.125 1.125v4.072M6.75 21a3.75 3.75 0 0 0 3.75-3.75V8.197M6.75 21h13.125c.621 0 1.125-.504 1.125-1.125v-5.25c0-.621-.504-1.125-1.125-1.125h-4.072M10.5 8.197l2.88-2.88c.438-.439 1.15-.439 1.59 0l3.712 3.713c.44.44.44 1.152 0 1.59l-2.879 2.88M6.75 17.25h.008v.008H6.75v-.008Z" />
                        </svg>
                    </span>
                    <input type="text" name="department" id="department" value="{{ old('department') }}" required
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter your department">
                </div>
                @error('department') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Graduation Year -->
            <div>
                <label for="graduation_year" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Graduation Year</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                        </svg>
                    </span>
                    <select name="graduation_year" id="graduation_year" required
                            class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] outline-none transition-all appearance-none cursor-pointer">
                        <option value="" disabled {{ old('graduation_year') ? '' : 'selected' }}>Select graduation year</option>
                        @for ($year = date('Y') + 5; $year >= date('Y') - 10; $year--)
                            <option value="{{ $year }}" {{ old('graduation_year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endfor
                    </select>
                    <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8] pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </div>
                @error('graduation_year') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
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
                    <input type="password" name="password" id="password" required
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

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Confirm Password</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                        </svg>
                    </span>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="auth-input w-full pl-10 pr-12 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Confirm your password">
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="password-toggle">
                        <svg class="eye-open w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <svg class="eye-closed hidden w-[18px] h-[18px]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                        </svg>
                    </button>
                </div>
                @error('password_confirmation') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Terms Checkbox -->
            <div class="flex items-start gap-2.5 pt-1">
                <input type="checkbox" name="terms" id="terms" required
                       class="mt-0.5 w-4 h-4 rounded border-gray-300 text-[#2563EB] focus:ring-[#2563EB] cursor-pointer">
                <label for="terms" class="text-xs text-[#64748b] leading-relaxed cursor-pointer">
                    I agree to the <a href="#" class="text-[#2563EB] font-semibold hover:underline">Terms & Conditions</a> and <a href="#" class="text-[#2563EB] font-semibold hover:underline">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit -->
            <button type="submit" class="w-full py-3 rounded-lg bg-[#2563EB] hover:bg-[#1d4ed8] text-white text-sm font-bold shadow-sm transition-all mt-2">
                Create Student Account
            </button>
        </form>

        <!-- Footer -->
        <div class="text-center mt-6 pt-5 border-t border-[#e2e8f0]">
            <p class="text-sm text-[#64748b]">
                Already have an account?
                <a href="/login" class="font-bold text-[#2563EB] hover:underline">Login</a>
            </p>
        </div>

    </div>
</x-guest-layout>
