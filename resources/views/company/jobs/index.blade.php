@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إدارة الوظائف (Company Jobs)</h2>
        <a href="#" class="btn btn-primary">إضافة وظيفة جديدة</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>المسمى الوظيفي</th>
                        <th>القسم</th>
                        <th>الحالة</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($jobs)
                        @forelse($jobs as $job)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $job->title }}</td>
                                <td>{{ $job->department ?? 'عام' }}</td>
                                <td>{{ $job->status ?? 'نشط' }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">عرض</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">لا توجد وظائف مسجلة.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection