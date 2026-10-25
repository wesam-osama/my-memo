@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="mb-4">
        <h2>نتائج الامتحانات (Exam Results)</h2>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>اسم المرشح</th>
                        <th>الامتحان</th>
                        <th>الدرجة الحاصل عليها</th>
                        <th>التقدير / الحالة</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($results)
                        @forelse($results as $result)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $result->applicant->name ?? '' }}</td>
                                <td>{{ $result->exam->title ?? '' }}</td>
                                <td>{{ $result->score ?? 0 }} / {{ $result->exam->total_marks ?? 100 }}</td>
                                <td>
                                    <span class="badge bg-{{ ($result->passed ?? false) ? 'success' : 'danger' }}">
                                        {{ ($result->passed ?? false) ? 'ناجح' : 'راسب' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">لم يتم رصد نتائج حتى الآن.</td>
                            </tr>
                        @endforelse
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection