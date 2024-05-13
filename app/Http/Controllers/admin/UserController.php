<?php

namespace App\Http\Controllers\admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{
    //

    public function index(Request $request){
        $users = User::latest();
        if($request->keyword != ''){
            $users = $users->where('name','like','%'.$request->keyword.'%')->orWhere('email','like','%'.$request->keyword.'%');
        }
        $users = $users->paginate(3);
        return view('admin.users.list',['data' => $users]);
    }

    public function create(){
        return view('admin.users.create');
    }

    public function store(Request $request){
        $valid = Validator::make($request->all(),[
            'name' => 'required',
            'email' => "required|email|unique:users",
            'phone' => 'required',
            'password' => 'required|confirmed'
        ]);

        if($valid->passes()){

            User::create($request->all());
            return response()->json([
                'status' => true,
                'errors' => 'successfully registered user'
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $valid->errors()
            ]);
        }


    }

    public function edit(int $id){
        $user = User::find($id);
        return view('admin.users.edit',['user'=>$user]);
    }

    public function update(Request $request,$id){

        $validatorArray = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id',
            'phone' => 'required'
        ];
        if($request->password != ""){
            $validatorArray['password'] = 'required|confirmed' ;
        }

        $valid = Validator::make($request->all(),$validatorArray);
        if($valid->passes()){

            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->status = $request->status;
            $user->phone = $request->phone;
            if($request->password != ""){
                $user->password = Hash::make($request->password);
            }
            $user->save();
            return response()->json([
                'status' => true,
                'messages' => 'successfully updated'
            ]);
        }else{
            return response()->json([
                'status' => false,
                'errors' => $valid->errors()
            ]);
        }



    }

    public function destroy($id){
        $user = User::find($id);
        if($user == null){
            return response()->json([
                'status' => false,
                'messages' => 'this user is not in database'
            ]);
        }
        $user->delete();
        return response()->json([
            'status' => true,
            'messages' => 'successfully deleted'
        ]);

    }




}
