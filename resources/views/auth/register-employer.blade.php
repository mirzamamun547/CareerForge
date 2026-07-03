<x-guest-layout>
    <x-slot name="title">Employer Registration - CareerForge</x-slot>

    <div class="auth-card rounded-3xl p-8 sm:p-10">

        <!-- Logo & Heading -->
        <div class="text-center mb-7">
            <div class="flex items-center justify-center gap-3">
                <svg class="w-8 h-8 text-[#2563EB]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-8-2h4v2h-4V4zm8 15H4V8h16v11z"/>
                </svg>
                <span class="text-2xl font-extrabold text-[#0f172a] tracking-tight">CareerForge</span>
            </div>
            <h2 class="text-xl font-extrabold text-[#0f172a] mt-6">Employer Registration</h2>
            <p class="text-xs text-[#64748b] font-semibold mt-1">Create your employer account</p>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="role" value="employer">

            <!-- Company Logo -->
            <div>
                <label class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Company Logo <span class="text-gray-400 font-medium">(Optional)</span></label>
                <label class="upload-area rounded-lg p-3 flex flex-col items-center gap-1.5 cursor-pointer bg-white border border-[#cbd5e1]">
                    <img id="logo-preview" src="" alt="Preview" class="w-14 h-14 rounded-lg object-cover hidden">
                    <div class="upload-placeholder flex flex-col items-center gap-1">
                        <div class="w-8 h-8 rounded-full bg-gray-50 flex items-center justify-center border border-gray-200">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#9CA3AF" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909M2.25 18V6a2.25 2.25 0 0 1 2.25-2.25h15A2.25 2.25 0 0 1 21.75 6v12A2.25 2.25 0 0 1 19.5 20.25H4.5A2.25 2.25 0 0 1 2.25 18Z" />
                            </svg>
                        </div>
                        <span style="font-size: 11px;" class="text-[#64748b] font-semibold">Click to upload logo</span>
                    </div>
                    <input type="file" name="company_logo" accept="image/*" class="hidden" onchange="previewFile(this, 'logo-preview')">
                </label>
            </div>

            <!-- Company Name -->
            <div>
                <label for="company_name" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Company Name</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                        </svg>
                    </span>
                    <input type="text" name="company_name" id="company_name" value="{{ old('company_name') }}" required
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter company name">
                </div>
                @error('company_name') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Company Email -->
            <div>
                <label for="company_email" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Company Email</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                    </span>
                    <input type="email" name="company_email" id="company_email" value="{{ old('company_email') }}" required
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter company email">
                </div>
                @error('company_email') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Website -->
            <div>
                <label for="website" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Website <span class="text-gray-400 font-medium">(Optional)</span></label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                        </svg>
                    </span>
                    <input type="url" name="website" id="website" value="{{ old('website') }}"
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter website">
                </div>
                @error('website') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Industry -->
            <div>
                <label for="industry" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Industry</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                    </span>
                    <select name="industry" id="industry" required
                            class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] outline-none transition-all appearance-none cursor-pointer">
                        <option value="" disabled {{ old('industry') ? '' : 'selected' }}>Select industry</option>
                        <option value="Technology" {{ old('industry') == 'Technology' ? 'selected' : '' }}>Technology</option>
                        <option value="Finance" {{ old('industry') == 'Finance' ? 'selected' : '' }}>Finance & Banking</option>
                        <option value="Healthcare" {{ old('industry') == 'Healthcare' ? 'selected' : '' }}>Healthcare</option>
                        <option value="Education" {{ old('industry') == 'Education' ? 'selected' : '' }}>Education</option>
                        <option value="Manufacturing" {{ old('industry') == 'Manufacturing' ? 'selected' : '' }}>Manufacturing</option>
                        <option value="Retail" {{ old('industry') == 'Retail' ? 'selected' : '' }}>Retail & E-commerce</option>
                        <option value="Telecommunications" {{ old('industry') == 'Telecommunications' ? 'selected' : '' }}>Telecommunications</option>
                        <option value="Construction" {{ old('industry') == 'Construction' ? 'selected' : '' }}>Construction</option>
                        <option value="Media" {{ old('industry') == 'Media' ? 'selected' : '' }}>Media & Entertainment</option>
                        <option value="Consulting" {{ old('industry') == 'Consulting' ? 'selected' : '' }}>Consulting</option>
                        <option value="Other" {{ old('industry') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8] pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </span>
                </div>
                @error('industry') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Company Address -->
            <div>
                <label for="company_address" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Company Address</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-3 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                    </span>
                    <textarea name="company_address" id="company_address" rows="2" required
                              class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all resize-none"
                              placeholder="Enter company address">{{ old('company_address') }}</textarea>
                </div>
                @error('company_address') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
            </div>

            <!-- Contact Person -->
            <div>
                <label for="contact_person" class="block text-xs font-bold text-[#334155] uppercase tracking-wide mb-1.5">Contact Person</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#94a3b8]">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-[18px] h-[18px]">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </span>
                    <input type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}" required
                           class="auth-input w-full pl-10 pr-4 py-2.5 bg-white border border-[#cbd5e1] rounded-lg text-sm text-[#0f172a] placeholder-[#94a3b8] transition-all"
                           placeholder="Enter contact person name">
                </div>
                @error('contact_person') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
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
                           placeholder="Enter phone number">
                </div>
                @error('phone') <p class="text-xs text-red-500 mt-1 font-medium">{{ $message }}</p> @enderror
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
            <button type="submit" id="btn-create-employer"
                    class="w-full py-3 rounded-lg bg-[#2563EB] hover:bg-[#1d4ed8] text-white text-sm font-bold shadow-sm transition-all mt-2">
                Create Employer Account
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
