<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 22.05.16
 * Time: 21:07
 */

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = App::$db;
    }
}