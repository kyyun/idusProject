<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\OrderDetails;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller {
    

    public function getProfile(Request $request){

        $email = $request->email;

        if( empty($email) ) {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -100, 'errorMsg' => 'empty value'] ], 200);
        }

        $data = User::where('email',$request->email)->first();

        if(!$data){
            return response()->json(['success' => false, 'result'=> ['errorCode' => -112, 'errorMsg' => 'email not found']], 200);
        }

        $result = [
            'name' => $data->name,
            'nickName' => $data->nick_name,
            'phoneNumber' => preg_replace("/([0-9]{3})([0-9]{3,4})([0-9]{4})$/","\\1-\\2-\\3" ,$data->phone_number),
            'email' => $data->email,
            'gender' => $data->gender == NULL ? '' : $data->gender
        ];

        return response()->json([ 'success'=>true, "result"=>$result ], 200);
    }

    public function getOrderDetailsList(Request $request){

        $email = $request->email;

        if( empty($email) ) {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -100, 'errorMsg' => 'empty value'] ], 200);
        }

        $data = OrderDetails::where('email',$email)->orderBy('pay_time', 'desc')->get();

        if(!count($data)){
            return response()->json(['success' => false, 'result'=> ['errorCode' => -113, 'errorMsg' => 'order details not found']], 200);
        }

        $result = [];

        for($i=0; $i<count($data); $i++){

            array_push($result, [
                "email" => $data[$i]->email,
                "productId" => $data[$i]->product_id,
                "productName" => $data[$i]->product_name,
                "payTime" => (string)strtotime($data[$i]->pay_time)
            ]);
        }

        return response()->json([ 'success'=>true, "result"=>$result ], 200);
    }

    public function getUsersList(Request $request){

        $index = $request->index;
        $email = $request->email;
        $name = $request->name;

        $result = [];
        
        $data = OrderDetails::select('users.name','order_details.email','order_details.product_id','product_name','order_details.pay_time')
                    ->leftJoin('users','users.email','order_details.email')
                    ->whereRaw('order_details.pay_time in  ( select MAX(order_details.pay_time) from order_details GROUP BY email )')
                    ->when($email, function($query, $email){
                        return $query->where('users.email', $email);
                    })
                    ->when($name, function($query, $name){
                        return $query->where('users.name', $name);
                    })
                    ->orderBy('order_details.pay_time', 'desc')
                    ->paginate($index);

        if(!count($data)){
            return response()->json(['success' => false, 'result'=> ['errorCode' => -114, 'errorMsg' => 'There are no members']], 200);
        }

        for($i=0; $i<count($data); $i++){

            array_push($result, [
                "name" => (string)$data[$i]->name,
                "email" => $data[$i]->email,
                "productId" => $data[$i]->product_id,
                "productName" => $data[$i]->product_name,
                "payTime" => (string)strtotime($data[$i]->pay_time)
            ]);
        }
        
        return response()->json([ 'success'=>true, "result"=>$result ], 200);
    }
}
