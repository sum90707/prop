<?php

namespace App\Http\Controllers;

use Auth;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function profile(Request $request)
    {
        $userData = Auth::User();
        return view('user.profile', compact('userData'));
    }

    public function managePage(Request $request)
    {
        return view('user.manage');
    }

    public function save(Request $request)
    {
        $userData = $request->post()['User'];
        $user = Auth::User();

        if(!empty($userData['name'])) {
            $user->update(['name' => $userData['name']]);
        }

        if(array_key_exists($userData['language'], config('languages'))) {
            $user->language = $userData['language'];
            Session::put('applocale', $userData['language']);
        }
        $user->save();
        

        return Redirect::back();
        
    }

    public function uploadImage(Request $request)
    {
        
        $status = 422;
        $img = '';
        $msg = 'upload fail';
        $allowedMimeTypes = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];
        
        $user = Auth::User();
        $file = $request->file()[0];
        $contentType = mime_content_type($file->getRealPath());

        if(in_array($contentType, $allowedMimeTypes)) {
            
            $fileName = md5(time() . rand(0,9999)) .'.'. $request[0]->getClientOriginalExtension();
            $request[0]->move(public_path('upload/' . $user->id), $fileName);
            $source = file_get_contents(public_path('upload/' . $user->id . "/" . $fileName));
            $user->mug_shot = $fileName;

            if($user->save()){
                $status = 200;
                $img = "$user->id/$user->mug_shot";
                $msg = 'upload suss';
            }

        }else{
            $msg = "Only upload image";
        }
        
        
        return new JsonResponse([
            'message' => $msg,
            'image' => $img
        ], $status);
    }

    

    public function list(Request $request)
    {
        return User::getList($request);
    }

    public function toggle(Request $request, User $user)
    {
        $status = 422;
        $msg = 'update status fail';

        if(Auth::User()->checkAuth('admin')){
            $user->status == 0 ? $user->status = 1 :$user->status = 0;
            if($user->save()){
                $status = 200;
            }
        }else{
            $msg = 'permission deniedn';
        }

        return new JsonResponse([
            'message' => $msg,
            'btn' => $user->status
        ], $status);
    }

    public function toggleAuth(Request $request, User $user)
    {
        $status = 422;
        $msg = 'update auth fail';
        $auth = $request->get('select');
        
        if(Auth::User()->checkAuth('admin')){
            if(in_array($auth, config('user.setAuth'))){
                $user->auth = $auth;
                if($user->save()){
                    $status = 200;
                    $msg = "auth change suss : $user->auth";
                }
            }
        }else{
            $msg = 'permission deniedn';
        }

        return new JsonResponse([
            'message' => $msg
        ], $status);
    }

    public function toggleLang(Request $request, User $user)
    {
        $status = 422;
        $msg = 'update language fail';
        $lang = $request->get('select');

        if(Auth::User()->checkAuth('admin')){
            if(array_key_exists($lang, config('languages'))){
                $user->language = $lang;
                if($user->save()){
                    $status = 200;
                    $msg = "lang change suss : " . config('languages')[$user->language];
                }
            }
        }else{
            $msg = 'permission deniedn';
        }

        return new JsonResponse([
            'message' => $msg
        ], $status);
    }
    
}
