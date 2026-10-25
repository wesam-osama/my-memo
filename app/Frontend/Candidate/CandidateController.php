<?php

namespace App\Http\Controllers\frontend\candidate;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Frontend\Auth\ApiSession;
use App\Models\CandidateAPI;

class CandidateController extends Controller
{
    private $api = null;

    public function __construct()
    {
        $this->api = new CandidateAPI();
    }

    function getProfile(Request $request)
    {
        $response = $this->api->getProfile();

        if ($response['statusCode'] === 200) {
            // Profile retrieval successful, you can perform additional actions here if needed
            return view('frontend.candidate.profile', ['profile' => $response['data']]);
        } else {
            // Profile retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function updateProfile(Request $request)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'phone' => 'nullable|string|max:30',
                'location' => 'nullable|string|max:255',
                'headline' => 'nullable|string|max:255',
                'bio' => 'nullable|string',
                'has_no_experience' => 'nullable|boolean',
                'years_experience' => 'nullable|integer|min:0',
            ]);

            $data = $request->only(['phone', 'location', 'headline', 'bio', 'has_no_experience', 'years_experience']);

            $response = $this->api->updateProfile($data);

            if ($response['statusCode'] === 200) {
                // Profile update successful, you can perform additional actions here if needed
                return redirect()->route('frontend.candidate.profile')->with('success', 'تم تحديث بياناتك بنجاح');
            } else {
                // Profile update failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        // pre-fill the form with the current profile
        $response = $this->api->getProfile();
        $profile = $response['statusCode'] === 200 ? $response['data'] : [];

        return view('frontend.candidate.update-profile', get_defined_vars());
    }

    function uploadResume(Request $request)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'resume' => 'required|file|mimes:pdf,doc,docx|max:2048',
            ]);

            $response = $this->api->uploadResume($request->file('resume')->getRealPath());

            if ($response['statusCode'] === 200) {
                // Resume upload successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تم رفع السيرة الذاتية بنجاح');
            } else {
                // Resume upload failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.candidate.upload-resume', get_defined_vars());
    }

    function downloadResume(Request $request, $resumeId)
    {
        $response = $this->api->downloadResume($resumeId);

        if ($response['statusCode'] === 200) {
            // Resume download successful, you can perform additional actions here if needed
            return response()->streamDownload(function () use ($response) {
                echo $response['data'];
            }, 'resume.pdf', [
                'Content-Type' => 'application/pdf',
            ]);
        } else {
            // Resume download failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function deleteResume(Request $request, $resumeId)
    {
        $response = $this->api->deleteResume($resumeId);

        if ($response['statusCode'] === 200) {
            // Resume deletion successful, you can perform additional actions here if needed
            return redirect()->back()->with('success', 'تم حذف السيرة الذاتية بنجاح');
        } else {
            // Resume deletion failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function getVacancies(Request $request)
    {
        $response = $this->api->getVacancies();

        if ($response['statusCode'] === 200) {
            // Vacancies retrieval successful, you can perform additional actions here if needed
            return view('frontend.candidate.vacancies', ['vacancies' => $response['data']]);
        } else {
            // Vacancies retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function applyForVacancy(Request $request, $vacancyId)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'cv_id' => 'required|integer',
                'cover_note' => 'nullable|string',
                'consent' => 'required|accepted',
            ]);

            $data = $request->only(['cv_id', 'cover_note', 'consent']);

            $response = $this->api->applyForVacancy($vacancyId, $data);

            if ($response['statusCode'] === 200) {
                // Application successful, you can perform additional actions here if needed
                return redirect()->route('frontend.candidate.applications.index')->with('success', 'تم التقديم على الوظيفة بنجاح');
            } else {
                // Application failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        // the form needs the candidate's resumes
        $profile = $this->api->getProfile();
        $cvs = $profile['statusCode'] === 200 ? data_get($profile['data'], 'cvs', []) : [];

        return view('frontend.candidate.apply', get_defined_vars());
    }

    function getApplications(Request $request)
    {
        $response = $this->api->getApplications();

        if ($response['statusCode'] === 200) {
            // Applications retrieval successful, you can perform additional actions here if needed
            return view('frontend.candidate.applications', ['applications' => $response['data']]);
        } else {
            // Applications retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function getApplication(Request $request, $applicationId)
    {
        $response = $this->api->getApplication($applicationId);

        if ($response['statusCode'] === 200) {
            // Application details retrieval successful, you can perform additional actions here if needed
            return view('frontend.candidate.application-details', ['application' => $response['data']]);
        } else {
            // Application details retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function addEducation(Request $request)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'institution' => 'required|string|max:255',
                'degree' => 'required|string|max:255',
                'field_of_study' => 'required|string|max:255',
                'graduation_year' => 'required|integer',
                'place' => 'nullable|string|max:255',
            ]);

            $data = $request->only(['institution', 'degree', 'field_of_study', 'graduation_year', 'place']);

            $response = $this->api->addEducation($data);

            if ($response['statusCode'] === 200) {
                // Education creation successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تمت إضافة المؤهل الدراسي بنجاح');
            } else {
                // Education creation failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.candidate.education', get_defined_vars());
    }

    function addExperience(Request $request)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'job_title' => 'required|string|max:255',
                'company_name' => 'required|string|max:255',
                'place' => 'nullable|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'is_current' => 'nullable|boolean',
                'description' => 'nullable|string',
            ]);

            $data = $request->only(['job_title', 'company_name', 'place', 'start_date', 'end_date', 'is_current', 'description']);

            $response = $this->api->addExperience($data);

            if ($response['statusCode'] === 200) {
                // Experience creation successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تمت إضافة الخبرة بنجاح');
            } else {
                // Experience creation failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.candidate.experience', get_defined_vars());
    }

    function addSkill(Request $request)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'skill_id' => 'required|integer',
                'level' => 'nullable|string|max:50',
            ]);

            $data = $request->only(['skill_id', 'level']);

            $response = $this->api->addSkill($data);

            if ($response['statusCode'] === 200) {
                // Skill creation successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تمت إضافة المهارة بنجاح');
            } else {
                // Skill creation failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.candidate.skills', get_defined_vars());
    }

    function getExams(Request $request)
    {
        $response = $this->api->getExams();

        if ($response['statusCode'] === 200) {
            // Exams retrieval successful, you can perform additional actions here if needed
            return view('frontend.candidate.exams', ['exams' => $response['data']]);
        } else {
            // Exams retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }

    function submitExam(Request $request, $examId)
    {
        if ($request->isMethod('post')) {

            $fields = $request->validate([
                'answers' => 'required|array',
            ]);

            $data = $request->only(['answers']);

            $response = $this->api->submitExam($examId, $data);

            if ($response['statusCode'] === 200) {
                // Exam submission successful, you can perform additional actions here if needed
                return redirect()->back()->with('success', 'تم تسليم الامتحان بنجاح');
            } else {
                // Exam submission failed, return the error message
                return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']])->withInput();
            }
        }

        return view('frontend.candidate.exams.take', get_defined_vars());
    }

    function getInterviews(Request $request)
    {
        $response = $this->api->getInterviews();

        if ($response['statusCode'] === 200) {
            // Interviews retrieval successful, you can perform additional actions here if needed
            return view('frontend.candidate.interviews', ['interviews' => $response['data']]);
        } else {
            // Interviews retrieval failed, return the error message
            return redirect()->back()->withErrors(($response['errors'] ?? []) ?: ['error' => $response['message']]);
        }
    }
}
