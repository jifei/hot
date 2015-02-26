<?php
/**
 * Created by PhpStorm.
 * User: jifei
 * Date: 15/2/10
 * Time: 上午11:10
 */
namespace App\Http\Controllers\Admin;

use App\Repositories\Admin\GroupRepository;
use Request;


class GroupController extends AdminController
{
    public function __construct(GroupRepository $repository)
    {
        parent::__construct();
        $this->repos = $repository;
    }

    public function index()
    {
        return view('admin.group.index');
    }
}