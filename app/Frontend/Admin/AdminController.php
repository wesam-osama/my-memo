<?php

namespace App\Http\Controllers\frontend\admin;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Models\AdminAPI;

class AdminController extends Controller
{
    private $api = null;

    public function __construct()
    {
        $this->api = new AdminAPI();
    }

    function getCompanies(Request $request)
    {
        $filters = $request->query();

        $response = $this->api->getCompanies($filters);

        if ($response['statusCode'] === 200) {
            // Companies retrieval successful, you can perform additional actions here if needed
            return view('frontend.admin.companies', ['companies' => $response['data']]);
        } else {
            // Companies retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function approveCompany(Request $request, $companyId)
    {
        $response = $this->api->approveCompany($companyId);

        if ($response['statusCode'] === 200) {
            // Company approval successful, you can perform additional actions here if needed
            return redirect()->back()->with('success', 'تمت الموافقة على الشركة بنجاح');
        } else {
            // Company approval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function rejectCompany(Request $request, $companyId)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'reason' => 'required|string|max:1000',
            ]);

            $data = $request->only(['reason']);

            $response = $this->api->rejectCompany($companyId, $data);

            if ($response['statusCode'] === 200) {
                // Company rejection successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تم رفض الشركة بنجاح');
            } else {
                // Company rejection failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.admin.reject-company', get_defined_vars());
    }

    function getUsers(Request $request)
    {
        $filters = $request->query();

        $response = $this->api->getUsers($filters);

        if ($response['statusCode'] === 200) {
            // Users retrieval successful, you can perform additional actions here if needed
            return view('frontend.admin.users', ['users' => $response['data']]);
        } else {
            // Users retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function updateUserStatus(Request $request, $userId)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'account_status' => 'required|string|in:active,suspended,banned',
            ]);

            $data = $request->only(['account_status']);

            $response = $this->api->updateUserStatus($userId, $data);

            if ($response['statusCode'] === 200) {
                // User status update successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تم تحديث حالة المستخدم بنجاح');
            } else {
                // User status update failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.admin.update-user-status', get_defined_vars());
    }

    function getAuditLogs(Request $request)
    {
        $filters = $request->query();

        $response = $this->api->getAuditLogs($filters);

        if ($response['statusCode'] === 200) {
            // Audit logs retrieval successful, you can perform additional actions here if needed
            return view('frontend.admin.audit-logs', ['logs' => $response['data']]);
        } else {
            // Audit logs retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }
}
