<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>CareerForge - Shape Your Future</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Scripts -->
        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <script src="https://cdn.tailwindcss.com"></script>
            <script>
                tailwind.config = {
                    theme: {
                        extend: {
                            fontFamily: {
                                sans: ['Plus Jakarta Sans', 'ui-sans-serif', 'system-ui', '-apple-system', 'BlinkMacSystemFont', 'Segoe UI', 'Roboto', 'Helvetica Neue', 'Arial', 'sans-serif'],
                            },
                        }
                    }
                }
            </script>
        @endif

        <!-- Alpine.js CDN for interactive features (e.g. FAQ and Tabs) -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            .glass-nav {
                background: rgba(255, 255, 255, 0.8);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-8px); }
            }
            .animate-float {
                animation: float 5s ease-in-out infinite;
            }
            /* Custom Scrollbar */
            ::-webkit-scrollbar {
                width: 8px;
            }
            ::-webkit-scrollbar-track {
                background: #f1f5f9;
            }
            ::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 4px;
            }
            ::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }
        </style>
    </head>
    <body class="bg-[#F8FAFC] text-[#0F172A] min-h-screen flex flex-col selection:bg-indigo-600 selection:text-white overflow-x-hidden">
        
        <!-- Navigation Header -->
        <header class="sticky top-0 w-full glass-nav z-50 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
                <!-- Logo -->
                <a href="/" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-md shadow-indigo-200 transition-transform group-hover:scale-105">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="white" class="w-5.5 h-5.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                        </svg>
                    </div>
                    <div>
                        <span class="text-lg font-extrabold tracking-tight text-slate-900 block leading-tight">CareerForge</span>
                        <span class="text-[9px] text-indigo-600 font-bold tracking-wider uppercase block">Shape Your Future</span>
                    </div>
                </a>

                <!-- Mid Links -->
                <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-slate-600">
                    <a href="#features" class="hover:text-indigo-600 transition-colors">Features</a>
                    <a href="#jobs" class="hover:text-indigo-600 transition-colors">Find Jobs</a>
                    <a href="#how-it-works" class="hover:text-indigo-600 transition-colors">How it Works</a>
                    <a href="#role-portals" class="hover:text-indigo-600 transition-colors">Portals</a>
                    <a href="#faq" class="hover:text-indigo-600 transition-colors">FAQs</a>
                </nav>

                <!-- Action Buttons -->
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition-all">
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-4 py-2 text-sm font-bold text-slate-700 hover:text-indigo-600 transition-colors">
                                Login
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-100 hover:shadow-lg transition-all">
                                    Register
                                </a>
                            @endif
                        @endauth
                    @else
                        <a href="/login" class="px-4 py-2 text-sm font-bold text-slate-700 hover:text-indigo-600 transition-colors">
                            Login
                        </a>
                        <a href="/register" class="px-5 py-2.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-100 hover:shadow-lg transition-all">
                            Register
                        </a>
                    @endif
                </div>
            </div>
        </header>

        <!-- Hero Section -->
        <main class="w-full relative overflow-hidden bg-gradient-to-b from-indigo-50/40 via-white to-[#F8FAFC]">
            <!-- Decorative Backlight -->
            <div class="absolute w-[500px] h-[500px] rounded-full bg-indigo-200/20 blur-3xl -top-20 -left-20"></div>
            <div class="absolute w-[400px] h-[400px] rounded-full bg-purple-200/20 blur-3xl bottom-10 right-0"></div>

            <div class="max-w-7xl mx-auto px-6 pt-16 pb-24 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center relative z-10">
                <!-- Hero Left Side -->
                <div class="lg:col-span-6 flex flex-col gap-6 text-left">
                    <!-- Premium Tag -->
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-50 border border-indigo-100/60 w-fit">
                        <span class="flex h-2 w-2 relative">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-indigo-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-indigo-600"></span>
                        </span>
                        <span class="text-xs font-bold text-indigo-700">✨ Powered by AI Review Feedback</span>
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-[1.12]">
                        Build Skills.<br>
                        Perfect Your Resume.<br>
                        <span class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 bg-clip-text text-transparent">Forge Your Future.</span>
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 leading-relaxed max-w-xl">
                        CareerForge is a complete platform for student career building. Optimize your resume with interactive AI guidance, showcase your verified credentials, and match with verified employers.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap items-center gap-4 mt-2">
                        <a href="/register" class="px-7 py-4 text-sm font-extrabold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-100 hover:shadow-xl hover:-translate-y-0.5 transition-all flex items-center gap-2">
                            Get Started Free
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                        <a href="#jobs" class="px-7 py-4 text-sm font-extrabold text-slate-700 hover:text-indigo-600 bg-white border border-slate-200 hover:border-indigo-200 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all flex items-center gap-2">
                            Explore Jobs
                        </a>
                    </div>

                    <!-- User Trust stats -->
                    <div class="flex items-center gap-4 mt-6 pt-6 border-t border-slate-100">
                        <div class="flex -space-x-3">
                            <div class="w-9 h-9 rounded-full border-2 border-white bg-indigo-600 text-white flex items-center justify-center text-[11px] font-bold">JD</div>
                            <div class="w-9 h-9 rounded-full border-2 border-white bg-emerald-500 text-white flex items-center justify-center text-[11px] font-bold">AM</div>
                            <div class="w-9 h-9 rounded-full border-2 border-white bg-amber-500 text-white flex items-center justify-center text-[11px] font-bold">KP</div>
                            <div class="w-9 h-9 rounded-full border-2 border-white bg-pink-500 text-white flex items-center justify-center text-[11px] font-bold">SR</div>
                        </div>
                        <div>
                            <div class="flex items-center text-amber-500 gap-0.5">
                                @for ($i = 0; $i < 5; $i++)
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5">
                                        <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-xs text-slate-500 font-semibold mt-0.5">
                                Joined by <span class="text-slate-800 font-bold">10k+ students</span> and top local employers.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Hero Right Side: Interactive Mockup Panel -->
                <div class="lg:col-span-6 flex items-center justify-center" x-data="{ currentTab: 'skills' }">
                    <div class="relative w-full max-w-lg bg-white border border-slate-200/80 rounded-2xl shadow-xl overflow-hidden animate-float">
                        <!-- Browser Header controls -->
                        <div class="bg-slate-50 border-b border-slate-200/80 px-4 py-3 flex items-center justify-between">
                            <div class="flex gap-1.5">
                                <span class="w-3 h-3 rounded-full bg-rose-400 block"></span>
                                <span class="w-3 h-3 rounded-full bg-amber-400 block"></span>
                                <span class="w-3 h-3 rounded-full bg-emerald-400 block"></span>
                            </div>
                            <!-- Mock Tab buttons -->
                            <div class="flex bg-slate-200/60 p-0.5 rounded-lg text-xs font-bold gap-1">
                                <button @click="currentTab = 'skills'" :class="currentTab === 'skills' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-2.5 py-1 rounded-md transition-all">Skill Radar</button>
                                <button @click="currentTab = 'resume'" :class="currentTab === 'resume' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-2.5 py-1 rounded-md transition-all">Resume Score</button>
                                <button @click="currentTab = 'jobs'" :class="currentTab === 'jobs' ? 'bg-white text-indigo-600 shadow-sm' : 'text-slate-600 hover:text-slate-900'" class="px-2.5 py-1 rounded-md transition-all">Matches</button>
                            </div>
                        </div>

                        <!-- Panel Workspace Content -->
                        <div class="p-6 h-72 bg-gradient-to-br from-slate-50 to-white select-none">
                            
                            <!-- Skill tab workspace -->
                            <div x-show="currentTab === 'skills'" class="h-full flex flex-col justify-between">
                                <div>
                                    <div class="flex justify-between items-center mb-1">
                                        <h4 class="text-xs font-bold text-slate-800">Your Core Strengths</h4>
                                        <span class="text-[10px] font-bold text-indigo-600 bg-indigo-50 px-2 py-0.5 rounded-full">Top 5%</span>
                                    </div>
                                    <p class="text-[10px] text-slate-500 mb-4">Verified skills from custom assessments</p>
                                </div>
                                <div class="space-y-3 flex-1 flex flex-col justify-center">
                                    <div>
                                        <div class="flex justify-between text-[10px] font-bold text-slate-700 mb-1">
                                            <span>Laravel Backend Development</span>
                                            <span>92%</span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2">
                                            <div class="bg-indigo-600 h-2 rounded-full" style="width: 92%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-[10px] font-bold text-slate-700 mb-1">
                                            <span>Relational Database Architecture</span>
                                            <span>85%</span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2">
                                            <div class="bg-indigo-500 h-2 rounded-full" style="width: 85%"></div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="flex justify-between text-[10px] font-bold text-slate-700 mb-1">
                                            <span>Tailwind CSS / UI Styling</span>
                                            <span>78%</span>
                                        </div>
                                        <div class="w-full bg-slate-200 rounded-full h-2">
                                            <div class="bg-purple-600 h-2 rounded-full" style="width: 78%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Resume Score tab workspace -->
                            <div x-show="currentTab === 'resume'" class="h-full flex items-center justify-between gap-6" x-transition>
                                <div class="flex-1 flex flex-col justify-between h-full">
                                    <div>
                                        <h4 class="text-xs font-bold text-slate-800">AI Resume Vetting</h4>
                                        <p class="text-[10px] text-slate-500 mt-0.5">Real-time improvements recommended</p>
                                    </div>
                                    <div class="space-y-2 mt-2">
                                        <div class="flex items-start gap-1.5 text-[9px] text-emerald-700 font-semibold bg-emerald-50 p-1.5 rounded-lg">
                                            <span>✅</span>
                                            <span>Quantified impact in project section.</span>
                                        </div>
                                        <div class="flex items-start gap-1.5 text-[9px] text-amber-700 font-semibold bg-amber-50 p-1.5 rounded-lg">
                                            <span>💡</span>
                                            <span>Add three more keywords from job listing.</span>
                                        </div>
                                    </div>
                                    <div class="text-[9px] text-slate-400">Checked 4 seconds ago.</div>
                                </div>
                                <div class="w-1/3 flex flex-col items-center justify-center">
                                    <!-- Radial progress wheel -->
                                    <div class="relative w-24 h-24 flex items-center justify-center">
                                        <svg class="absolute w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                            <path class="text-slate-100" stroke-width="3" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                            <path class="text-emerald-500" stroke-width="3.2" stroke-dasharray="88, 100" stroke-linecap="round" stroke="currentColor" fill="none" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" />
                                        </svg>
                                        <div class="flex flex-col items-center justify-center">
                                            <span class="text-xl font-extrabold text-slate-800 leading-none">88</span>
                                            <span class="text-[8px] font-bold text-slate-400 uppercase tracking-widest mt-0.5">Score</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] text-emerald-600 font-bold mt-2">Highly Ready</span>
                                </div>
                            </div>

                            <!-- Match Rate tab workspace -->
                            <div x-show="currentTab === 'jobs'" class="h-full flex flex-col justify-between" x-transition>
                                <div>
                                    <h4 class="text-xs font-bold text-slate-800">Direct Role Matching</h4>
                                    <p class="text-[10px] text-slate-500">Automated relevance analysis</p>
                                </div>
                                <div class="bg-white border border-slate-100 rounded-xl p-3 shadow-sm flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-xs font-bold text-indigo-600">S</div>
                                        <div>
                                            <div class="text-[10px] font-bold text-slate-900 leading-tight">Senior Laravel Engineer</div>
                                            <div class="text-[8px] text-slate-400 font-medium">Stripe • Remote</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs font-extrabold text-indigo-600">94% Match</div>
                                        <div class="text-[7px] text-indigo-500 bg-indigo-50 font-bold px-1.5 py-0.5 rounded-full inline-block mt-0.5">High Fit</div>
                                    </div>
                                </div>
                                <div class="bg-white border border-slate-100 rounded-xl p-3 shadow-sm flex items-center justify-between">
                                    <div class="flex items-center gap-2.5">
                                        <div class="w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-xs font-bold text-emerald-600">F</div>
                                        <div>
                                            <div class="text-[10px] font-bold text-slate-900 leading-tight">Frontend Architect</div>
                                            <div class="text-[8px] text-slate-400 font-medium">Figma • San Francisco</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="text-xs font-extrabold text-slate-500">72% Match</div>
                                        <div class="text-[7px] text-slate-400 bg-slate-100 font-bold px-1.5 py-0.5 rounded-full inline-block mt-0.5">Medium Fit</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Features Grid Section -->
        <section id="features" class="w-full bg-white border-y border-slate-100 py-20 relative">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Heading -->
                <div class="text-center max-w-2xl mx-auto flex flex-col gap-3 mb-16">
                    <span class="text-xs text-indigo-600 font-extrabold uppercase tracking-widest">Premium Features</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">Everything you need to advance your career</h2>
                    <p class="text-slate-500 text-sm sm:text-base leading-relaxed">CareerForge provides intelligent tools to align student strengths with recruiter needs.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                    <!-- Feature 1 -->
                    <div class="flex flex-col items-start gap-4 p-5 rounded-2xl border border-slate-100 hover:border-indigo-100 bg-[#FAFAFC] hover:bg-white hover:shadow-lg hover:shadow-indigo-100/30 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100/30 flex items-center justify-center text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5.5 h-5.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">Skill Assessments</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Evaluate your core strengths against current job taxonomy parameters.</p>
                    </div>

                    <!-- Feature 2 -->
                    <div class="flex flex-col items-start gap-4 p-5 rounded-2xl border border-slate-100 hover:border-indigo-100 bg-[#FAFAFC] hover:bg-white hover:shadow-lg hover:shadow-indigo-100/30 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100/30 flex items-center justify-center text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5.5 h-5.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a3 3 0 0 0-3-3H9.75a3 3 0 0 0-3 3v5.25m3-5.25v5.25m3-5.25V9m0 9v-5.25M12 9a3 3 0 1 1 0-6 3 3 0 0 1 0 6Zm0 9H6.75A2.25 2.25 0 0 1 4.5 15.75V9m15 6.75H17.25a2.25 2.25 0 0 0-2.25-2.25M21 9a3 3 0 1 0-6 0 3 3 0 0 0 6 0Zm-3 0V9m0 9v-5.25" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">AI Resume Scorer</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Instantly analyze your PDF resume against real-world employer listings.</p>
                    </div>

                    <!-- Feature 3 -->
                    <div class="flex flex-col items-start gap-4 p-5 rounded-2xl border border-slate-100 hover:border-indigo-100 bg-[#FAFAFC] hover:bg-white hover:shadow-lg hover:shadow-indigo-100/30 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100/30 flex items-center justify-center text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5.5 h-5.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5.586a1 1 0 0 1 .707.293l5.414 5.414a1 1 0 0 1 .293.707V19a2 2 0 0 1-2 2Z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">Resume Reviewing</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Request review feedback from administrators and professional mentors.</p>
                    </div>

                    <!-- Feature 4 -->
                    <div class="flex flex-col items-start gap-4 p-5 rounded-2xl border border-slate-100 hover:border-indigo-100 bg-[#FAFAFC] hover:bg-white hover:shadow-lg hover:shadow-indigo-100/30 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100/30 flex items-center justify-center text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5.5 h-5.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">Direct Applications</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Apply directly to jobs with your verified student profile.</p>
                    </div>

                    <!-- Feature 5 -->
                    <div class="flex flex-col items-start gap-4 p-5 rounded-2xl border border-slate-100 hover:border-indigo-100 bg-[#FAFAFC] hover:bg-white hover:shadow-lg hover:shadow-indigo-100/30 transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 border border-indigo-100/30 flex items-center justify-center text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="currentColor" class="w-5.5 h-5.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5m-9-6h.008v.008H12v-.008ZM12 15h.008v.008H12V15Zm0 2.25h.008v.008H12v-.008ZM9.75 15h.008v.008H9.75V15Zm0 2.25h.008v.008H9.75v-.008ZM7.5 15h.008v.008H7.5V15Zm0 2.25h.008v.008H7.5v-.008Zm6.75-4.5h.008v.008h-.008v-.008Zm0 2.25h.008v.008h-.008V15Zm0 2.25h.008v.008h-.008v-.008Zm2.25-4.5h.008v.008H16.5v-.008Zm0 2.25h.008v.008H16.5V15Z" />
                            </svg>
                        </div>
                        <h3 class="text-base font-extrabold text-slate-900">Interview Scheduling</h3>
                        <p class="text-xs text-slate-500 leading-relaxed">Seamlessly lock in dates and times with recruiters directly on portal.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Jobs Section -->
        <section id="jobs" class="w-full py-20 bg-slate-50 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-6">
                
                <!-- Heading -->
                <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
                    <div class="flex flex-col gap-3">
                        <span class="text-xs text-indigo-600 font-extrabold uppercase tracking-widest">Active Openings</span>
                        <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">Featured Opportunities</h2>
                        <p class="text-slate-500 text-sm max-w-xl">Apply with your verified skills profile to stand out from the crowd.</p>
                    </div>
                    <a href="/register" class="mt-4 md:mt-0 text-sm font-extrabold text-indigo-600 hover:text-indigo-700 inline-flex items-center gap-1">
                        View all active listings
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <!-- Jobs Display Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @if (isset($featuredJobs) && $featuredJobs->count() > 0)
                        <!-- Dynamic Job Cards from DB -->
                        @foreach ($featuredJobs as $job)
                            <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between h-full">
                                <div>
                                    <!-- Header: Company & Location -->
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-3">
                                            <!-- Initials Logo -->
                                            <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center font-extrabold text-indigo-600 text-sm">
                                                {{ strtoupper(substr($job->user->employerProfile->company_name ?? $job->user->name, 0, 2)) }}
                                            </div>
                                            <div>
                                                <h4 class="text-sm font-bold text-slate-800 flex items-center gap-1">
                                                    {{ $job->user->employerProfile->company_name ?? 'Verified Partner' }}
                                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-emerald-500">
                                                        <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.748-5.25Z" clip-rule="evenodd" />
                                                    </svg>
                                                </h4>
                                                <span class="text-[11px] text-slate-500 font-semibold">{{ $job->city ? $job->city.', '.$job->country : $job->location }}</span>
                                            </div>
                                        </div>
                                        <span class="text-[10px] font-bold px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-full">{{ $job->job_type }}</span>
                                    </div>

                                    <!-- Job Title -->
                                    <h3 class="text-base font-extrabold text-slate-900 mb-2 hover:text-indigo-600 transition-colors">
                                        <a href="/student/jobs/{{ $job->id }}">{{ $job->title }}</a>
                                    </h3>

                                    <!-- Short Description -->
                                    <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4">
                                        {{ Str::limit(strip_tags($job->description), 140) }}
                                    </p>
                                </div>

                                <div>
                                    <!-- Salary / Skills footer -->
                                    <div class="border-t border-slate-100 pt-4 flex flex-col gap-3">
                                        @if ($job->skills)
                                            <div class="flex flex-wrap gap-1.5">
                                                @foreach (array_slice(explode(',', $job->skills), 0, 3) as $skill)
                                                    <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">{{ trim($skill) }}</span>
                                                @endforeach
                                            </div>
                                        @endif

                                        <div class="flex items-center justify-between mt-1">
                                            <div>
                                                <span class="text-[10px] text-slate-400 font-bold block uppercase tracking-wider">Salary</span>
                                                <span class="text-xs font-extrabold text-slate-800">
                                                    @if($job->min_salary && $job->max_salary)
                                                        ${{ number_format($job->min_salary) }} - ${{ number_format($job->max_salary) }}
                                                    @else
                                                        Negotiable
                                                    @endif
                                                </span>
                                            </div>
                                            <a href="/student/jobs/{{ $job->id }}" class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all">
                                                Apply Now
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <!-- Fallback Placeholder Job Cards -->
                        <!-- Card 1: Google -->
                        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between h-full">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-red-50 border border-red-100 flex items-center justify-center font-extrabold text-red-600 text-sm">G</div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-1">
                                                Google LLC
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-emerald-500">
                                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.748-5.25Z" clip-rule="evenodd" />
                                                </svg>
                                            </h4>
                                            <span class="text-[11px] text-slate-500 font-semibold">Mountain View, CA (Remote)</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold px-2.5 py-1 bg-emerald-50 text-emerald-600 rounded-full">Full-time</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900 mb-2 hover:text-indigo-600 transition-colors">
                                    <a href="/register">Frontend Engineer (React / Tailwind)</a>
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4">
                                    Build clean, responsive, and performance-optimized layouts. Work alongside our core UX teams to optimize dashboard workflows and component designs.
                                </p>
                            </div>
                            <div>
                                <div class="border-t border-slate-100 pt-4 flex flex-col gap-3">
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">React</span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">Tailwind CSS</span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">JavaScript</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold block uppercase tracking-wider">Salary Range</span>
                                            <span class="text-xs font-extrabold text-slate-800">$120,000 - $150,000</span>
                                        </div>
                                        <a href="/register" class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all">
                                            Apply Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Stripe -->
                        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between h-full">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-indigo-50 border border-indigo-100 flex items-center justify-center font-extrabold text-indigo-600 text-sm">S</div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-1">
                                                Stripe
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-emerald-500">
                                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.748-5.25Z" clip-rule="evenodd" />
                                                </svg>
                                            </h4>
                                            <span class="text-[11px] text-slate-500 font-semibold">San Francisco, CA (Hybrid)</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold px-2.5 py-1 bg-indigo-50 text-indigo-600 rounded-full">Full-time</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900 mb-2 hover:text-indigo-600 transition-colors">
                                    <a href="/register">Senior Laravel Backend Architect</a>
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4">
                                    Manage our custom billing gateways and design high-availability internal APIs. Refactor old components and integrate secure endpoints.
                                </p>
                            </div>
                            <div>
                                <div class="border-t border-slate-100 pt-4 flex flex-col gap-3">
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">Laravel</span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">PHP 8.2</span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">APIs</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold block uppercase tracking-wider">Salary Range</span>
                                            <span class="text-xs font-extrabold text-slate-800">$140,000 - $180,000</span>
                                        </div>
                                        <a href="/register" class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all">
                                            Apply Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Figma -->
                        <div class="bg-white border border-slate-200/80 rounded-2xl p-6 shadow-sm hover:shadow-md hover:border-slate-300 transition-all duration-200 flex flex-col justify-between h-full">
                            <div>
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-orange-50 border border-orange-100 flex items-center justify-center font-extrabold text-orange-600 text-sm">F</div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800 flex items-center gap-1">
                                                Figma Inc.
                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-3.5 h-3.5 text-emerald-500">
                                                    <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.748-5.25Z" clip-rule="evenodd" />
                                                </svg>
                                            </h4>
                                            <span class="text-[11px] text-slate-500 font-semibold">New York, NY (Hybrid)</span>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-bold px-2.5 py-1 bg-amber-50 text-amber-600 rounded-full">Part-time</span>
                                </div>
                                <h3 class="text-base font-extrabold text-slate-900 mb-2 hover:text-indigo-600 transition-colors">
                                    <a href="/register">Product Designer</a>
                                </h3>
                                <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed mb-4">
                                    Collaborate on our collaborative whiteboarding solutions. Run user research sessions and construct complex UI component libraries.
                                </p>
                            </div>
                            <div>
                                <div class="border-t border-slate-100 pt-4 flex flex-col gap-3">
                                    <div class="flex flex-wrap gap-1.5">
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">Figma</span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">UI/UX Design</span>
                                        <span class="text-[9px] font-bold px-2 py-0.5 bg-slate-100 text-slate-600 rounded-md">Wireframing</span>
                                    </div>
                                    <div class="flex items-center justify-between mt-1">
                                        <div>
                                            <span class="text-[10px] text-slate-400 font-bold block uppercase tracking-wider">Salary Range</span>
                                            <span class="text-xs font-extrabold text-slate-800">$100,000 - $130,000</span>
                                        </div>
                                        <a href="/register" class="px-4 py-2 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-lg shadow-sm transition-all">
                                            Apply Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            </div>
        </section>

        <!-- Stepper: "How it Works" -->
        <section id="how-it-works" class="w-full py-20 bg-white relative">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Heading -->
                <div class="text-center max-w-2xl mx-auto flex flex-col gap-3 mb-16">
                    <span class="text-xs text-indigo-600 font-extrabold uppercase tracking-widest">Process Flow</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">Simple steps to launch your career</h2>
                    <p class="text-slate-500 text-sm leading-relaxed">We guide you through the process of building verified credentials and connecting with recruiters.</p>
                </div>

                <!-- Timeline Steps -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8 relative">
                    <!-- Step 1 -->
                    <div class="flex flex-col items-center md:items-start text-center md:text-left gap-4 relative">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-extrabold flex items-center justify-center shadow-lg shadow-indigo-100 relative z-10">1</div>
                        <h4 class="text-base font-extrabold text-slate-900">Create Profile</h4>
                        <p class="text-xs text-slate-500 leading-relaxed max-w-xs">Register as a student or employer, set up your credentials, and sync your bio.</p>
                    </div>

                    <!-- Step 2 -->
                    <div class="flex flex-col items-center md:items-start text-center md:text-left gap-4 relative">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-extrabold flex items-center justify-center shadow-lg shadow-indigo-100 relative z-10">2</div>
                        <h4 class="text-base font-extrabold text-slate-900">Get AI Resume Review</h4>
                        <p class="text-xs text-slate-500 leading-relaxed max-w-xs">Upload your resume and get immediate ratings and actionable tips from our AI evaluator.</p>
                    </div>

                    <!-- Step 3 -->
                    <div class="flex flex-col items-center md:items-start text-center md:text-left gap-4 relative">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-extrabold flex items-center justify-center shadow-lg shadow-indigo-100 relative z-10">3</div>
                        <h4 class="text-base font-extrabold text-slate-900">Add & Verify Skills</h4>
                        <p class="text-xs text-slate-500 leading-relaxed max-w-xs">Add skills to your profile and align them to our global taxonomy for high relevance matching.</p>
                    </div>

                    <!-- Step 4 -->
                    <div class="flex flex-col items-center md:items-start text-center md:text-left gap-4 relative">
                        <div class="w-10 h-10 rounded-full bg-indigo-600 text-white font-extrabold flex items-center justify-center shadow-lg shadow-indigo-100 relative z-10">4</div>
                        <h4 class="text-base font-extrabold text-slate-900">Interview & Get Hired</h4>
                        <p class="text-xs text-slate-500 leading-relaxed max-w-xs">Recruiters examine your verified score, schedule direct slots, and extend offers.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- "A Platform for Everyone" Section -->
        <section id="role-portals" class="w-full py-20 bg-slate-50 border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-6 flex flex-col items-center">
                
                <div class="text-center max-w-2xl flex flex-col gap-3 mb-16">
                    <span class="text-xs text-indigo-600 font-extrabold uppercase tracking-widest">Portals Selection</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">Tailored workspace portals</h2>
                    <p class="text-slate-500 text-sm sm:text-base leading-relaxed">Whether you're looking for roles, hiring talent, or managing taxonomies, we have a workspace for you.</p>
                </div>

                <!-- 3 Target Audience Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
                    
                    <!-- Card 1: Students -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-8 flex flex-col items-start gap-6 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7 1.138 3-3" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-2">Student Portal</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Upload resumes, check compatibility scores with AI, catalog verified skills, and apply to openings.</p>
                        </div>
                        <a href="/register" class="mt-auto px-5 py-3 text-xs font-bold text-indigo-600 bg-indigo-50/50 border border-indigo-100 hover:border-indigo-300 rounded-xl transition-all flex items-center gap-1.5">
                            Access Student Features
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 2: Employers -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-8 flex flex-col items-start gap-6 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v3m-6-15h.008v.008H6.75V3Zm3 0h.008v.008H9.75V3Zm3 0h.008v.008h-.008V3Zm3 0h.008v.008h-.008V3Zm3 0h.008v.008h-.008V3Zm3 0h.008v.008h-.008V3Z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-2">Employer Portal</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Establish verified company presence, publish job roles, inspect incoming candidates, and review resumes.</p>
                        </div>
                        <a href="/register" class="mt-auto px-5 py-3 text-xs font-bold text-emerald-600 bg-emerald-50/50 border border-emerald-100 hover:border-emerald-300 rounded-xl transition-all flex items-center gap-1.5">
                            Access Employer Features
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                    <!-- Card 3: Admins -->
                    <div class="bg-white border border-slate-200/80 rounded-2xl p-8 flex flex-col items-start gap-6 hover:shadow-lg transition-all duration-300">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 flex items-center justify-center text-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-extrabold text-slate-900 mb-2">Admin Dashboard</h3>
                            <p class="text-xs text-slate-500 leading-relaxed">Approve/reject employer accounts, resolve flagged content, regulate global system taxonomy, and monitor logs.</p>
                        </div>
                        <a href="/login/admin" class="mt-auto px-5 py-3 text-xs font-bold text-amber-600 bg-amber-50/50 border border-amber-100 hover:border-amber-300 rounded-xl transition-all flex items-center gap-1.5">
                            Access Admin Portal
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                            </svg>
                        </a>
                    </div>

                </div>

            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="w-full py-20 bg-white border-t border-slate-100">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Heading -->
                <div class="text-center max-w-2xl mx-auto flex flex-col gap-3 mb-16">
                    <span class="text-xs text-indigo-600 font-extrabold uppercase tracking-widest">Success Stories</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight leading-tight">Vetted and approved by our community</h2>
                    <p class="text-slate-500 text-sm leading-relaxed">See what students and employers are saying about the platform.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Testimonial 1 -->
                    <div class="bg-slate-50/50 border border-slate-200/50 rounded-2xl p-8 flex flex-col justify-between">
                        <p class="text-sm italic text-slate-600 leading-relaxed mb-6">
                            "The AI resume scorer on CareerForge gave me exactly the feedback I needed. It highlighted missing keywords and helped me restructure my projects. I got three interview invites within a week of polishing it."
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-700 font-bold flex items-center justify-center text-xs">AS</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Albin Smith</h4>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Computer Science Student</span>
                            </div>
                        </div>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="bg-slate-50/50 border border-slate-200/50 rounded-2xl p-8 flex flex-col justify-between">
                        <p class="text-sm italic text-slate-600 leading-relaxed mb-6">
                            "As an employer, vetting junior developers can be extremely time-consuming. CareerForge's verified skill metric and neat dashboard made it simple to spot top candidates immediately. Highly recommended platform."
                        </p>
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-full bg-emerald-100 text-emerald-700 font-bold flex items-center justify-center text-xs">MK</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-800">Mary K.</h4>
                                <span class="text-[10px] text-slate-400 font-bold uppercase tracking-wider">Hiring Director at InnovateTech</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Interactive FAQ Section -->
        <section id="faq" class="w-full py-20 bg-slate-50 border-t border-slate-100" x-data="{ active: null }">
            <div class="max-w-4xl mx-auto px-6">
                <!-- Heading -->
                <div class="text-center flex flex-col gap-3 mb-16">
                    <span class="text-xs text-indigo-600 font-extrabold uppercase tracking-widest">Questions</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 tracking-tight leading-tight">Frequently Asked Questions</h2>
                    <p class="text-slate-500 text-sm leading-relaxed">Got questions about CareerForge? We have answers.</p>
                </div>

                <!-- FAQ Accordion List -->
                <div class="space-y-4">
                    <!-- Q1 -->
                    <div class="bg-white border border-slate-200/80 rounded-xl overflow-hidden shadow-sm">
                        <button @click="active = active === 1 ? null : 1" class="w-full px-6 py-4 flex items-center justify-between font-bold text-left text-slate-800 text-sm sm:text-base hover:bg-slate-50/40 transition-colors">
                            <span>What is CareerForge?</span>
                            <span class="text-slate-400 transform transition-transform" :class="active === 1 ? 'rotate-180' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="active === 1" x-collapse class="px-6 pb-5 border-t border-slate-50 pt-3 text-xs sm:text-sm text-slate-500 leading-relaxed">
                            CareerForge is a comprehensive career readiness platform designed to help students bridge the gap between academia and professional careers. We offer AI-driven resume scoring, standardized skill assessments based on global taxonomies, and matching filters for verified recruiters.
                        </div>
                    </div>

                    <!-- Q2 -->
                    <div class="bg-white border border-slate-200/80 rounded-xl overflow-hidden shadow-sm">
                        <button @click="active = active === 2 ? null : 2" class="w-full px-6 py-4 flex items-center justify-between font-bold text-left text-slate-800 text-sm sm:text-base hover:bg-slate-50/40 transition-colors">
                            <span>How does the AI Resume review work?</span>
                            <span class="text-slate-400 transform transition-transform" :class="active === 2 ? 'rotate-180' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="active === 2" class="px-6 pb-5 border-t border-slate-50 pt-3 text-xs sm:text-sm text-slate-500 leading-relaxed">
                            When you upload your resume PDF in the Student portal, our analyzer processes your content against verified industry descriptors. We calculate an immediate compatibility score and provide inline bullet-point recommendations detailing missing skills, formatting improvements, and structural edits.
                        </div>
                    </div>

                    <!-- Q3 -->
                    <div class="bg-white border border-slate-200/80 rounded-xl overflow-hidden shadow-sm">
                        <button @click="active = active === 3 ? null : 3" class="w-full px-6 py-4 flex items-center justify-between font-bold text-left text-slate-800 text-sm sm:text-base hover:bg-slate-50/40 transition-colors">
                            <span>Is it free for students to use?</span>
                            <span class="text-slate-400 transform transition-transform" :class="active === 3 ? 'rotate-180' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="active === 3" class="px-6 pb-5 border-t border-slate-50 pt-3 text-xs sm:text-sm text-slate-500 leading-relaxed">
                            Yes! All core student activities—such as uploading your resume, requesting reviews, taking taxonomy skill assessments, tracking goals, and applying to job posts—are 100% free of charge.
                        </div>
                    </div>

                    <!-- Q4 -->
                    <div class="bg-white border border-slate-200/80 rounded-xl overflow-hidden shadow-sm">
                        <button @click="active = active === 4 ? null : 4" class="w-full px-6 py-4 flex items-center justify-between font-bold text-left text-slate-800 text-sm sm:text-base hover:bg-slate-50/40 transition-colors">
                            <span>How do employers verify their company profile?</span>
                            <span class="text-slate-400 transform transition-transform" :class="active === 4 ? 'rotate-180' : ''">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </span>
                        </button>
                        <div x-show="active === 4" class="px-6 pb-5 border-t border-slate-50 pt-3 text-xs sm:text-sm text-slate-500 leading-relaxed">
                            When an employer registers, they submit standard company profiles including address, website, and industry details. Administrators review these profiles in the Admin Dashboard, validating authenticity before allowing them to post active jobs, safeguarding students from spam listings.
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <!-- Final CTA Banner -->
        <section class="w-full py-16 bg-white relative">
            <div class="max-w-7xl mx-auto px-6">
                <div class="bg-gradient-to-r from-indigo-900 via-indigo-950 to-slate-900 rounded-3xl p-10 md:p-16 text-center text-white relative overflow-hidden shadow-xl">
                    <!-- Glow decor -->
                    <div class="absolute w-64 h-64 rounded-full bg-indigo-500/10 blur-3xl -top-12 -left-12"></div>
                    <div class="absolute w-64 h-64 rounded-full bg-purple-500/10 blur-3xl -bottom-12 -right-12"></div>

                    <div class="relative z-10 max-w-2xl mx-auto flex flex-col items-center gap-6">
                        <h2 class="text-3xl md:text-4xl font-extrabold tracking-tight">Ready to Forge Your Career?</h2>
                        <p class="text-slate-300 text-sm md:text-base leading-relaxed">
                            Get started today by creating your free student profile, uploading your resume, and matching with the perfect employer.
                        </p>
                        <div class="flex flex-wrap items-center justify-center gap-4 mt-2">
                            <a href="/register" class="px-6 py-3.5 text-xs md:text-sm font-extrabold text-indigo-900 bg-white hover:bg-slate-100 rounded-xl transition-all">
                                Create Free Account
                            </a>
                            <a href="/login" class="px-6 py-3.5 text-xs md:text-sm font-extrabold text-white bg-white/10 hover:bg-white/20 border border-white/20 rounded-xl transition-all">
                                Login Workspace
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- stats & sitemap footer -->
        <footer class="w-full bg-[#0F172A] text-white py-16 mt-auto border-t border-slate-800">
            <div class="max-w-7xl mx-auto px-6">
                <!-- Top statistics grid -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 pb-12 border-b border-slate-800">
                    <div class="flex flex-col items-start gap-1">
                        <span class="text-3xl font-extrabold text-indigo-400">10,000+</span>
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Registered Students</span>
                    </div>
                    <div class="flex flex-col items-start gap-1">
                        <span class="text-3xl font-extrabold text-emerald-400">2,500+</span>
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Verified Employers</span>
                    </div>
                    <div class="flex flex-col items-start gap-1">
                        <span class="text-3xl font-extrabold text-amber-400">5,000+</span>
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Active Jobs</span>
                    </div>
                    <div class="flex flex-col items-start gap-1">
                        <span class="text-3xl font-extrabold text-pink-400">25,000+</span>
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Applications Submitted</span>
                    </div>
                </div>

                <!-- Footer site details -->
                <div class="grid grid-cols-1 md:grid-cols-12 gap-8 pt-12 text-sm text-slate-400">
                    <div class="md:col-span-5 flex flex-col gap-4">
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="white" class="w-4.5 h-4.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                                </svg>
                            </div>
                            <span class="text-lg font-extrabold text-white tracking-tight">CareerForge</span>
                        </div>
                        <p class="text-xs text-slate-500 leading-relaxed max-w-sm">
                            CareerForge is an integrated platform enabling skills assessments, interactive resume reviews, roadmap development, and direct applicant matching.
                        </p>
                    </div>

                    <!-- Sitemap links -->
                    <div class="md:col-span-7 grid grid-cols-2 sm:grid-cols-3 gap-8">
                        <div class="flex flex-col gap-3">
                            <span class="text-xs font-bold text-white uppercase tracking-wider">Solutions</span>
                            <a href="#features" class="text-xs hover:text-white transition-colors">Features</a>
                            <a href="#jobs" class="text-xs hover:text-white transition-colors">Job Matching</a>
                            <a href="#how-it-works" class="text-xs hover:text-white transition-colors">AI Resume Review</a>
                        </div>
                        <div class="flex flex-col gap-3">
                            <span class="text-xs font-bold text-white uppercase tracking-wider">Portals</span>
                            <a href="/register/student" class="text-xs hover:text-white transition-colors">Student Entry</a>
                            <a href="/register/employer" class="text-xs hover:text-white transition-colors">Employer Entry</a>
                            <a href="/login/admin" class="text-xs hover:text-white transition-colors">Admin Gateway</a>
                        </div>
                        <div class="flex flex-col gap-3">
                            <span class="text-xs font-bold text-white uppercase tracking-wider">Legal</span>
                            <a href="#" class="text-xs hover:text-white transition-colors">Privacy Policy</a>
                            <a href="#" class="text-xs hover:text-white transition-colors">Terms of Service</a>
                            <a href="#" class="text-xs hover:text-white transition-colors">Cookie Settings</a>
                        </div>
                    </div>
                </div>

                <div class="border-t border-slate-800/80 mt-12 pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                    <span>&copy; {{ date('Y') }} CareerForge. All rights reserved.</span>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-slate-400 transition-colors">Twitter</a>
                        <a href="#" class="hover:text-slate-400 transition-colors">LinkedIn</a>
                        <a href="#" class="hover:text-slate-400 transition-colors">GitHub</a>
                    </div>
                </div>
            </div>
        </footer>

    </body>
</html>
