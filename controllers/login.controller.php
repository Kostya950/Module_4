<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 02.06.16
 * Time: 20:11
 */

class LoginController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new User();
    }

    public function index()
    {
        if($_POST && isset($_POST['login']) && isset($_POST['password'])) {
            $user = $this->model->getByLogin($_POST['login']);
            $hash = $_POST['password'];
            if($user && $user['is_active'] && $hash == $user['password']) {
                Session::set('login', $user['login']);
                Session::set('role', $user['role']);
                Router::redirect('/pages/');
            }

        }

    }
}