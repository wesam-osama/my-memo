@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>مراقبة الامتحانات (Exam Proctoring)</h2>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm p-4">
                <p class="text-muted">لوحة مراقبة المتقدمين أثناء أداء الامتحانات أونلاين.</p>
                <!-- يمكن إضافة كاميرات المراقبة أو سجل تنبيهات الغش هنا -->
                <div class="alert alert-info">
                    لا توجد جلسات مراقبة نشطة في الوقت الحالي.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection