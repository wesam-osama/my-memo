<?php

namespace App\Http\Controllers\frontend\job;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\JobAPI;

class JobController extends Controller
{
    private $api = null;

    public function __construct()
    {
        $this->api = new JobAPI();
    }

    function getJobs(Request $request)
    {
        $filters = $request->query();

        $response = $this->api->getJobs($filters);

        if ($response['statusCode'] === 200) {
            // Jobs retrieval successful, you can perform additional actions here if needed
            return view('frontend.job.jobs', ['jobs' => $response['data']]);
        } else {
            // Jobs retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function getJob(Request $request, $jobId)
    {
        $response = $this->api->getJob($jobId);

        if ($response['statusCode'] === 200) {
            // Job details retrieval successful, you can perform additional actions here if needed
            return view('frontend.job.job-details', ['job' => $response['data']]);
        } else {
            // Job details retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function searchJobs(Request $request)
    {
        $keyword = (string) $request->query('q', '');

        $response = $this->api->searchJobs($keyword);

        if ($response['statusCode'] === 200) {
            // Jobs search retrieval successful, you can perform additional actions here if needed
            return view('frontend.job.jobs', ['jobs' => $response['data']]);
        } else {
            // Jobs search retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function getSalaryBenchmark(Request $request)
    {
        $fields = $request->validate([
            'job_title' => 'required|string|max:255',
        ]);

        $response = $this->api->getSalaryBenchmark($fields['job_title']);

        if ($response['statusCode'] === 200) {
            // Salary benchmark retrieval successful, you can perform additional actions here if needed
            return response()->json(['benchmark' => $response['data']], 200);
        } else {
            // Salary benchmark retrieval failed, return the error message
            return response()->json(['error' => $response['message']], $response['statusCode']);
        }
    }
}
