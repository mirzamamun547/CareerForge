<x-guest-layout>

    <div class="auth-card rounded-3xl p-8 sm:p-10" style="box-shadow: 0 4px 40px rgba(0,0,0,0.07);">

     
        <div class="text-center mb-8">
            <a href="/" class="inline-flex flex-col items-center gap-3">
                <div class="w-14 h-14 rounded-2xl flex items-center justify-center"
                     style="background: linear-gradient(135deg, #4F46E5, #7C3AED); box-shadow: 0 8px 24px rgba(79,70,229,0.30);">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-7 h-7">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </div>
                <div>
                    <div style="font-size:1.15rem; font-weight:800; color:#111827; letter-spacing:-0.02em; line-height:1.2;">CareerForge</div>
                    <div style="font-size:0.62rem; font-weight:700; letter-spacing:0.1em; color:#4F46E5; text-transform:uppercase; margin-top:1px;">Shape Your Future</div>
                </div>
            </a>

            <div class="mt-6">
                <h1 style="font-size:1.5rem; font-weight:800; color:#111827; margin:0 0 4px;">Create Account</h1>
                <p style="font-size:0.875rem; color:#6B7280; font-weight:500; margin:0;">Choose Account Type</p>
            </div>
        </div>

      
        <div style="display:flex; flex-direction:column; gap:14px;">

        
            <a href="/register/student" id="reg-student"
               class="selection-card"
               style="display:flex; align-items:center; gap:18px; padding:20px; border-radius:18px;
                      border:1.5px solid #E5E7EB; background:#fff; text-decoration:none;">
                <div style="width:56px; height:56px; border-radius:16px; background: linear-gradient(135deg,#EEF2FF,#E0E7FF); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#4F46E5" style="width:28px;height:28px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a23.838 23.838 0 0 0-1.012 5.434c3.604-1.27 7.38-2.036 11.276-2.24m-11.276-3.194A23.298 23.298 0 0 1 12 3.54c4.32 0 8.394 1.17 11.876 3.213M3.846 9.86a48.99 48.99 0 0 1 7.427-.658m0 0a48.68 48.68 0 0 1 7.427.658" />
                    </svg>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:1rem; font-weight:700; color:#111827;">🎓 I am a Student</div>
                    <div style="font-size:0.78rem; color:#9CA3AF; margin-top:3px; line-height:1.4;">Find jobs, build your profile and apply.</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#C7D2FE" style="width:20px;height:20px;flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

      
            <a href="/register/employer" id="reg-employer"
               class="selection-card"
               style="display:flex; align-items:center; gap:18px; padding:20px; border-radius:18px;
                      border:1.5px solid #E5E7EB; background:#fff; text-decoration:none;">
                <div style="width:56px; height:56px; border-radius:16px; background: linear-gradient(135deg,#ECFDF5,#D1FAE5); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="#059669" style="width:28px;height:28px;">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                    </svg>
                </div>
                <div style="flex:1; min-width:0;">
                    <div style="font-size:1rem; font-weight:700; color:#111827;">🏢 I am an Employer</div>
                    <div style="font-size:0.78rem; color:#9CA3AF; margin-top:3px; line-height:1.4;">Post jobs, find candidates and build your team.</div>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="#A7F3D0" style="width:20px;height:20px;flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </a>

        </div>

    
        <div style="text-align:center; margin-top:28px; padding-top:20px; border-top:1px solid #F3F4F6;">
            <p style="font-size:0.875rem; color:#6B7280; margin:0;">
                Already have an account?
                <a href="/" style="font-weight:700; color:#4F46E5; text-decoration:none; margin-left:4px;">Login</a>
            </p>
        </div>

    </div>
</x-guest-layout>
