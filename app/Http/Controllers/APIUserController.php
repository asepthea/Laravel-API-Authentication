<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\User; 
use Illuminate\Support\Facades\Auth; 
use Validator;
use Carbon\Carbon;
use Laravel\Passport\Passport; 
use Illuminate\Support\Facades\Hash;

//use App\Http\Controllers\Auth\LoginProxy;

class APIUserController extends Controller
{
    public $successStatus = 200;
		
	public function login(){ 
        if(Auth::attempt(['email' => request('email'), 'password' => request('password')])){ 
			$user = Auth::user();
			$token = $user->createToken('MyApp')-> accessToken; 
			//Passport::tokensExpireIn(now()->addDays(15));
			//Passport::refreshTokensExpireIn(now()->addDays(30));
			Passport::tokensExpireIn(Carbon::now()->addDays(15));			
			return response()->json(['status' => 'ok', 'token' => $token], $this-> successStatus);
        } 
        else{ 
            return response()->json(['status'=>'error', 'message'=>'Unauthorised'], 401); 
        }
    }
	
	public function register(){
		$err_message = '';
		$user = new User;
		$name = request('name');
		if ($name == null || $name == ''){
			$err_message = 'Name cannot be empty';
		} else {
			$email = request('email');
			if ($email == null || $email == ''){
				$user->email = $email;
				$err_message = 'Email cannot be empty';
			} else {
				$password = request('password');
				if ($password == null || $password == ''){
					$user->password = $password;
					$err_message = 'Password cannot be empty';
				} else {
					$user->name = request('name');
					$user->email = request('email');
					$user->password = Hash::make(request('password'));
					$user->address = request('address');
					$user->phone = request('phone');
					$user->idno = request('idno');
					$user->pin = request('pin');
					$user->balance = 0;
					$user->latitude = request('latitude');
					$user->longitude = request('longitude');
					$user->save();
					return response()->json(['status' => 'ok'], $this-> successStatus);
				}
			}
		}
		return response()->json(['status'=>'error', 'message'=>$err_message], 401); 
	}
	
	public function details() 
    { 
        $user = Auth::user(); 
        return response()->json(['success' => $user], $this-> successStatus); 
    } 	
}
