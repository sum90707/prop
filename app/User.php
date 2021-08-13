<?php

namespace App;

use Auth;
use DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    protected $connection = 'mysql';
    protected $table = 'prop_users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    protected static function getList($request)
    {
        $user = User::query();
        $user->where('auth', '!=', 'admin');
        $search = $request->input('search.value');


        $users = DataTables::of($user)
                            ->filter(function ($query) use ($search) {
                                if ($search) {
                                    $search = str_replace("'", "\\'", $search);
                                    $query->whereRaw('(`name` LIKE "%' . $search . '%" OR email LIKE "%' . $search . '%")');
                                    
                                }
                            })
                            ->smart(false)
                            ->toArray();


        return new JsonResponse($users);

    }

    public function checkAuth($auths, $function = false)
    {
        $user = Auth::User();
        $authGroup = explode('|', $auths);


        foreach($authGroup as $auth){
            if($user->auth == $auth){
                return true;
            }
        }
       
        return false;


    }
}
