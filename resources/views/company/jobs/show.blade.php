@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-3">
        <a href="{{ route('company.jobs.index') ?? '#' }}" class="btn btn-secondary btn-sm">&larr; رجوع لقائمة الوظائف</a>
    </div>
    <div class="card shadow-sm p-4">
        <h3>تفاصيل الوظيفة</h3>
        <hr>
        <p><strong>المسمى الوظيفي:</strong> {{ $job->title ?? 'اسم الوظيفة' }}</p>
        <p><strong>القسم:</strong> {{ $job->department ?? 'غير محدد' }}</p>
        <p><strong>المتطلبات:</strong> {{ $job->requirements ?? 'لا توجد متطلبات مضافة' }}</p>
        <p><strong>الحالة:</strong> <span class="badge bg-success">{{ $job->status ?? 'نشط' }}</span></p>
    </div>
</div>
@endsection