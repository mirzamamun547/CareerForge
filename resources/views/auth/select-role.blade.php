<x-guest-layout>
    <x-slot name="title">Select Role - CareerForge</x-slot>

    <div class="auth-card rounded-3xl p-8 sm:p-10">

        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="flex items-center justify-center gap-3">
                <svg class="w-8 h-8 text-[#2563EB]" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-8-2h4v2h-4V4zm8 15H4V8h16v11z"/>
                </svg>
                <span class="text-2xl font-extrabold text-[#0f172a] tracking-tight">CareerForge</span>
            </div>
            <h2 class="text-2xl font-extrabold text-[#0f172a] tracking-tight mt-6">Create Your Account</h2>
            <p class="text-sm text-[#64748b] font-semibold mt-1">Select the account type that best describes you</p>
        </div>

        <!-- Role Options -->
        <div class="space-y-4">

            <!-- Student Card -->
            <a href="/register/student" class="selection-card group flex items-center gap-4 p-5 rounded-2xl border border-[#e2e8f0] bg-white cursor-pointer hover:border-[#2563EB] transition-all">
                <div class="w-12 h-12 rounded-full bg-[#eff6ff] flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#2563EB" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a23.838 23.838 0 0 0-1.012 5.434c3.604-1.27 7.38-2.036 11.276-2.24m-11.276-3.194A23.298 23.298 0 0 1 12 3.54c4.32 0 8.394 1.17 11.876 3.213M3.846 9.86a48.99 48.99 0 0 1 7.427-.658m0 0a48.68 48.68 0 0 1 7.427.658" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-base font-bold text-[#0f172a] group-hover:text-[#2563EB] transition-colors">I am a Student</div>
                    <div class="text-xs text-[#64748b] font-medium mt-1 leading-relaxed">Find jobs, build your profile, upload resume and apply.</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#cbd5e1" class="w-4 h-4 shrink-0 group-hover:stroke-[#2563EB] group-hover:translate-x-0.5 transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            <!-- Employer Card -->
            <a href="/register/employer" class="selection-card group flex items-center gap-4 p-5 rounded-2xl border border-[#e2e8f0] bg-white cursor-pointer hover:border-[#2563EB] transition-all">
                <div class="w-12 h-12 rounded-full bg-[#ecfdf5] flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#059669" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-base font-bold text-[#0f172a] group-hover:text-[#059669] transition-colors">I am an Employer</div>
                    <div class="text-xs text-[#64748b] font-medium mt-1 leading-relaxed">Post jobs, find candidates and build your team.</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#cbd5e1" class="w-4 h-4 shrink-0 group-hover:stroke-[#059669] group-hover:translate-x-0.5 transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            <!-- Admin Card -->
            <a href="/login/admin" class="selection-card group flex items-center gap-4 p-5 rounded-2xl border border-[#e2e8f0] bg-white cursor-pointer hover:border-[#2563EB] transition-all">
                <div class="w-12 h-12 rounded-full bg-[#fffbeb] flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#d97706" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="text-base font-bold text-[#0f172a] group-hover:text-[#d97706] transition-colors">I am an Admin</div>
                    <div class="text-xs text-[#64748b] font-medium mt-1 leading-relaxed">Manage the platform, users, jobs and reports.</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#cbd5e1" class="w-4 h-4 shrink-0 group-hover:stroke-[#d97706] group-hover:translate-x-0.5 transition-all">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

        </div>

        <!-- Footer -->
        <div class="text-center mt-8 pt-5 border-t border-[#e2e8f0]">
            <p class="text-sm text-[#64748b]">
                Already have an account?
                <a href="/login" class="font-bold text-[#2563EB] hover:underline">Login</a>
            </p>
        </div>

    </div>
</x-guest-layout>
