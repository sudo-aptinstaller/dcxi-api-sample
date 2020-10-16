<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Status;
use App\User;
use App\Token;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MainController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    //status  handle 


    public function status_ajax_grab($query){
        $status = Status::where('name','=',$query)->first();
        return response()->json(['text_status' => $status->text_status]);
    }
    

    public function status_ajax_store(Request $request, $query){
        $status = Status::where('name','=',$query)->first();
        $status->name = $query;
        $status->text_status = $request->get('text_status');
        $status->save();
            
        return redirect()->back();
    }

    //token handle
    public function generate_token(Request $request){

        $password = $request->get('password');
        $my_email = \Auth::user()->email;
        \Auth::user()->tokens()->delete();
        $user = User::where('email','=', $my_email)->first();
        if (! $user || ! Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $generated_token =  $user->createToken($user->name)->plainTextToken;
        $generated_token = preg_replace('/^[0-9]*\D/', '', $generated_token);
        $instance = Token::where('name','=', $user->name);
        if($instance->get()->isEmpty() == false){
            $token = Token::where('name','=', $user->name)->first();
            $token->name = $user->name;
            $token->token_plain = $generated_token;
            $token->save();

            return redirect('/dash/'.$user->id)->with('message', 'Token Generated Successfully');
        }else{
            $token = new Token;
            $token->id = $request->get('id');
            $token->name = $user->name;
            $token->token_plain = $generated_token;
            $token->save();

            return redirect('/dash/'.$user->id)->with('message', 'Token Generated Successfully');
        }
        
    }

    public function revoke_token(){

        \Auth::user()->tokens()->delete();
        $token = Token::where('name' ,'=', auth()->user()->name);
        $token->delete();
        return response()->json('Revoked Successfully');
    }




    //views handle (dashboard)
    public function dashboard($id){

        $user_req = User::where('id','=',$id)->first();
        if($user_req->name == auth()->user()->name){
            $user_token = Token::where('name','=',$user_req->name)->first();
            return view('admin.dashboard')->with('token', $user_token);
        }else{
            return redirect('/login')->with('error', 'Unauthorized entry');
        }
    }
    

}
