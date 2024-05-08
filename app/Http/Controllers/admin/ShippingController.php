<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\ShippingCharge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippingController extends Controller
{
    public function create(){
       $countries = Country::get();

       $shippingCharge = ShippingCharge::select('shipping_charges.*',"countries.name")->leftJoin('countries','countries.id','shipping_charges.country_id')->get();
        
       return view('admin.shipping.create',['data' => $countries,'shippingCharge' => $shippingCharge]);
    }

    public function store(Request $request){

        $validate = Validator::make($request->all(),[
            "country" => 'required',
            "amount" => "required|numeric"
        ]);

        if($validate->passes()){

            $exist = ShippingCharge::where('country_id',$request->country)->count();

            if($exist>0){
                session()->flash('errors',"this country is already is added");
                return response()->json([
                    'status' => true,
                    'errors' => $validate->errors()
                ]);
            }

          
               
            $shipping = new ShippingCharge;
            $shipping->country_id  = $request->country;
            $shipping->amount = $request->amount;
            $shipping->save();
            session()->flash('success',"shipping added successfully");
            return response()->json([
                'status' => true,
                'messages' => null
            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }



    }


    public function edit($id){
        $shippingCharge = ShippingCharge::find($id); 
        $countries = Country::get();
        // ,'shippingCharge' => $shippingCharge
        return view('admin.shipping.edit',['data' => $countries,"shippingCharge" => $shippingCharge]);
    }

    public function update(Request $request,int $id){

        $validate = Validator::make($request->all(),[
            "country" => 'required',
            "amount" => "required|numeric"
        ]);

        if($validate->passes()){

            

            $shipping =  ShippingCharge::find($id);
            $shipping->country_id  = $request->country;
            $shipping->amount = $request->amount;
            $shipping->save();
            session()->flash('success',"shipping updated successfully");
            return response()->json([
                'status' => true,
                'messages' => null
            ]);


        }else{
            return response()->json([
                'status' => false,
                'errors' => $validate->errors()
            ]);
        }
    }


    function destroy(int $id){
        $charge = ShippingCharge::find($id);
        if($charge == null){

        }else{
            $charge->delete();
            session()->flash('errors',"successfully deleted");
            return response()->json([
                'status' => true,
                'messages' => "successfully deleted"
            ]);
        }
    }









}
