<?php

namespace App\Http\Controllers\frontend\employee;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\EmployeeAPI;

class EmployeeController extends Controller
{
    private $api = null;

    public function __construct()
    {
        $this->api = new EmployeeAPI();
    }

    function requestToJoin(Request $request)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'company_id' => 'required|integer',
                'requested_job_title' => 'required|string|max:255',
                'requested_department' => 'required|string|max:255',
            ]);

            $data = $request->only(['company_id', 'requested_job_title', 'requested_department']);

            $response = $this->api->requestToJoin($data);

            if ($response['statusCode'] === 200) {
                // Join request successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تم إرسال طلب الانضمام بنجاح');
            } else {
                // Join request failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.employee.join-company', get_defined_vars());
    }

    function getEmployees(Request $request)
    {
        $filters = $request->query();

        $response = $this->api->getEmployees($filters);

        if ($response['statusCode'] === 200) {
            // Employees retrieval successful, you can perform additional actions here if needed
            return view('frontend.employee.employees', ['employees' => $response['data']]);
        } else {
            // Employees retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function approveEmployee(Request $request, $employeeId)
    {
        $response = $this->api->approveEmployee($employeeId);

        if ($response['statusCode'] === 200) {
            // Employee approval successful, you can perform additional actions here if needed
            return redirect()->back()->with('success', 'تمت الموافقة على الموظف بنجاح');
        } else {
            // Employee approval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function rejectEmployee(Request $request, $employeeId)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'rejection_reason' => 'required|string|max:1000',
            ]);

            $data = $request->only(['rejection_reason']);

            $response = $this->api->rejectEmployee($employeeId, $data);

            if ($response['statusCode'] === 200) {
                // Employee rejection successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تم رفض الموظف بنجاح');
            } else {
                // Employee rejection failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.employee.reject-employee', get_defined_vars());
    }

    function removeEmployee(Request $request, $employeeId)
    {
        $response = $this->api->removeEmployee($employeeId);

        if ($response['statusCode'] === 200) {
            // Employee removal successful, you can perform additional actions here if needed
            return redirect()->back()->with('success', 'تم حذف الموظف بنجاح');
        } else {
            // Employee removal failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }
}
