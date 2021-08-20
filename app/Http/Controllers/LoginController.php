<?php

namespace App\Http\Controllers;

use Auth;
use Hash;
use Lang;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{

    static protected $redirectTo = '/';

    protected function registerValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:prop_users',
            'password' => 'required|string|min:6|confirmed'
        ]);
    }

    protected function guard()
    {
        return Auth::guard('auth');
    }

    public function loginPage()
    {
        return view('login/inPage');
    }

    public function registerPage()
    {
        return view('login/register');
    }

    public function login(Request $request)
    {

        $email = $request['email'];
        $password = $request['password'];
        $status = 422;
        $msg = Lang::get('user.login_fail');
        $url = route('home');
        
        if (Auth::attempt(['email' => $email, 'password' => $password])){
            $checkLogin = self::userLogin(Auth::User()->id);

            if($checkLogin) {
                $status = 200;
                $msg = '';
            }else{
                Auth::logout();
                $msg = Lang::get('user.login_fail') . '. Account status:close';
            }
        }

        return new JsonResponse([
            'message' => $msg,
            'url' => $url
        ], $status);
    }

    public function register(Request $request)
    {
        $data = $request->post();
        $validator = self::registerValidator($data);

        $status = 422;
        $url = route('login.page');
        $msg = '';

        if(!$validator->fails()){

            $model = new User();
            $model->name = $data['name'];
            $model->email = $data['email'];
            $model->password = Hash::make($data['password']);
            $model->auth = 'student';
            $model->language = config('app.locale');
            $model->last_login = date('Y-m-d H:i:s');
            $model->created_at = date('Y-m-d H:i:s');
            $model->updated_at = date('Y-m-d H:i:s');

            if($model->save()){
                $status = 200;
            }
        }else{
            $msg = $validator->messages()->toJson();
        }

        return new JsonResponse([
            'message' => $msg,
            'url' => $url
        ], $status);
    }

    private function userLogin($userID)
    {
        $user = User::find($userID);

        if($user->status == 0 && $user->auth != 'admin'){
            return false;
        }else{
            if (array_key_exists($user->language, config('languages'))) {
                Session::put('applocale', $user->language);
            }
    
            $user->last_login = date('Y-m-d H:i:s');
    
            if ($user->save()) {
                $auth = new Auth();
                Auth::loginUsingId($user->id);
            }

            return true;
        }
    }

    protected function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('home');
    }

}
