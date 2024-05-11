<?php
use App\Mail\OrderMail;
use App\Models\Catagory;
use App\Models\Order;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Mail;


function getCatagories(){


    return Catagory::with(["subCats"=>function($qr){
        return $qr->select("id","catagory_id","name","status","show_home");
    }])
    ->where(["show_home" => "Yes","status"=>1])->orderBy("name",'desc')->get();

    
}


function getProductImage($productId){
    return ProductImage::where("product_id",$productId)->first();
}

function orderEmail($orderId, $userType = "customer"){
    $order = Order::with('orderItems')->find($orderId);
    if($userType=='customer'){
        $subject = "thanks your order";
        $mail = $order->email;
       
    }else{
        $subject = "You have received an order";
        $mail = "myadmin@gmail.com";
    }



    $mailData = [
        'subject' => $subject,
        'order' => $order,
        'userType' => $userType
    ];
    Mail::to($mail)->send(new OrderMail($mailData));

}

?>

