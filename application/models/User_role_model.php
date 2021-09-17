<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User_role_model extends CI_Model
{

    function insert_batch($result)
    {
        $this->db->insert_batch('user_role', $result);
    }

    function insert($result)
    {
        $this->db->insert('user_role', $result);
    }

    function delete($user_id)
    {
        return $this->db->delete('user_role', array('user_id' => $user_id));
    }
}
