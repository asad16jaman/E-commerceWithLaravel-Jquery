<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order </title>
</head>
<body style="font-family:Arial,Helvetica,sans-serif;font-size:16px">

    @if($mailData['userType'] == 'customer')
    <h1>thanks for Your order</h1>
    <h2>Your order id is #{{ $mailData['order']->id }}</h2>
    @else
        <h1>You have received an order</h1>
        <h2>Your order id is #{{ $mailData['order']->id }}</h2>

    @endif

    

    <table class="" cellpadding="5" cellspacing='5' border="0">
                                            <thead>
                                                <tr style="background: #ccc">
                                                    <th>Product</th>
                                                    <th width="100">Price</th>
                                                    <th width="100">Qty</th>                                        
                                                    <th width="100">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($mailData['order']->orderItems as $item )
                                                <tr>
                                                    <td>{{$item->name}}</td>
                                                    <td>${{$item->price}}</td>                                        
                                                    <td>{{$item->qty}}</td>
                                                    <td>${{$item->total}}</td>
                                                </tr>
                                                @endforeach
                                                <tr>
                                                    <th colspan="3" class="text-right" align="right">Subtotal:</th>
                                                    <td>{{number_format($mailData['order']->subtotal,2)}}</td>
                                                </tr>
                                                
                                                <tr>
                                                    <th colspan="3" class="text-right" align="right">Discount:</th>
                                                    <td>{{number_format($mailData['order']->discount,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right" align="right">Shipping:</th>
                                                    <td>{{number_format($mailData['order']->shipping,2)}}</td>
                                                </tr>
                                                <tr>
                                                    <th colspan="3" class="text-right" align="right">Grand Total:</th>
                                                    <td>{{number_format($mailData['order']->grand_total,2)}}</td>
                                                </tr> 
                                            </tbody>
                                        </table>	
    
</body>
</html>