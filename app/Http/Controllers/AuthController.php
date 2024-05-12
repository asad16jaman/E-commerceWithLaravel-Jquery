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

               
                if(session()->has('url.intended')){
                    return redirect(session()->get('url.intended'));
                }
                return redirect()->route('account.profile');


            }else{
                return redirect()->back()->with("logerror","given creadential is incurrect");
            }


        }else{
            return redirect()->back()->withErrors($validator)->withInput($request->only('email'));
        }
    }



    public function profile(){
        echo view("front.account.profile");
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







}
