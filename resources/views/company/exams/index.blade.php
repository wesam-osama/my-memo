@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>قائمة الامتحانات والتقييمات (Exams)</h2>
        <a href="{{ route('company.exams.create') ?? '#' }}" class="btn btn-primary">إنشاء امتحان جديد</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>عنوان الامتحان</th>
                        <th>الوظيفة المرتبطة</th>
                        <th>الدرجة النهائية</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($exams)
                        @forelse($exams as $exam)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $exam->title }}</td>
                                <td>{{ $exam->job->title ?? 'عام' }}</td>
                                <td>{{ $exam->total_marks ?? 100 }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-warning">تعديل</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">لا توجد امتحانات مضافة حتى الآن.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection