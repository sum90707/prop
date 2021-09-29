<?php

namespace App\Http\Controllers;

use Lang;
use App\Quesition;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;


class QuesitionController extends Controller
{
    public function rule($data)
    {

        $quesitionValidateData = [
            'year' => [
                'required',
                Rule::in(config('quesition.year'))
            ],
            'semester' => [
                'required',
                Rule::in([1, 2])
            ],
            'type' => [
                'required',
                Rule::in(range(0, count(config('quesition.type'))-1))
            ],
            'quesition' => 'required',
        ];


        if($data['type'] == 0) {
            $quesitionValidateData['options'] = 'array|required';
            $quesitionValidateData['answer'] = [
                'required',
                Rule::in($data['options'])
            ];
        } else {
            $quesitionValidateData['answer'] = [
                'required',
                Rule::in([0, 1])
            ];
        }

        return $quesitionValidateData;
    }


    public function createPage(Request $request, Quesition $quesition)
    {
        return view('quesition.create', compact('quesition'));
    }

    public function admin(Request $request)
    {

        $quesitions = Quesition::pageData(15);
        
        return view('quesition.view', compact('quesitions'));
    }

    public function save(Request $request)
    {

        $status = 422;
        $msg = Lang::get('quesition.save_response.fail');

        
        $quesitionData = $request->post('quesition');
        $validator = Validator::make($quesitionData, $this->rule($quesitionData));

        if($validator->passes()) {
            $save = Quesition::saveModel($quesitionData);
            if($save){
                $status = 200;
                $msg = Lang::get('quesition.save_response.suss');
            }
        } else {
            $msg = $validator->errors()->first();
        }
            
        return new JsonResponse([
            'message' => $msg
        ], $status);
    }

    public function toggle(Request $request, Quesition $quesition)
    {
        $status = 422;
        $msg = 'permission denied';
        $btnStatus = '';

        $update = self::changStatus($quesition, 'admin|teacher');

        if($update){
            $status = 200;
            $msg = "update status suss : quesition No. $quesition->id  ";
            $btnStatus = $quesition->status;
        }

        return new JsonResponse([
            'message' => $msg,
            'btnStatus' => $btnStatus
        ], $status);
        
    }

    //this function is a test function for php cogitation
    public function testController(Request $request)
    {   
        // $q = Quesition::where('id','=', (1+1));
        // if (1+1 instanceof Expression) {
        //     dd('innnn');
        // }
        dd('fin');
    }
}
