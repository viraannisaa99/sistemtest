<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


// function constraint($user_id, $role_id)
// {
//     $role = array(
//         'user_id'  => $user_id,
//         'role_id'  => $role_id,
//     );
//     return $role;
// }

function constraint($user_id, $role_id)
{
    $CI = get_instance();

    $result = array();
    foreach ($role_id as $key => $val) {
        $result[] = array(
            'user_id' => $user_id,
            'role_id' => $role_id[$key],
        );
    }

    $CI->db->insert_batch('user_role', $result);
}
