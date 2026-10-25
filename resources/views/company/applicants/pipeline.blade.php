@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>مراحل تقدم المتقدمين (Applicants Pipeline)</h2>
    </div>

    <div class="row">
        <!-- كمثال لتقسيم المراحل -->
        <div class="col-md-3">
            <div class="card bg-light shadow-sm">
                <div class="card-header bg-primary text-white font-weight-bold">الطلبات الجديدة (New)</div>
                <div class="card-body" style="min-height: 400px; max-height: 600px; overflow-y: auto;">
                    @isset($newApplicants)
                        @foreach($newApplicants as $applicant)
                            <div class="card mb-2 shadow-sm">
                                <div class="card-body p-2">
                                    <h6 class="card-title mb-1">{{ $applicant->name ?? 'اسم المتقدم' }}</h6>
                                    <p class="card-text text-muted small mb-1">{{ $applicant->email ?? '' }}</p>
                                    <a href="{{ route('company.applicants.show', $applicant->id ?? 1) }}" class="btn btn-sm btn-outline-primary">عرض الملف</a>
                                </div>
                            </div>
                        @endforeach
                    @endisset
                </div>
            </div>
        </div>
        <!-- يمكنك تكرار الأجزاء دي لباقي المراحل: المقابلة، الاختبار، القبول -->
    </div>
</div>
@endsection