@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>طلبات الموظفين (Employee Requests)</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم الموظف</th>
                        <th>نوع الطلب</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- سيتم إضافة الـ Loop هنا -->
                    <tr>
                        <td colspan="5" class="text-center">لا توجد طلبات معلقة.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection