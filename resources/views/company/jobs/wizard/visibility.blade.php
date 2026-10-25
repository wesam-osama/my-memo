@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm p-4">
        <h3>إنشاء وظيفة جديدة - الخطوة 4: النشر والظهور (Visibility)</h3>
        <hr>
        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label>حالة النشر</label>
                <select name="status" class="form-control">
                    <option value="published">منشور (Public)</option>
                    <option value="draft">مسودة (Draft)</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">حفظ ونشر الوظيفة ✔</button>
        </form>
    </div>
</div>
@endsection