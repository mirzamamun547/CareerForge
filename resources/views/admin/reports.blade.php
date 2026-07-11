@extends('layouts.admin')

@section('title', 'Reports & Analytics')
@section('header_title', 'Reports & Analytics')
@section('header_subtitle', 'Platform-wide trends and recruitment funnel')

@section('content')
<div class="row g-3 mb-3">
    <!-- Application Funnel -->
    <div class="col-12 col-lg-7">
        <div class="card-custom p-4 h-100">
            <div class="section-title">
                <i class="bi bi-filter" style="color:var(--indigo);"></i>
                Application Funnel
            </div>
            <div class="d-flex flex-column gap-3 mt-3">
                @php
    $maxFunnel = (int) max(array_column($funnel, 'count'));
    $maxFunnel = $maxFunnel > 0 ? $maxFunnel : 1;
@endphp
                @foreach($funnel as $f)
                    @php $pct = $f['count'] / $maxFunnel * 100; @endphp
                    <div class="funnel-row">
                        <div class="funnel-label">{{ $f['label'] }}</div>
                        <div class="funnel-bar-wrap">
                            <div class="funnel-bar" style="width:{{ $pct }}%; background:{{ $f['color'] }};"></div>
                        </div>
                        <div class="funnel-count">{{ $f['count'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Monthly Applications -->
    <div class="col-12 col-lg-5">
        <div class="card-custom p-4 h-100">
            <div class="section-title">
                <i class="bi bi-graph-up-arrow" style="color:var(--indigo);"></i>
                Monthly Applications
            </div>
            <div class="bar-chart-wrap" id="appsChart" style="height: 180px;">
                @php
    $maxApps = max(array_column($appsMonthly, 'v'));
    $maxApps = $maxApps > 0 ? $maxApps : 1;
@endphp
                @foreach($appsMonthly as $d)
                    @php $pct = $d['v'] / $maxApps * 100; @endphp
                    <div class="bar-col">
                        <div class="bar-col-fill" style="height:{{ $pct }}%; background:var(--emerald);"></div>
                        <div class="bar-col-label">{{ $d['m'] }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<div class="row g-3">
    <!-- Top Employers -->
    <div class="col-12 col-md-6">
        <div class="card-custom p-4 h-100">
            <div class="section-title">
                <i class="bi bi-building" style="color:var(--indigo);"></i>
                Top Employers
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Jobs Posted</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topEmployers as $emp)
                        <tr>
                            <td style="font-weight:700;">{{ $emp->company_name }}</td>
                            <td>{{ $emp->job_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-3 text-secondary">No employers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Top Universities -->
    <div class="col-12 col-md-6">
        <div class="card-custom p-4 h-100">
            <div class="section-title">
                <i class="bi bi-mortarboard-fill" style="color:var(--indigo);"></i>
                Top Universities
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>University</th>
                        <th>Students</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($topUniversities as $uni)
                        <tr>
                            <td style="font-weight:700;">{{ $uni->university }}</td>
                            <td>{{ $uni->student_count }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="2" class="text-center py-3 text-secondary">No universities found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
