@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm p-4">
        <h3>إنشاء وظيفة جديدة - الخطوة 3: مراحل التوظيف (Stages)</h3>
        <hr>
        <form action="#" method="POST">
            @csrf
            <div class="mb-3">
                <label>حدد مراحل المقابلات والاختبارات لهذه الوظيفة</label>
                <input type="text" name="stages" class="form-control" placeholder="مثال: Screening -> Technical -> HR">
            </div>
            <button type="submit" class="btn btn-primary">التالي &larr;</button>
        </form>
    </div>
</div>
@endsection