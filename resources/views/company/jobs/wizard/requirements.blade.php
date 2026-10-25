@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm p-4">
        <h3>إنشاء وظيفة جديدة - الخطوة 2: المتطلبات والمهارات (Requirements)</h3>
        <hr>
        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label>المهارات المطلوبة والشروط</label>
                <textarea name="requirements" class="form-control" rows="4" placeholder="اكتب المهارات المطلوبة..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">التالي &larr;</button>
        </form>
    </div>
</div>
@endsection