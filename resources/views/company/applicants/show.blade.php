@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12 mb-3">
            <a href="{{ url()->previous() }}" class="btn btn-secondary btn-sm">&larr; رجوع للخلف</a>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm text-center p-3">
                <h4 class="mt-2">{{ $applicant->name ?? 'اسم المتقدم' }}</h4>
                <p class="text-muted">{{ $applicant->email ?? 'email@example.com' }}</p>
                <p class="text-muted">{{ $applicant->phone ?? '01000000000' }}</p>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm p-4">
                <h4>تفاصيل التقديم والـ CV</h4>
                <hr>
                <p><strong>الوظيفة المتقدم لها:</strong> {{ $applicant->job->title ?? 'غير محدد' }}</p>
                <p><strong>تاريخ التقديم:</strong> {{ $applicant->created_at ?? 'N/A' }}</p>
                <div class="mt-3">
                    <a href="#" class="btn btn-success">تحميل السيرة الذاتية (CV)</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection