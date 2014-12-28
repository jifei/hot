<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 14/12/27
 * Time: 01:03
 */
namespace App\Repositories\User;

use App\Models\User;

class UserRepository
{
    public function __construct()
    {
    }

    public function all()
    {
        return User::all();
        //$this->user::findAll(1);
    }

    public function create($data){
        return User::create($data);
    }

    public function add()
    {
        var_dump(User::all());

        //$this->user::findAll(1);
    }
}
