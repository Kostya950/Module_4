<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 22.05.16
 * Time: 20:25
 */

class RegistrationController extends Controller
{

    public function __construct($data=array())
    {
        parent::__construct($data);
        $this->model = new Registrate();
    }

    public function index()
    {
      if ($_POST) {
          if ($this->model->save($_POST)) {
              Session::set('login', $_POST['login']);
              Session::set('role', '');
              Router::redirect('/pages/index');
          }
      }
    }

    public function admin_index(){
      //  $this->data = $this->model->getList();

    }
}