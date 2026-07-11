@extends('layouts.admin')

@section('title', 'Dashboard')
@section('header_title', 'Admin Dashboard')
@section('header_subtitle', 'Platform overview and quick actions')

@push('styles')
<style>
    .stat-card { transition: transform 0.18s, box-shadow 0.18s; }
    .stat-card:hover { transform: translateY(-3px); box-shadow: 0 8px 28px rgba(0,0,0,0.07) !important; }
    .bar-chart-wrap { display: flex; align-items: flex-end; gap: 0.85rem; height: 150px; padding-top: 0.5rem; }
    .bar-col { flex: 1; display: flex; flex-direction: column; align-items: center; gap: 0.45rem; height: 100%; justify-content: flex-end; }
    .bar-col-fill { width: 100%; max-width: 32px; border-radius: 0.4rem 0.4rem 0 0; transition: height 0.6s cubic-bezier(.4,0,.2,1); }
    .bar-col-label { font-size: 0.67rem; color: var(--muted); font-weight: 600; }
</style>
@endpush

@section('content')
<div class="row g-3 mb-3">
    <!-- Stat cards -->
    <div class="col-6 col-lg-3">
        <div class="card-custom p-4 stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:var(--indigo-bg); color:var(--indigo);">
                    <i class="bi bi-person-fill" style="font-size:1.1rem;"></i>
                </div>
                <span class="stat-trend trend-up"><i class="bi bi-arrow-up-right"></i> {{ $stats['studentGrowth'] }}%</span>
            </div>
            <div class="stat-value">{{ number_format($stats['students']) }}</div>
            <div class="text-secondary" style="font-size:0.78rem;font-weight:600;">Total Students</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-custom p-4 stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:var(--emerald-bg); color:var(--emerald);">
                    <i class="bi bi-building" style="font-size:1.1rem;"></i>
                </div>
                <span class="stat-trend trend-up"><i class="bi bi-arrow-up-right"></i> {{ $stats['employerGrowth'] }}%</span>
            </div>
            <div class="stat-value">{{ number_format($stats['employers']) }}</div>
            <div class="text-secondary" style="font-size:0.78rem;font-weight:600;">Total Employers</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-custom p-4 stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:var(--amber-bg); color:var(--amber);">
                    <i class="bi bi-briefcase-fill" style="font-size:1.1rem;"></i>
                </div>
                <span class="stat-trend trend-up"><i class="bi bi-arrow-up-right"></i> {{ $stats['jobGrowth'] }}%</span>
            </div>
            <div class="stat-value">{{ number_format($stats['activeJobs']) }}</div>
            <div class="text-secondary" style="font-size:0.78rem;font-weight:600;">Active Jobs</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="card-custom p-4 stat-card">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <div class="stat-icon" style="background:var(--rose-bg); color:var(--rose);">
                    <i class="bi bi-file-earmark-text-fill" style="font-size:1.1rem;"></i>
                </div>
                <span class="stat-trend trend-down"><i class="bi bi-arrow-down-right"></i> {{ $stats['appChange'] }}%</span>
            </div>
            <div class="stat-value">{{ number_format($stats['applications']) }}</div>
            <div class="text-secondary" style="font-size:0.78rem;font-weight:600;">Total Applications</div>
        </div>
    </div>
</div>

<div class="row g-3 mb-3">
    <!-- Monthly job postings chart -->
    <div class="col-12 col-lg-7">
        <div class="card-custom p-4 h-100">
            <div class="section-title">
                <i class="bi bi-bar-chart-fill" style="color:var(--indigo);"></i>
                Monthly Job Postings
            </div>
            <div class="bar-chart-wrap" id="jobsChart">
                @foreach($jobsMonthly as $d)
                    @php $pct = $d['v'] / max(array_column($jobsMonthly, 'v')) * 100; @endphp
                    <div class="bar-col">
                        <div class="bar-col-fill" style="height:{{ $pct }}%; background:var(--indigo);"></div>
                        <div class="bar-col-label">{{ $d['m'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Top skills -->
    <div class="col-12 col-lg-5">
        <div class="card-custom p-4 h-100">
            <div class="section-title">
                <i class="bi bi-lightning-fill" style="color:var(--indigo);"></i>
                Top Skills in Demand
            </div>
            @foreach($topSkills as $s)
            <div class="hbar-row">
                <div class="hbar-label">{{ $s['name'] }}</div>
                <div class="hbar-track"><div class="hbar-fill" style="width:{{ $s['pct'] }}%; background:{{ $s['color'] }};"></div></div>
                <div class="hbar-value">{{ $s['pct'] }}%</div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Recent activity -->
    <div class="col-12 col-lg-7">
        <div class="card-custom p-4 h-100">
            <div class="section-title">
                <i class="bi bi-clock-history" style="color:var(--indigo);"></i>
                Recent Activity
            </div>
            @foreach($recentActivity as $a)
            <div class="activity-item">
                <div class="activity-dot" style="background:{{ $a['bg'] }};">{{ $a['icon'] }}</div>
                <div>
                    <div class="activity-text">{!! $a['text'] !!}</div>
                    <div class="activity-time">{{ $a['time'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Needs attention -->
    <div class="col-12 col-lg-5">
        <div class="card-custom p-4 h-100">
            <div class="section-title">
                <i class="bi bi-exclamation-triangle-fill" style="color:var(--amber);"></i>
                Needs Your Attention
            </div>
            <ul class="attention-list">
                <li>
                    <span>Employer verifications pending</span>
                    <span class="badge-custom-amber">{{ $stats['pendingVerifications'] }}</span>
                </li>
                <li>
                    <span>Jobs reported by students</span>
                    <span class="badge-custom-rose">{{ $stats['reportedJobs'] }}</span>
                </li>
                <li>
                    <span>Resumes awaiting review</span>
                    <span class="badge-custom-indigo">{{ $stats['pendingResumes'] }}</span>
                </li>
                <li>
                    <span>Accounts flagged for review</span>
                    <span class="badge-custom-gray">{{ $stats['flaggedAccounts'] }}</span>
                </li>
            </ul>

            <div class="mt-4 pt-3" style="border-top:1px solid #F3F4F6;">
                <div class="section-title mb-2">
                    <i class="bi bi-arrow-up-right-circle-fill" style="color:var(--indigo);"></i>
                    Quick Actions
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admin.verification') }}" class="btn-primary-custom">
                        <i class="bi bi-envelope-check"></i> Review Verifications
                    </a>
                    <a href="{{ route('admin.resumes') }}" class="btn-ghost-custom">
                        <i class="bi bi-file-earmark-check"></i> Review Resumes
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
