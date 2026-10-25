@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm p-4">
        <h3>منشئ الأسئلة والامتحان (Exam Builder)</h3>
        <hr>
        <form action="#" method="POST">
            @csrf
            <div class="form-group mb-3">
                <label>نص السؤال</label>
                <input type="text" name="question_text" class="form-control" placeholder="أدخل السؤال هنا...">
            </div>
            <!-- تفاصيل إضافية للأسئلة والخيارات -->
            <button type="submit" class="btn btn-success">حفظ السؤال</button>
        </form>
    </div>
</div>
@endsection