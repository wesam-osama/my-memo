@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>محاولات الامتحان (Exam Attempts)</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المرشح</th>
                        <th>اسم الامتحان</th>
                        <th>حالة المحاولة</th>
                        <th>وقت البدء</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($attempts)
                        @forelse($attempts as $attempt)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $attempt->applicant->name ?? '' }}</td>
                                <td>{{ $attempt->exam->title ?? '' }}</td>
                                <td>{{ $attempt->status ?? 'جارية' }}</td>
                                <td>{{ $attempt->started_at ?? '' }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">عرض التفاصيل</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">لا توجد محاولات امتحان مسجلة حالياً.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection