<?php

namespace App\Frontend\Account;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;

/**
 * Change password / delete account, shared by candidate + company + the topbar link.
 *
 * TODO(backend): the Laravel API has no endpoint for these yet. Until it does
 * (e.g. POST /auth/change-password, DELETE /auth/account) the pages render normally
 * and the submit just tells the user the feature is not connected yet.
 * When the endpoints exist: add the calls to AccountAPI and replace notConnected() below.
 */
class AccountController extends Controller
{
    public function changePasswordForm(): View
    {
        return view(match (auth()->user()->account_type ?? null) {
            'candidate' => 'frontend.candidate.change-password',
            'company'   => 'frontend.company.change-password',
            default     => 'frontend.account.auth.change-password',
        });
    }

    public function changePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password'          => 'required|string',
            'new_password'              => 'required|string|min:8|confirmed',
        ]);

        return $this->notConnected();
    }

    public function deleteAccount(): RedirectResponse
    {
        return $this->notConnected();
    }

    private function notConnected(): RedirectResponse
    {
        return redirect()->back()->withErrors([
            'error' => __('This feature is not available yet.'),
        ]);
    }
}
