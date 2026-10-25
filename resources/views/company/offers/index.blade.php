@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>عروض العمل المقدمة للمرشحين (Job Offers)</h2>
    </div>
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المرشح</th>
                        <th>الوظيفة</th>
                        <th>الراتب المعروض</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="5" class="text-center">لا توجد عروض عمل مسجلة حتى الآن.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection