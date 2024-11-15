<?php

namespace App\Http\Controllers\admin;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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

    function change_password(){
        return view("admin.password_reset");
    }

    function update_password(Request $request){
        $validate =  Validator::make($request->all(),[
            "c_password" => "required|current_password:admin",
            "password" => "required|min:7|confirmed"
        ]);

        if($validate->fails()){
            return response()->json([
                "status" => false,
                "errors" => $validate->errors()
            ]);
        }

        $user= Auth::user();

        $success = User::where('id',$user->id)->update(['password'=>Hash::make($request->input('password'))]);
        if($success){
            $request->session()->flash("success","Successfully Updated Your password");
            return response()->json([
                'status'=> true,
                'message' => "Successfully updated Your password"
            ]);
        }
    }



}
