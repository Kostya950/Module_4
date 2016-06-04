<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 02.06.16
 * Time: 20:38
 */

class AdministrationController extends Controller
{
    public function __construct($data = array())
    {
        parent::__construct($data);
        $this->model = new User();
    }

    public function index()
    {
        if(Session::get('role')!='admin'){
            Router::redirect('/pages/');
        }
    }
}