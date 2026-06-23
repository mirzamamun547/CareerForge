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
        <style>
            body {
                font-family: 'Plus Jakarta Sans', sans-serif;
            }
            .glass {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            .glass-dark {
                background: rgba(15, 15, 25, 0.85);
                backdrop-filter: blur(12px);
                -webkit-backdrop-filter: blur(12px);
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            @keyframes float-delayed {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(10px); }
            }
            .animate-float {
                animation: float 6s ease-in-out infinite;
            }
            .animate-float-delayed {
                animation: float-delayed 7s ease-in-out infinite;
            }
        </style>
    </head>
    <body class="bg-[#F8F9FD] text-[#1E1E2F] min-h-screen flex flex-col selection:bg-indigo-500 selection:text-white overflow-x-hidden">
        
        <!-- Navigation Header -->
        <header class="w-full max-w-7xl mx-auto px-6 py-5 flex items-center justify-between z-50">
            <!-- Logo -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center shadow-lg shadow-indigo-200 transition-transform group-hover:scale-105">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="white" class="w-5.5 h-5.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.25 9.75L16.5 12l-2.25 2.25m-4.5 0L7.5 12l2.25-2.25M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xl font-extrabold tracking-tight text-gray-900 block leading-tight">CareerForge</span>
                    <span class="text-[10px] text-gray-500 font-semibold tracking-wider uppercase block">Shape Your Future</span>
                </div>
            </a>

            <!-- Mid Links -->
            <nav class="hidden md:flex items-center gap-8 text-sm font-semibold text-gray-600">
                <a href="/" class="text-indigo-600 relative after:absolute after:bottom-[-6px] after:left-0 after:w-full after:h-0.5 after:bg-indigo-600">Home</a>
                <a href="#features" class="hover:text-indigo-600 transition-colors">Features</a>
                <a href="#students" class="hover:text-indigo-600 transition-colors">For Students</a>
                <a href="#employers" class="hover:text-indigo-600 transition-colors">For Employers</a>
                <a href="#resources" class="hover:text-indigo-600 transition-colors">Resources</a>
                <a href="#about" class="hover:text-indigo-600 transition-colors">About Us</a>
            </nav>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-100 hover:shadow-lg transition-all duration-200">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-100 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                                Register
                            </a>
                        @endif
                    @endauth
                @else
                    <!-- Fallback if no auth routes configured yet -->
                    <a href="#" class="px-5 py-2.5 text-sm font-semibold text-gray-700 hover:text-indigo-600 transition-colors">
                        Login
                    </a>
                    <a href="#" class="px-5 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-100 hover:shadow-lg hover:-translate-y-0.5 transition-all duration-200">
                        Register
                    </a>
                @endif
            </div>
        </header>

        <!-- Hero Section -->
        <main class="flex-1 w-full max-w-7xl mx-auto px-6 pt-8 pb-20 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center">
            
            <!-- Hero Left Side -->
            <div class="lg:col-span-6 flex flex-col gap-6 text-left">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-[1.15]">
                    Build Skills.<br>
                    Find Opportunities.<br>
                    <span class="text-indigo-600 bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Forge Your Future.</span>
                </h1>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed max-w-xl">
                    CareerForge is your all-in-one platform for career development, skill building, and finding the right job opportunities.
                </p>

                <!-- CTA Buttons -->
                <div class="flex flex-wrap items-center gap-4 mt-2">
                    <a href="#get-started" class="px-7 py-4 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-lg shadow-indigo-100 hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                        Get Started
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-4 h-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                    <a href="#jobs" class="px-7 py-4 text-sm font-bold text-indigo-600 hover:text-indigo-700 bg-white border border-gray-200 hover:border-indigo-300 rounded-xl shadow-sm hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                        Explore Jobs
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4.5 h-4.5 text-indigo-500">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.4V14.15m16.5 0c0-1.22-.821-2.278-2.02-2.565A8.24 8.24 0 0 0 12 10.5a8.24 8.24 0 0 0-6.23 1.085c-1.2 2.87-2.02 1.345-2.02 2.565m16.5 0a2.25 2.25 0 0 0-2.25-2.25H18.75m-15 0a2.25 2.25 0 0 0-2.25 2.25H5.25m13.5-3V7.5m-12 0V7.5" />
                        </svg>
                    </a>
                </div>

                <!-- Rating -->
                <div class="flex items-center gap-4 mt-6">
                    <!-- Overlapping Avatars (SVGs for premium clean look) -->
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-indigo-100 flex items-center justify-center text-xs font-bold text-indigo-600">JD</div>
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-emerald-100 flex items-center justify-center text-xs font-bold text-emerald-600">AM</div>
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-rose-100 flex items-center justify-center text-xs font-bold text-rose-600">SR</div>
                        <div class="w-10 h-10 rounded-full border-2 border-white bg-amber-100 flex items-center justify-center text-xs font-bold text-amber-600">KP</div>
                    </div>
                    <div>
                        <!-- Stars -->
                        <div class="flex items-center text-amber-400 gap-0.5">
                            @for ($i = 0; $i < 5; $i++)
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path fill-rule="evenodd" d="M10.788 3.21c.448-1.077 1.976-1.077 2.424 0l2.082 5.006 5.404.434c1.164.093 1.636 1.545.749 2.305l-4.117 3.527 1.257 5.273c.271 1.136-.964 2.033-1.96 1.425L12 18.354 7.373 21.18c-.996.608-2.231-.29-1.96-1.425l1.257-5.273-4.117-3.527c-.887-.76-.415-2.212.749-2.305l5.404-.434 2.082-5.005Z" clip-rule="evenodd" />
                                </svg>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-500 font-semibold mt-1">
                            <span class="text-gray-900 font-bold">4.8/5</span> from 2,000+ users
                        </p>
                    </div>
                </div>
            </div>

            <!-- Hero Right Side: Glassmorphic Dashboard Mockup -->
            <div class="lg:col-span-6 relative flex items-center justify-center min-h-[480px]">
                
                <!-- Glowing Decorative Background Gradients -->
                <div class="absolute w-72 h-72 rounded-full bg-indigo-400/20 blur-3xl -top-10 -left-10 animate-pulse"></div>
                <div class="absolute w-80 h-80 rounded-full bg-violet-400/20 blur-3xl -bottom-10 -right-10 animate-pulse"></div>
                
                <!-- Main Mockup Container -->
                <div class="relative w-full max-w-md mx-auto aspect-square flex items-center justify-center">
                    
                    <!-- Center Concept Illustration (Modern Flat Workspace) -->
                    <div class="w-64 h-64 rounded-3xl bg-indigo-50 border border-indigo-100/50 flex flex-col items-center justify-center p-6 shadow-inner">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-20 h-20 text-indigo-500 mb-4 animate-float-delayed">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        <h3 class="text-sm font-bold text-gray-800 text-center leading-tight">Interactive Platform</h3>
                        <p class="text-xs text-gray-500 text-center mt-1">Design & code directly in your browser.</p>
                    </div>

                    <!-- Floating Widgets -->
                    
                    <!-- 1. Skills Circle Card -->
                    <div class="absolute top-0 -left-6 glass border border-white/60 p-4 rounded-2xl shadow-xl w-44 animate-float">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-gray-700">My Skills</span>
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                        </div>
                        <!-- Donut Chart SVG -->
                        <div class="flex items-center gap-3">
                            <div class="relative w-12 h-12 flex items-center justify-center">
                                <svg class="w-full h-full transform -rotate-90">
                                    <circle cx="24" cy="24" r="18" stroke="#E0E7FF" stroke-width="4.5" fill="transparent"/>
                                    <circle cx="24" cy="24" r="18" stroke="#4F46E5" stroke-width="4.5" fill="transparent" stroke-dasharray="113" stroke-dashoffset="28"/>
                                </svg>
                                <span class="absolute text-[10px] font-bold text-indigo-600">75%</span>
                            </div>
                            <div>
                                <div class="text-[11px] font-bold text-gray-800">Technical</div>
                                <div class="text-[9px] text-gray-400">3 Categories</div>
                            </div>
                        </div>
                    </div>

                    <!-- 2. Job Match Card -->
                    <div class="absolute bottom-6 -left-8 glass border border-white/60 p-4 rounded-2xl shadow-xl w-48 animate-float-delayed">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-[11px] font-semibold text-gray-500">Job Match</span>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full">92%</span>
                        </div>
                        <div class="text-sm font-extrabold text-gray-800">Product Designer</div>
                        <!-- Graph Line SVG -->
                        <div class="mt-2 w-full h-10">
                            <svg viewBox="0 0 100 30" class="w-full h-full overflow-visible">
                                <path d="M0 25 C20 20, 40 5, 60 15 C80 25, 90 2, 100 5" fill="none" stroke="#10B981" stroke-width="2.5" stroke-linecap="round"/>
                                <path d="M0 25 C20 20, 40 5, 60 15 C80 25, 90 2, 100 5 L100 30 L0 30 Z" fill="url(#greenGradient)" opacity="0.1"/>
                                <defs>
                                    <linearGradient id="greenGradient" x1="0" y1="0" x2="0" y2="1">
                                        <stop offset="0%" stop-color="#10B981" />
                                        <stop offset="100%" stop-color="#10B981" stop-opacity="0" />
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                    </div>

                    <!-- 3. Roadmap Progress Card -->
                    <div class="absolute top-10 -right-8 glass border border-white/60 p-5 rounded-2xl shadow-xl w-52 animate-float-delayed">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-bold text-gray-800">Roadmap Progress</span>
                            <span class="text-xs font-bold text-indigo-600">75%</span>
                        </div>
                        <!-- Progress Bar -->
                        <div class="w-full h-2 bg-indigo-50 rounded-full mb-4 overflow-hidden">
                            <div class="h-full bg-indigo-600 rounded-full" style="width: 75%"></div>
                        </div>
                        <!-- Steps -->
                        <div class="flex flex-col gap-2">
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-indigo-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-2.5 h-2.5 text-white">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-semibold text-gray-700">HTML / CSS Foundations</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-indigo-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-2.5 h-2.5 text-white">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-semibold text-gray-700">JavaScript DOM Manipulation</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full bg-indigo-600 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-2.5 h-2.5 text-white">
                                        <path fill-rule="evenodd" d="M19.916 4.626a.75.75 0 0 1 .208 1.04l-9 13.5a.75.75 0 0 1-1.154.114l-6-6a.75.75 0 0 1 1.06-1.06l5.353 5.353 8.493-12.74a.75.75 0 0 1 1.04-.207Z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <span class="text-[10px] font-semibold text-gray-700">Vue.js / React Basics</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <div class="w-4 h-4 rounded-full border border-gray-300 flex items-center justify-center"></div>
                                <span class="text-[10px] font-semibold text-gray-400">Laravel MVC Architecture</span>
                            </div>
                        </div>
                    </div>

                    <!-- 4. Interactive Badges -->
                    <div class="absolute bottom-16 right-0 w-11 h-11 bg-rose-500 rounded-2xl shadow-lg shadow-rose-200 flex items-center justify-center animate-float">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="white" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7 1.138 3-3" />
                        </svg>
                    </div>

                    <div class="absolute top-24 left-1/2 -translate-x-1/2 w-11 h-11 bg-violet-600 rounded-2xl shadow-lg shadow-violet-200 flex items-center justify-center animate-float">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.2" stroke="white" class="w-5.5 h-5.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.4V14.15m16.5 0c0-1.22-.821-2.278-2.02-2.565A8.24 8.24 0 0 0 12 10.5a8.24 8.24 0 0 0-6.23 1.085c-1.2 2.87-2.02 1.345-2.02 2.565m16.5 0a2.25 2.25 0 0 0-2.25-2.25H18.75m-15 0a2.25 2.25 0 0 0-2.25 2.25H5.25m13.5-3V7.5m-12 0V7.5" />
                        </svg>
                    </div>

                </div>

            </div>

        </main>

        <!-- Features Grid Section -->
        <section id="features" class="w-full bg-white border-y border-gray-100 py-16">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-8">
                
                <!-- Feature 1 -->
                <div class="flex flex-col items-start gap-3 p-4 hover:-translate-y-1 transition-transform duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296 3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746 3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39 1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12 3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043 3.296A3.745 3.745 0 0 1 21 12Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Skill Assessments</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Evaluate your skills and identify areas to improve.</p>
                </div>

                <!-- Feature 2 -->
                <div class="flex flex-col items-start gap-3 p-4 hover:-translate-y-1 transition-transform duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 6.75h6m-6 4h6m-6 4h6m3 4H6a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Learning Roadmaps</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Personalized roadmaps to achieve your career goals.</p>
                </div>

                <!-- Feature 3 -->
                <div class="flex flex-col items-start gap-3 p-4 hover:-translate-y-1 transition-transform duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Job Readiness Tracker</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Track your progress and improve your job readiness.</p>
                </div>

                <!-- Feature 4 -->
                <div class="flex flex-col items-start gap-3 p-4 hover:-translate-y-1 transition-transform duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 .621-.504 1.125-1.125 1.125H4.875A1.125 1.125 0 0 1 3.75 18.4V14.15m16.5 0c0-1.22-.821-2.278-2.02-2.565A8.24 8.24 0 0 0 12 10.5a8.24 8.24 0 0 0-6.23 1.085c-1.2 2.87-2.02 1.345-2.02 2.565m16.5 0a2.25 2.25 0 0 0-2.25-2.25H18.75m-15 0a2.25 2.25 0 0 0-2.25 2.25H5.25m13.5-3V7.5m-12 0V7.5" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Job Opportunities</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Discover jobs that match your skills and interests.</p>
                </div>

                <!-- Feature 5 -->
                <div class="flex flex-col items-start gap-3 p-4 hover:-translate-y-1 transition-transform duration-200">
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a.75.75 0 0 1-1.074-.765 7.99 7.99 0 0 0 1.257-3.241C4.305 15.65 3 13.973 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Expert Feedback</h3>
                    <p class="text-sm text-gray-500 leading-relaxed">Get resume reviews and improve with expert advice.</p>
                </div>

            </div>
        </section>

        <!-- "A Platform for Everyone" Section -->
        <section class="w-full max-w-7xl mx-auto px-6 py-20 flex flex-col items-center">
            
            <div class="text-center max-w-2xl flex flex-col gap-3 mb-16">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-gray-900 tracking-tight">A Platform for Everyone</h2>
                <p class="text-gray-500 text-base leading-relaxed">Whether you're a student, employer, or admin, CareerForge has the right tools for you.</p>
            </div>

            <!-- 3 Target Audience Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 w-full">
                
                <!-- Card 1: Students -->
                <div id="students" class="bg-indigo-50/50 border border-indigo-100 rounded-3xl p-8 flex flex-col items-start gap-5 hover:shadow-lg hover:shadow-indigo-100/30 transition-all duration-300">
                    <!-- SVG Illustration -->
                    <div class="w-full h-40 bg-white border border-indigo-100/30 rounded-2xl flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-indigo-50/20"></div>
                        <!-- Student SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-20 h-20 text-indigo-600 relative z-10 animate-float">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.57 50.57 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7 1.138 3-3" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">For Students</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Build skills, take assessments, get resume reviews, and apply for jobs.</p>
                    </div>
                    <a href="#student-portal" class="mt-auto px-5 py-3 text-xs font-bold text-indigo-600 bg-white border border-indigo-100 hover:border-indigo-300 hover:bg-indigo-50/20 rounded-xl transition-all duration-200 flex items-center gap-2">
                        Explore Student Features
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <!-- Card 2: Employers -->
                <div id="employers" class="bg-emerald-50/50 border border-emerald-100 rounded-3xl p-8 flex flex-col items-start gap-5 hover:shadow-lg hover:shadow-emerald-100/30 transition-all duration-300">
                    <!-- SVG Illustration -->
                    <div class="w-full h-40 bg-white border border-emerald-100/30 rounded-2xl flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-emerald-50/20"></div>
                        <!-- Business/Employer SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-20 h-20 text-emerald-600 relative z-10 animate-float-delayed">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3a.75.75 0 0 1 .75-.75h3a.75.75 0 0 1 .75.75v3m-6-15h.008v.008H6.75V3Zm3 0h.008v.008H9.75V3Zm3 0h.008v.008h-.008V3Zm3 0h.008v.008h-.008V3Zm3 0h.008v.008h-.008V3Z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">For Employers</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Post jobs, manage applications, and find the best talent for your company.</p>
                    </div>
                    <a href="#employer-portal" class="mt-auto px-5 py-3 text-xs font-bold text-emerald-600 bg-white border border-emerald-100 hover:border-emerald-300 hover:bg-emerald-50/20 rounded-xl transition-all duration-200 flex items-center gap-2">
                        Explore Employer Features
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

                <!-- Card 3: Admins -->
                <div id="admins" class="bg-amber-50/50 border border-amber-100 rounded-3xl p-8 flex flex-col items-start gap-5 hover:shadow-lg hover:shadow-amber-100/30 transition-all duration-300">
                    <!-- SVG Illustration -->
                    <div class="w-full h-40 bg-white border border-amber-100/30 rounded-2xl flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 bg-amber-50/20"></div>
                        <!-- Admin/Analytics SVG -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-20 h-20 text-amber-600 relative z-10 animate-float">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10.5 6h9.75M10.5 6a1.5 1.5 0 1 1-3 0m3 0a1.5 1.5 0 1 0-3 0M3.75 6H7.5m3 12h9.75m-9.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-3.75 0H7.5m9-6h3.75m-3.75 0a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m-9.75 0h9.75" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">For Admins</h3>
                        <p class="text-sm text-gray-600 leading-relaxed">Manage users, jobs, skills, roadmaps, and platform analytics.</p>
                    </div>
                    <a href="#admin-portal" class="mt-auto px-5 py-3 text-xs font-bold text-amber-600 bg-white border border-amber-100 hover:border-amber-300 hover:bg-amber-50/20 rounded-xl transition-all duration-200 flex items-center gap-2">
                        Explore Admin Features
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-3 h-3">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                        </svg>
                    </a>
                </div>

            </div>

        </section>

        <!-- bottom stats section -->
        <footer class="w-full bg-[#181824] text-white py-12 mt-auto">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 divide-y md:divide-y-0 md:divide-x divide-gray-800">
                
                <!-- Stat 1 -->
                <div class="flex flex-col items-center md:items-start md:px-8 py-4 md:py-0 text-center md:text-left">
                    <span class="text-3xl sm:text-4xl font-extrabold text-indigo-400">10,000+</span>
                    <span class="text-sm text-gray-400 font-medium mt-1">Registered Students</span>
                </div>

                <!-- Stat 2 -->
                <div class="flex flex-col items-center md:items-start md:px-8 py-4 md:py-0 text-center md:text-left">
                    <span class="text-3xl sm:text-4xl font-extrabold text-emerald-400">2,500+</span>
                    <span class="text-sm text-gray-400 font-medium mt-1">Employers</span>
                </div>

                <!-- Stat 3 -->
                <div class="flex flex-col items-center md:items-start md:px-8 py-4 md:py-0 text-center md:text-left">
                    <span class="text-3xl sm:text-4xl font-extrabold text-amber-400">5,000+</span>
                    <span class="text-sm text-gray-400 font-medium mt-1">Active Jobs</span>
                </div>

                <!-- Stat 4 -->
                <div class="flex flex-col items-center md:items-start md:px-8 py-4 md:py-0 text-center md:text-left">
                    <span class="text-3xl sm:text-4xl font-extrabold text-violet-400">25,000+</span>
                    <span class="text-sm text-gray-400 font-medium mt-1">Applications Submitted</span>
                </div>

            </div>
        </footer>

    </body>
</html>
