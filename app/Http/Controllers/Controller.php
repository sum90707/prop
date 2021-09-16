<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public static function changStatus($model, $auth)
    {
        
        if(Auth::User()->checkAuth($auth)){
            if($model->status){
                $model->update(['status' => 0]);
            }else{
                $model->update(['status' => 1]);
            }
            return true;
        }

        return false;
    }
}
