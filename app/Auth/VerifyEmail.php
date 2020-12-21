<?php 

namespace App\Auth;

use Illuminate\Http\Request;
use App\Cognito\CognitoClient;
use Illuminate\Auth\MustVerifyEmail as BaseVerifiesEmails;

trait VerifyEmail
{
    use BaseVerifiesEmails;

    /**
     * Show the email verification notice.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response|\Illuminate\View\View
     */
    public function show(Request $request)
    {
        return view('black-bits/laravel-cognito-auth::verify');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function verify(Request $request)
    {
        $request->validate(['email' => 'required|email', 'confirmation_code' => 'required|numeric']);

        $response = app()->make(CognitoClient::class)->verify($request->email, $request->confirmation_code);

        if ($response == 'validation.invalid_user') {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'email invalido']);
        }

        if ($response == 'validation.invalid_token') {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['confirmation_code' =>'codigo invalido']);
        }

        if ($response == 'validation.exceeded') {
            return redirect()->back()
                ->withInput($request->only('email'))
                ->withErrors(['confirmation_code' => 'tempo excedido da validacao']);
        }

        if ($response == 'validation.confirmed') {
            return redirect()->route("login");
        }

        return redirect()->route("login");
    }


    /**
     * Resend the email verification notification.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = app()->make(CognitoClient::class)->resendToken($request->email);

        if ($response == 'validation.invalid_user') {
            return response()->json(['error' => trans('black-bits/laravel-cognito-auth::validation.invalid_user')], 400);
        }

        if ($response == 'validation.exceeded') {
            return response()->json(['error' => trans('black-bits/laravel-cognito-auth::validation.exceeded')], 400);
        }

        if ($response == 'validation.confirmed') {
            return response()->json(['error' => trans('black-bits/laravel-cognito-auth::validation.confirmed')], 400);
        }

        return response()->json(['success' => 'true']);
    }

}
?>