<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 28.05.16
 * Time: 12:15
 */

class User extends Model
{
    public function getByLogin($login)
    {
        $login = $this->db->escape($login);
        $sql = "SELECT * FROM users WHERE login = '{$login}' limit 1";
        $result = $this->db->query($sql);
        if(isset($result[0])) {
            return $result[0];
        }
        return false;
    }
}