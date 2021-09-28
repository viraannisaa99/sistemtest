<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_model extends CI_Model
{

    // function checkUser($data)
    // {
    //     $this->db->select('user_id');
    //     $this->db->from('users');
    //     $this->db->where(array(
    //         'email' => $data['email']
    //     ));
    //     $query = $this->db->get();

    //     $check = $query->num_rows();
    //     if ($check > 0) {
    //         $result = $query->row_array(); // get prev user_data

    //         $data['modified'] = date("Y-m-d H:i:s"); // Update user data
    //         $this->db->update('users', $data, array('user_id' => $result['user_id']));

    //         $userID = $result['user_id']; // Get user ID
    //     }

    //     return $userID ? $userID : false; // Return user ID
    // }


    function update($data, $result)
    {
        $this->db->update('users', $data, array('user_id' => $result['user_id']));
    }

    // function getEmail()
    // {
    //     $this->db->select('email');
    //     $this->db->from('user');

    //     return $this->db->get()->result();
    // }
}