@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>جدول المقابلات (Interviews Schedule)</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المتقدم</th>
                        <th>الوظيفة</th>
                        <th>تاريخ المقابلة</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($interviews)
                        @forelse($interviews as $interview)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $interview->applicant->name ?? '' }}</td>
                                <td>{{ $interview->job->title ?? '' }}</td>
                                <td>{{ $interview->interview_date ?? '' }}</td>
                                <td>{{ $interview->status ?? 'مجدولة' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">لا توجد مقابلات مجدولة حالياً.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection