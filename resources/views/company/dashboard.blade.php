@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>لوحة تحكم الشركة (Company Dashboard)</h2>
        <p class="text-muted">مرحباً بك في نظام إدارة التوظيف والموارد البشرية.</p>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <div class="card bg-primary text-white shadow-sm p-3">
                <h5>إجمالي الوظائف</h5>
                <h3>{{ $jobsCount ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-success text-white shadow-sm p-3">
                <h5>إجمالي المتقدمين</h5>
                <h3>{{ $applicantsCount ?? 0 }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card bg-info text-white shadow-sm p-3">
                <h5>المقابلات المجدولة</h5>
                <h3>{{ $interviewsCount ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection
