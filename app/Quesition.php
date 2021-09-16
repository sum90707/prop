<?php

namespace App;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Quesition extends Model
{
    protected $connection = 'mysql';
    protected $table = 'prop_quesition';
    protected $fillable = ['status']; 
    protected $testN;

    public function __construct()
    {   
        $this->testN = 1;
    }

    public static function saveModel($data)
    {
        if(empty($data['id'])){
            $model = new Quesition;
        }else{
            $model = Quesition::find($data['id']);
        }

        $data['options'] = $data['type'] == 0 ? Quesition::sortOptions($data['options']) : null;

        $model->year = $data['year'];
        $model->semester = $data['semester'];
        $model->quesition = $data['quesition'];
        $model->options = $data['options'];
        $model->type = $data['type'];
        $model->answer = $data['answer'];
        $model->status = 1;
        
        return  $model->save();
    }

    public static function pageData($page)
    {
        $page = is_int($page) ? $page : 15;

        $quesitions = Quesition::paginate($page);
        Quesition::sortOutPageData($quesitions);

        return $quesitions;

    }

    private static function sortOptions($options)
    {
        $optionsArr = [];
        foreach($options as $option) {
            $optionsArr[$option] = $option;
        }

        return json_encode($optionsArr);
    }


    private static function sortOutPageData(&$data)
    {
        $type = config('quesition.type');
        foreach($data as $item) {
            $item->options = $item->options ? json_decode($item->options, true) : '';
            $item->type = $type[$item->type];
        }
    }


    public function testOne($arg1)
    {
        $this->testN = $this->testN + $arg1;
        return $this;
    }

    public function testTwo($arg)
    {
        // $q = new Quesition;
        $this->testN = $this->testN + $arg;
        return $this->testN;
    }
}
