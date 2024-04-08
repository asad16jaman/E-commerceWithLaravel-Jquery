<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Auth;
class AdminLoginController extends Controller
{
    //

    function index(){
        return view("admin.login");
    }

    function authenicate(Request $request){
        $validator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // var_dump($validator);
        
        if($validator->passes()){
                
            if(Auth::guard("admin")->attempt([
                'email' => $request->email,
                'password' => $request->password
            ],$request->get("remember"))){

                $ur = Auth::guard("admin")->user();
                if($ur->role == 2){
                    return redirect()->route("admin.dashboard");
                }else{
                    Auth::guard("admin")->logout();
                    return redirect()->route("admin.login")
                    ->with("error","only admin can login with this form you are not authorize");
                }

                
            }else{
                
               
            };



        }else{
            return redirect()->route("admin.login")->withErrors($validator)
            ->withInput($request->only("email"));
            
        }

    }
}
