<?php

    namespace App\Http\Controllers\Auth;
    use App\Cognito\CognitoClient;
    use Illuminate\Http\Request;
    use \Illuminate\Http\JsonResponse;
    use \Illuminate\Auth\Access\AuthorizationException;
    use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
    use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
    use Illuminate\Support\Facades\Route;
    class VerificationController{

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
                return redirect()->route('login');
            }
    
            return redirect()->route("login");
        }

        public function resend(Request $request)
        {
            $request->validate(['email' => 'required|email']);
    
            $response = app()->make(CognitoClient::class)->resendToken($request->email);
    
            if ($response == 'validation.invalid_user') {
                return response()->json(['error' => 'email invalido'], 400);
            }
    
            if ($response == 'validation.exceeded') {
                return response()->json(['error' => 'codigo invalido'], 400);
            }
    
            if ($response == 'validation.confirmed') {
                return response()->json(['error' => 'tempo excedido da validacao'], 400);
            }
    
            return response()->json(['success' => 'true']);
        }
    
    }

?>