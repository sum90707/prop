<?php

namespace App\Http\Controllers;

use Auth;
use App\Paper;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class PaperController extends Controller
{
    private function rule($data, $model)
    {
        $rule = ['name' => 'required|unique:prop_paper|max:255'];

        if($model) {
            if($data['name'] == $model->name) {
                $rule['name'] = 'required|max:255';
            }
        }
        
        return $rule;
    }


    public function admin(Request $request) 
    {
        return view('paper.admin');
    }

    public function list(Request $request) 
    {
        return Paper::getList($request);
    }

    public function form(Request $request, Paper $paper = null)
    {
        return view('paper.form', ['paper' => $paper]);
    }

    public function save(Request $request, Paper $paper = null)
    {
        
        $status = 422;
        $msg = 'fail to save : ';
        $data = $request->post('paper');
        $rule = self::rule($data, $paper);

        $validator = Validator::make($data, $rule);

        if($validator->passes()) {
            $paper =  $paper ? $paper : new Paper;
            $paper->name = $data['name'];
            $paper->remark = $data['remark'];
            $paper->create_by = Auth::User()->id;

            if($paper->save()){
                $status = 200;
                $msg = 'save suss';
            }
        } else {
            $msg = $msg . $validator->errors()->first();
        } 

        return new JsonResponse([
            'message' => $msg
        ], $status);
        
    }

    public function toggle(Request $request, Paper $paper)
    {
        $status = 422;
        $msg = 'permission denied';
        $btnStatus = '';

        $update = self::changStatus($paper, 'admin|teacher');

        if($update){
            $status = 200;
            $msg = "update status suss : quesition No. $paper->id  ";
            $btnStatus = $paper->status;
        }

        return new JsonResponse([
            'message' => $msg,
            'btnStatus' => $btnStatus
        ], $status);
        
    }
}
