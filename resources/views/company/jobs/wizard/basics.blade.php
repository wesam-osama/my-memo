@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm p-4">
        <h3>إنشاء وظيفة جديدة - الخطوة 1: المعلومات الأساسية (Basics)</h3>
        <hr>
        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label>المسمى الوظيفي</label>
                <input type="text" name="title" class="form-control" placeholder="مثال: Senior DevOps Engineer">
            </div>
            <div class="mb-3">
                <label>القسم</label>
                <input type="text" name="department" class="form-control" placeholder="مثال: IT / Engineering">
            </div>
            <button type="submit" class="btn btn-primary">التالي &larr;</button>
        </form>
    </div>
</div>
@endsection