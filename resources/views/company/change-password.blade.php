@extends('frontend.layouts.app')
@php $uiRole = 'company'; @endphp

@section('title', 'Change password')

@section('content')
    @include('frontend.partials.change-password-form', ['action' => 'frontend.company.change-password.submit', 'cancel' => 'frontend.company.profile'])
@endsection
@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm p-4">
                <h3 class="mb-3">تغيير كلمة المرور</h3>
                
                {{-- عرض رسائل النجاح أو الأخطاء إن وجدت --}}
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="#" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>كلمة المرور الحالية</label>
                        <input type="password" name="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>كلمة المرور الجديدة</label>
                        <input type="password" name="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>تأكيد كلمة المرور الجديدة</label>
                        <input type="password" name="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">تحديث كلمة المرور</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection