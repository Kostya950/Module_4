<?php
/**
 * Created by PhpStorm.
 * User: kito
 * Date: 22.05.16
 * Time: 21:25
 */

class Registrate extends Model
{
    public function save($data, $id = null)
    {

        if (!isset($data['login']) || !isset($data['first_name'])  || !isset($data['second_name'])
            || !isset($data['password']) || !isset($data['email'])) {
            return false;
        }
        $id = (int)$id;
        $login = $this->db->escape($data['login']);
        $first_name = $this->db->escape($data['first_name']);
        $second_name = $this->db->escape($data['second_name']);
        $password = $this->db->escape($data['password']);
        $email = $this->db->escape($data['email']);

        if ( !$id ) { // Add new record
            $sql = "
                    INSERT INTO users
                    set login = '{$login}',
                        firstName = '{$first_name}',
                        lastName = '{$second_name}',
                        password = '{$password}',
                        email = '{$email}',
                        role = 'user'
            ";
        } else {// Update existing record
            $role = $this->db->escape($data['role']);
            $is_active = $this->db->escape($data['is_active']);
            $sql = "
                    UPDATE users
                    set login = '{$login}',
                        firstName = '{$first_name}',
                        lastName = '{$second_name}',
                        password = '{$password}',
                        email = '{$email}',
                        role = '{$role}',
                        is_active = '{$is_active}'
            ";
        }

            return $this->db->query($sql);
    }

    public function getList(){
        $sql = "SELECT * FROM messages where 1";

        return $this->db->query($sql);
    }


}