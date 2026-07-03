<x-guest-layout>
    <!-- ══════════════════════════════════════════
         Screen 1 – Login Selection
         CareerForge / Choose Your Portal
         ══════════════════════════════════════════ -->
    <div class="auth-card rounded-3xl p-8 sm:p-10" style="box-shadow: 0 4px 40px rgba(0,0,0,0.07);">

        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex flex-col items-center gap-3 group">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, #4F46E5, #7C3AED); box-shadow: 0 8px 24px rgba(79,70,229,0.30);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:1.15rem; font-weight:800; color:#111827; letter-spacing:-0.02em; line-height:1.2;">CareerForge</div>
                    <div style="font-size:0.62rem; font-weight:700; letter-spacing:0.1em; color:#4F46E5; text-transform:uppercase; margin-top:1px;">Shape Your Future</div>
                </div>
            </a>

            <div class="mt-6">
                <h1 style="font-size:1.5rem; font-weight:800; color:#111827; margin:0 0 4px;">Welcome Back</h1>
                <p style="font-size:0.875rem; color:#6B7280; font-weight:500; margin:0;">Choose Your Portal</p>
            </div>
        </div>

        <!-- Portal Selection Cards -->
        <div style="display:flex; flex-direction:column; gap:12px;">

            <!-- Student Login -->
            <a href="/login/student" id="portal-student"
               class="selection-card"
               style="display:flex; align-items:center; gap:16px; padding:16px; border-radius:16px;
                      border:1.5px solid #E5E7EB; background:#fff; text-decoration:none;">
                <div style="width:48px; height:48px; border-radius:14px; background:#EEF2FF; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#4F46E5" style="width:24px;height:24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a23.838 23.838 0 0 0-1.012 5.434c3.604-1.27 7.38-2.036 11.276-2.24m-11.276-3.194A23.298 23.298 0 0 1 12 3.54c4.32 0 8.394 1.17 11.876 3.213M3.846 9.86a48.99 48.99 0 0 1 7.427-.658m0 0a48.68 48.68 0 0 1 7.427.658" />
                    </svg>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:0.9rem; font-weight:700; color:#111827;">🎓 Student Login</div>
                    <div style="font-size:0.75rem; color:#9CA3AF; margin-top:2px;">Access your student dashboard</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#D1D5DB" style="width:18px;height:18px;flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            <!-- Employer Login -->
            <a href="/login/employer" id="portal-employer"
               class="selection-card"
               style="display:flex; align-items:center; gap:16px; padding:16px; border-radius:16px;
                      border:1.5px solid #E5E7EB; background:#fff; text-decoration:none;">
                <div style="width:48px; height:48px; border-radius:14px; background:#ECFDF5; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#059669" style="width:24px;height:24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:0.9rem; font-weight:700; color:#111827;">🏢 Employer Login</div>
                    <div style="font-size:0.75rem; color:#9CA3AF; margin-top:2px;">Manage your company portal</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#D1D5DB" style="width:18px;height:18px;flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            <!-- Admin Login -->
            <a href="/login/admin" id="portal-admin"
               class="selection-card"
               style="display:flex; align-items:center; gap:16px; padding:16px; border-radius:16px;
                      border:1.5px solid #E5E7EB; background:#fff; text-decoration:none;">
                <div style="width:48px; height:48px; border-radius:14px; background:#FFFBEB; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#D97706" style="width:24px;height:24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                    </svg>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:0.9rem; font-weight:700; color:#111827;">🛡 Admin Login</div>
                    <div style="font-size:0.75rem; color:#9CA3AF; margin-top:2px;">System administration panel</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#D1D5DB" style="width:18px;height:18px;flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

        </div>

        <!-- Footer -->
        <div style="text-align:center; margin-top:28px; padding-top:20px; border-top:1px solid #F3F4F6;">
            <p style="font-size:0.875rem; color:#6B7280; margin:0;">
                Don't have an account?
                <a href="/register" style="font-weight:700; color:#4F46E5; text-decoration:none; margin-left:4px;">Register</a>
            </p>
        </div>

    </div>
</x-guest-layout>
