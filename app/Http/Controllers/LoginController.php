<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\User;
use Auth;

class LoginController extends Controller {

    public function registerUsers(Request $request) {

        $name = $request->name;
        $nickName = $request->nickName;
        $password = $request->password;
        $phoneNumber = $request->phoneNumber;
        $email = $request->email;
        $gender = $request->gender;

        if( empty($name) || empty($nickName) || empty($password)|| empty($phoneNumber) || empty($email) ) {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -100, 'errorMsg' => 'empty value'] ], 200);
        }

        $namePattern = '/^[ㄱ-ㅎ|가-힣|a-z|A-Z|\*]+$/';
        $nickPattern = '/^[a-z]+$/';
        $passwordPattern = '/(?=.*[`~!@#$%^&*|\\\'\";:\/?^=^+_()<>])(?=.*[a-z])(?=.*[A-Z])/';
        $phoneNumberPattern = '/^[0-9|-]+$/';
        $emailPattern = '/^[a-z0-9_+.-]+@([a-z0-9-]+\.)+[a-z0-9]{2,4}$/';

        // name Check
        if( strlen($name) > 20 || strlen($name) < 4 ){
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -101, 'errorMsg' => 'not enough name length'] ], 200);
        }

        if( !preg_match( $namePattern, $name ) ) {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -102, 'errorMsg' => 'name format does not match'] ], 200);
        }

        // nickName Check
        if( strlen($nickName) > 30 ){
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -103, 'errorMsg' => 'not enough nickName length'] ], 200);
        }

        if( !preg_match( $nickPattern, $nickName ) ) {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -104, 'errorMsg' => 'nickName format does not match'] ], 200);
        }

        // password Check
        if( strlen($password) < 10 ){
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -105, 'errorMsg' => 'not enough password length'] ], 200);
        }

        if( !preg_match( $passwordPattern, $password ) ) {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -106, 'errorMsg' => 'password format does not match'] ], 200);
        }

        // phoneNumber Check
        if( strlen($phoneNumber) > 20 ){
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -107, 'errorMsg' => 'not enough phoneNumber length'] ], 200);
        }

        if( !preg_match( $phoneNumberPattern, $phoneNumber ) ) {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -108, 'errorMsg' => 'phoneNumber format does not match'] ], 200);
        }

        // email Check
        if( strlen($email ) > 100){
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -109, 'errorMsg' => 'not enough email length'] ], 200);
        }

        if( !preg_match( $emailPattern, $email ) ) {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -110, 'errorMsg' => 'email format does not match'] ], 200);
        }

        $users = new User;

        $users->name = $name;
        $users->nick_name = $nickName;
        $users->password = Hash::make($password);
        $users->phone_number = str_replace('-','',$phoneNumber);
        $users->email = $email;
        $users->gender = $gender;

        $users->save();

        return response()->json([ 'success'=>true ], 200);
    }

    public function loginUsers(Request $request){

        $email = $request->email;
        $password = $request->password;
           
        $user_data = array(
            'email'  => $email,
            'password' => $password
        );
        
        if(Auth::attempt($user_data)){
            return response()->json([ 'success'=>true ], 200);
        }
        else {
            return response()->json([ 'success'=>false, "result"=>[ 'errorCode' => -111, 'errorMsg' => 'login fail'] ], 200);
        }
    }

    public function logOutUsers(Request $request){

        Auth::logout();

        return response()->json([ 'success'=>true ], 200);
    }
    
}
