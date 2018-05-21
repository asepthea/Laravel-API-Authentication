<?php

//namespace App\Http\Controllers\Auth\Request;


//use Illuminate\Http\Request;
namespace App\Http\Requests;

use App\Http\Requests\Request;

class LoginRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'    => 'required|email',
            'password' => 'required'
        ];
    }
}
