@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>قائمة موظفي الشركة (Company Employees)</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الموظف</th>
                        <th>البريد الإلكتروني</th>
                        <th>الوظيفة / القسم</th>
                        <th>التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($employees)
                        @forelse($employees as $employee)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->position ?? 'موظف' }}</td>
                                <td>
                                    <a href="#" class="btn btn-sm btn-info">عرض التفاصيل</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">لا توجد مسجلات موظفين حالياً.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection