<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Mail;

class AuthController extends Controller
{
    use ApiResponser;

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            // 'email' => 'required|string|email|max:255|unique:users',
            'email' => 'required|string|email|max:255',
            'username' => 'required|string|max:255',
            'password' => 'required|min:6',
        ]);
         $checkisexist = DB::table('users')
        ->select('email')
        ->where('email','=',$request->email)
        ->where('deleted_at','=',null)
        ->count();
        // dd("test");
        if ($checkisexist == 0) {
            // dd($checkisexist);
            $request->merge(['role_id' => 2]);
            $request->merge(['status' => 1]);
            $request->merge(['photo' => 'placeholder.jpg']);
            $user = User::create($request->all());
            // $user->assignRole([$request->role_id]);
            $useremail = $request->email;
            Mail::send('emails.register', ['request' => $request], function($message) use ($useremail){
                $message->to($useremail)
                 ->bcc('rafey.majid@gmail.com', 'Rafay Khan')
                 ->bcc('murtaza@mrm-soft.com', 'Murtaza Zaheer')
                 ->bcc('avidhaus.mehroz@gmail.com', 'Muhammad Mehroz')
                 ->subject('Day2Day Registration')
                 ->from('contact@day2day.com','Day2Day');
            });
            return $this->success([
                'token' => $user->createToken('API Token')->plainTextToken, 'user_id' => $user->id
            ]);       
        }else{
            // dd("else");
            $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
            ]);

            if (!Auth::attempt($attr)) {
                return $this->error('Credentials not match', 401);
            }
            $user_id = DB::table('users')
            ->select('id')
            ->where('email','=',$request->email)
            ->where('deleted_at','=',null)
            ->first();
            return $this->success([
                'token' => auth()->user()->createToken('API Token')->plainTextToken, 'user_id' => $user_id->id
            ]);
        }

     
    }

    public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }
        $user_id = DB::table('users')
        ->select('id')
        ->where('email','=',$request->email)
        ->where('deleted_at','=',null)
        ->first();
        return $this->success([
            'token' => auth()->user()->createToken('API Token')->plainTextToken, 'user_id' => $user_id->id
        ]);

    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
