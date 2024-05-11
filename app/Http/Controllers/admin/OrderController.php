<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function index(Request $request){
        $orders = Order::latest('orders.created_at');
        $orders = $orders->leftJoin('users','users.id','orders.user_id')->select('orders.*','users.name','users.email');
        if($request->get('keyword') != ""){
            $orders = $orders->where('users.name','like','%'.$request->keyword.'%');
            $orders = $orders->orWhere('users.email','like','%'.$request->keyword.'%');
            $orders = $orders->orWhere('orders.id','like','%'.$request->keyword.'%');
        }
        $orders = $orders->paginate(10);
        return view('admin.orders.list',['data'=>$orders]);
    }
    public function detail($id){
        $order = Order::with('orderItems')->find($id);
        $cntry = Country::find($order->country_id);
        return view('admin.orders.detail',['data'=>$order,'country'=>$cntry]);
    }

    function changeOrderStatus(Request $request,int $id){
        $order = Order::find($id);
        $order->status = $request->status;
        $order->shipped_date = $request->shipped_date;
        $order->save();
        return redirect()->back()->with('success','successfully change status of this order');
        
    }


    public function sendEmailCustom(Request $request, $orderId){
        orderEmail($orderId,$request->userType);
        session()->flash('success','successfully send messages');
        return response()->json([
            'status' => true,
            'messages' => 'successfully send messages'
        ]);
    }


}
