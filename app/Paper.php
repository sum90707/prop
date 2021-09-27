<?php

namespace App;

use DataTables;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    protected $connection = 'mysql';
    protected $table = 'prop_paper';
    protected $fillable = ['status'];

    public function User()
    {
        return $this->hasOne('App\User', 'id', 'create_by');
    }

    public static function getList($request)
    {
        $paper = self::query();
        $search = $request->input('search.value');

        $papers = DataTables::of($paper)
                            ->filter(function ($query) use ($search) {
                                if ($search) {
                                    $search = str_replace("'", "\\'", $search);
                                    $query->whereRaw('(`name` LIKE "%' . $search . '%" OR id LIKE "%' . $search . '%")');
                                    
                                }
                            })
                            ->smart(false)
                            ->toArray();


        self::getCreateBy($papers);
        
        return new JsonResponse($papers);
    }


    private static function getCreateBy(&$papers)
    {
        foreach($papers['data'] as &$paper) {
            // $paper['create_by'] = User::find($paper['create_by'])->name;
            $paper['create_by'] = Paper::find($paper['id'])->User->name;
        }

    }
}
