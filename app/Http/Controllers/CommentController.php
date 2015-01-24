<?php namespace App\Http\Controllers;

use App\Repositories\Comment\CommentRepository;
use Illuminate\Support\Facades\Input;
use Request;

class CommentController extends Controller
{

    /*
    |--------------------------------------------------------------------------
    | Home Controller
    |--------------------------------------------------------------------------
    |
    | This controller renders your application's "dashboard" for users that
    | are authenticated. Of course, you are free to change or remove the
    | controller as you wish. It is just here to get your app started!
    |
    */


    public function __construct(CommentRepository $comment)
    {
        parent::__construct();
        $this->comment =  $comment;
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard to the user.
     *
     * @return Response
     */
    public function add()
    {
        list($ok, $data, $msg) = $this->comment->create($this->login_user->uid,Request::segment(3),array('content'=>Input::get('content')));
        if (!$ok) {
            return $this->ajaxFail($msg);
        }

        return $this->ajaxSuccess($data);
    }

    public function info()
    {
        echo phpinfo();
    }

}
