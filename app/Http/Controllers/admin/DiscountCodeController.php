<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\DiscountCoupon;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DiscountCodeController extends Controller
{
    //


    public function index(Request $request){

        if(!empty($request->get("keyword"))){
            $data = DiscountCoupon::where("name","like","%". $request->get("keyword")."%")->latest()->paginate(10);
        }else{
            $data = DiscountCoupon::orderBy("id","desc")->paginate(10);
        }
       
        return view('admin.coupon.list',['data'=>$data]);
    }

    public function create(){
        return view('admin.coupon.create');
    }

    public function store(Request $request){
        

        $validat = Validator::make($request->all(),[
            'code' => "required",
            'type' => "required",
            'discount_amount' => "required|numeric",
            'status' => "required",
        ]);
        if($validat->passes()){

            //starting data must be grater then current date
            if(!empty($request->starts_at)){
                $now = Carbon::now();

                $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
                if($startAt->lte($now)==true){
                    return response()->json([
                        'status' => false,
                        'errors' => ["starts_at" => "start date can not be less then current Date time"]
                    ]);
                }
            }

            //expire date must be grater then starts date
            if(!empty($request->expires_at) && !empty($request->starts_at)){
                $stDate = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);;
                $xpDate = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);;

                $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
                if($xpDate->lte($stDate)==true){
                    return response()->json([
                        'status' => false,
                        'errors' => ["expires_at" => "Expire date Must be grater then start date time"]
                    ]);
                }
            }

            



            $discoupon = new DiscountCoupon();
            $discoupon->code = $request->code;
            $discoupon->name = $request->name;
            $discoupon->description = $request->description;
            $discoupon->max_uses = $request->max_uses;
            $discoupon->max_uses_user = $request->max_uses_user;
            $discoupon->type = $request->type;
            $discoupon->discount_amount = $request->discount_amount;
            $discoupon->min_amount = $request->min_amount;
            $discoupon->status = $request->status;
            $discoupon->starts_at = $request->starts_at;
            $discoupon->expires_at = $request->expires_at;
            $discoupon->save();

            session()->flash('success',"Discount coupon added successfully");
            return response()->json([
                'status' => true,
                'messages' => "Discount coupon added successfully" 
            ]);



        }else{
            return response()->json([
                'status' => false,
                'errors' => $validat->errors()
            ]);
        }
    }

    public function edit(int $id){
        $discount = DiscountCoupon::find($id);
        if($discount == null ){
            return redirect()->route('coupon.index')->with('errors',"there is no coupon for this id");
        }
        return view('admin.coupon.edit',['data' => $discount]);
    }

    public function update(Request $request , int $id){

        $discoupon =  DiscountCoupon::find($id);

        $validat = Validator::make($request->all(),[
            'code' => "required",
            'type' => "required",
            'discount_amount' => "required|numeric",
            'status' => "required",
        ]);
        if($validat->passes()){

            //starting data must be grater then current date
            // if(!empty($request->starts_at)){
            //     $now = Carbon::now();

            //     $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
            //     if($startAt->lte($now)==true){
            //         return response()->json([
            //             'status' => false,
            //             'errors' => ["starts_at" => "start date can not be less then current Date time"]
            //         ]);
            //     }
            // }

            //expire date must be grater then starts date
            // if(!empty($request->expires_at) && !empty($request->starts_at)){
            //     $stDate = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);;
            //     $xpDate = Carbon::createFromFormat('Y-m-d H:i:s',$request->expires_at);;

            //     $startAt = Carbon::createFromFormat('Y-m-d H:i:s',$request->starts_at);
            //     if($xpDate->lte($stDate)==true){
            //         return response()->json([
            //             'status' => false,
            //             'errors' => ["expires_at" => "Expire date Must be grater then start date time"]
            //         ]);
            //     }
            // }

            $discoupon->code = $request->code;
            $discoupon->name = $request->name;
            $discoupon->description = $request->description;
            $discoupon->max_uses = $request->max_uses;
            $discoupon->max_uses_user = $request->max_uses_user;
            $discoupon->type = $request->type;
            $discoupon->discount_amount = $request->discount_amount;
            $discoupon->min_amount = $request->min_amount;
            $discoupon->status = $request->status;
            $discoupon->starts_at = $request->starts_at;
            $discoupon->expires_at = $request->expires_at;
            $discoupon->save();

            session()->flash('success',"Discount coupon added successfully");
            return response()->json([
                'status' => true,
                'messages' => "Discount coupon added successfully" 
            ]);

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validat->errors()
            ]);
        }


        
    }

    public function destroy(int $id){
        $discoupon =  DiscountCoupon::find($id);
        $discoupon->delete();
        session()->flash("success","successfully delete...");
        return response()->json([
            'status' => true,
            'messages' => "successfully delete"
        ]);
    }
}
