<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cognito\CognitoClient;
use Illuminate\Support\Facades\Auth;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
    
         
            try
            {
            
                
               $token = app()->make(CognitoClient::class)->authenticate($request->email, $request->password);
                
               $request->session()->regenerate();

                return redirect()->route("user/home")->with('token', $token);
            }
            catch(Exception $e) {
                return back()->with('error', 'Não foi possivel efetuar o login, tente de novo!');
            }
        }

}
