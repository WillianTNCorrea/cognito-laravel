<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use App\Cognito\CognitoClient;
use Aws\CognitoIdentityProvider\CognitoIdentityProviderClient;
use Aws\CognitoIdentityProvider\Exception\CognitoIdentityProviderException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

class RegisterController extends Controller
{
    //

    /*
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],

        ]);
    }
    */
    public function register(Request $request){

        try{

       
        $this->validate($request,[
            'name'    => 'required|min:3|max:60',
            'email'   => 'required|email',
            'password'   => 'required | min:6 |same:password_confirmation',
            'password_confirmation' => 'required | required_with: password'
        ]);
        
        $attributes=[];
        
        $userFields = ['name', 'email'];

        foreach($userFields as $userField){

            if($request->$userField === null){
                throw new \Exception("The configured user field $userField is not provided in the request.");
            }
            $attributes[$userField] = $request->$userField;
        }
        
        app()->make(CognitoClient::class)->register($request->email, $request->password, $attributes);
      

        // event(new Registered($user = $this->create($attributes)));

        return $this->registered($request, $user)
            ?: redirect()->route('/email/verify/')->with('email',$request->email);

        }catch(CognitoIdentityProviderException $e){
            return back()->with('error', 'User email already registered! try with another one');
        }
    }
}
