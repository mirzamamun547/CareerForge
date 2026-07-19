<x-guest-layout>
    <x-slot name="title">Maintenance - CareerForge</x-slot>

    <div class="auth-card rounded-3xl p-8 sm:p-10 text-center">

        <div class="flex items-center justify-center gap-3 mb-7">
            <svg class="w-8 h-8 text-[#2563EB]" fill="currentColor" viewBox="0 0 24 24">
                <path d="M20 6h-4V4c0-1.11-.89-2-2-2h-4c-1.11 0-2 .89-2 2v2H4c-1.11 0-1.99.89-1.99 2L2 19c0 1.11.89 2 2 2h16c1.11 0 2-.89 2-2V8c0-1.11-.89-2-2-2zm-8-2h4v2h-4V4zm8 15H4V8h16v11z"/>
            </svg>
            <span class="text-2xl font-extrabold text-[#0f172a] tracking-tight">CareerForge</span>
        </div>

        <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center mx-auto mb-5">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#D97706" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.42 15.17 17.25 21A2.652 2.652 0 0 0 21 17.25l-5.877-5.877M11.42 15.17l2.496-3.03c.317-.384.74-.626 1.208-.766M11.42 15.17l-4.655 5.653a2.548 2.548 0 1 1-3.586-3.586l6.837-5.63m5.108-.233c.55-.164 1.163-.188 1.743-.14a4.5 4.5 0 0 0 4.486-6.336l-3.276 3.277a3.004 3.004 0 0 1-2.25-2.25l3.276-3.276a4.5 4.5 0 0 0-6.336 4.486c.091 1.076-.071 2.264-.904 2.95l-.102.085m-1.745 1.437L5.909 7.5H4.5L1.5 3l1.5-1.5L7.5 4.5v1.409l4.26 4.26m-1.745 1.437 1.745-1.437m6.615 8.206L15.75 15.75M4.867 19.125h.008v.008h-.008v-.008Z" />
            </svg>
        </div>

        <h2 class="text-xl font-extrabold text-[#0f172a]">We'll be right back</h2>
        <p class="text-sm text-[#64748b] font-medium mt-2 leading-relaxed">
            CareerForge is temporarily down for maintenance.<br>
            Please check back again shortly &mdash; we're sorry for the inconvenience.
        </p>

        <form method="POST" action="{{ route('logout') }}" class="mt-7">
            @csrf
            <button type="submit" class="text-sm font-bold text-[#2563EB] hover:underline">
                Log out
            </button>
        </form>
    </div>
</x-guest-layout>