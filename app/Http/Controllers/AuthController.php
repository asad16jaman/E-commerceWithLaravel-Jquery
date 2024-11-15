<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(){

        return view("front.account.login");
    }

    public function register(){
        return view("front.account.register");
    }

    public function processRegister(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => "required|min:3",
            "email" => "required|email|unique:users",
            'password' => "required|min:5|confirmed"
        ]);

        if($validator->passes()){

            $user = new User;
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->password = Hash::make($request->password);
            $user->save();


            $request->session()->flash('success',"successfully registered");
            return response()->json([
                "status" => true
            ]);
        }else{
            return response()->json([
                "status" => false,
                "errors" => $validator->errors()
            ]);
        }

        // return "hellow";



    }

    public function authenticate(Request $request){
        $validator = Validator::make($request->all(),[
            "email" => "required|email",
            "password" => "required"
        ]);


     
        if($validator->passes()){

            if(Auth::attempt(['email' => $request->email,"password"=> $request->password])){

                $request->session()->regenerate();

               
                // if(session()->has('url.intended')){
                //     return redirect(session()->get('url.intended'));
                // }
                
                return redirect()->route('account.profile');


            }else{
                return redirect()->back()->with("logerror","given creadential is incurrect");
            }


        }else{
            return redirect()->back()->withErrors($validator)->withInput($request->only('email'));
        }
    }



    public function profile(){
        $user = User::find(Auth::user()->id);
        echo view("front.account.profile",['user'=>$user]);
    }

    public function updateProfile(Request $request){
        

        $valid = Validator::make($request->all(),[
            'name' => "required",
            'email' => 'required|email|unique:users,email,'.Auth::user()->id.',id',
            'phone' => 'required'
        ]);

        if($valid->passes()){

            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->phone = $request->phone;
            $user->save();
            session()->flash('success','successfully updated your account information');
            return response()->json([
                'status' => true,
                'messages' => 'successfully updated...'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $valid->errors()
            ]);
        }


    }

    function logout(){
        Auth::logout();
        return redirect()->route('account.login');
    }

    public function orders(){
        $user = Auth::user()->id;
        $data = Order::where('user_id',$user)->orderBy('created_at','desc')->get();
        return view('front.account.order',['orders'=>$data]);
    }


    public function orderDetail($id){
        $myorder = Order::with('orderItems')->find($id);
        return view('front.account.orderDetail',['order'=>$myorder]);
    }

    public function wishlist(){
        $wishlist = Wishlist::with('product')->where('user_id',Auth::user()->id)->get();
        return view('front.account.wishlist',['data'=>$wishlist]);
    }

    public function deleteProductFromList(Request $request){

       Wishlist::find($request->id)->delete();

       
            return response()->json([
                'status' => true,

            ]);

        
        
    }

    function edit_password() {
        $user = User::find(Auth::user()->id);
        echo view("front.account.change_password",['user'=>$user]);

    }

    function update_password(Request $request){
        $validate =  Validator::make($request->all(),[
            "c_password" => "required|current_password",
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
