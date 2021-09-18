<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Auth_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('role_model');
        $this->load->model('log_model');
        $this->load->model('user_role_model');
        $this->load->model('permission_model');

        $this->load->helper('permission');
        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');
        $this->load->helper('constraint');
    }

    public function index()
    {
        $page_data['page_function']   = __FUNCTION__;
        $page_data['page_active']     = array('User');
        $page_data['page_name']       = 'user';
        $page_data['nama_role']       = $this->role_model->getRoles()->result();
        $page_data['user']            = $this;
        // $page_data['hasPermission']   = $this->userHasPermissions($param);

        $this->load->view('index', $page_data);
    }

    public function check_permission()
    {
        print_r($this->session->userdata('role_id'));
        print_r($this->session->userdata('permissions'));
    }

    public function add()
    {

        $page_data['permission'] = 'user-add';
        $data['nama']            = $this->input->post('nama');
        $data['email']           = $this->input->post('email');
        $data['username']        = $this->input->post('username');
        $data['password']        = hash('sha512', $this->input->post('password'));
        $data['status']          = 1;

        if (userHasPermissions($page_data['permission'])) {
            $empty = check_empty_form($data, array('email, username, password'));
            if ($empty) {
                $result = array('status' => 'error', 'msg' => 'Form penting tidak boleh kosong !');
            } else {
                if ($this->input->post('password') != $this->input->post('confirm_password'))
                    $result = array('status' => 'error', 'msg' => 'Cek kembali confirm password !');
                else {
                    $result = array('status' => 'success', 'msg' => 'User berhasil ditambahkan');
                    $this->user_model->add($data);

                    $user_id = $this->db->insert_id();
                    $role_id = $this->input->post('role_id');

                    $user_role = array();
                    foreach ($role_id as $key => $val) {
                        $user_role[] = array(
                            'user_id' => $user_id,
                            'role_id' => $role_id[$key],
                        );
                    }

                    if (is_array($role_id)) {
                        $this->user_role_model->insert_batch($user_role);
                    } else {
                        $this->user_role_model->insert($user_role);
                    }

                    $this->log_model->addLog(userLog('Menambah User', 'Menambah user "' . $data['nama']));
                }
            }
        } else {
            $result = array('status' => 'error', 'msg' => 'Anda tidak berhak menambahkan data user');
        }

        echo json_encode($result);
        die;

        $this->load->view('index', $page_data);
    }

    public function show($param2 = '')
    {
        $page_data['permission'] = 'user-show';

        if (userHasPermissions($page_data['permission'])) {
            $id = decrypt($param2);
            $dt = $this->user_model->getById($id);
            foreach ($dt as $row) {
                $row->user_id = encrypt($row->user_id);
            }
        }
        echo json_encode($dt);
        die;
    }

    public function edit($param2 = '')
    {
        $id = decrypt($param2);
        $dt = $this->user_model->getById($id);
        foreach ($dt as $row) {
            $row->user_id = encrypt($row->user_id);
        }
        echo json_encode($dt);
        die;
    }

    public function update($param2 = '')
    {
        $page_data['permission'] = 'user-update';

        if ($this->userHasPermissions($page_data['permission'])) {
            $user_id          = decrypt($param2);
            $data['nama']     = $this->input->post('nama');
            $data['email']    = $this->input->post('email');
            $data['username'] = $this->input->post('username');

            $this->user_model->update($user_id, $data);
            $this->user_role_model->delete($user_id);

            $role_id = $this->input->post('role_id');

            $user_role = array();
            foreach ($role_id as $key => $val) {
                $user_role[] = array(
                    'user_id' => $user_id,
                    'role_id' => $role_id[$key],
                );
            }

            if (is_array($role_id)) {
                $this->user_role_model->insert_batch($user_role);
            } else {
                $this->user_role_model->insert($user_role);
            }

            $this->log_model->addLog(userLog('Memperbaharui User', 'Memperbaharui data user ' . $data['nama']));

            echo json_encode(array('status' => 'success', 'msg' => 'User berhasil diperbaharui'));
        } else {
            echo json_encode(array('status' => 'error', 'msg' => 'Anda tidak berhak mengupdate data user'));
        }
        die;
    }

    public function delete($param2 = '')
    {
        $page_data['permission'] = 'user-delete';

        if ($this->userHasPermissions($page_data['permission'])) {
            $user_id        = decrypt($param2);
            $temp           = $this->user_model->getById($user_id);
            $data['status'] = 2;
            $this->user_model->update($user_id, $data);
            $this->user_role_model->delete($user_id);
            $this->log_model->addLog(userLog('Menghapus User', 'Menghapus user '));
            echo json_encode(array('status' => 'success', 'msg' => 'User berhasil dihapus'));
        } else {
            echo json_encode(array('status' => 'error', 'msg' => 'Anda tidak berhak menghapus data user'));
        }
        die;
    }

    public function reset($param2 = '')
    {
        if ($this->input->post('password') != $this->input->post('confirm_password')) {
            echo json_encode(array('status' => 'error', 'msg' => 'Confirm Password salah !'));
        } else {
            $user_id          = decrypt($param2);
            $temp             = $this->user_model->getById($user_id);
            $data['password'] = hash('sha512', $this->input->post('password'));
            $this->user_model->update($user_id, $data);
            $this->log_model->addLog(userLog('Memperbaharui User', 'Reset password user ' . $temp[0]->nama));
            echo json_encode(array('status' => 'success', 'msg' => 'Reset Password Berhasil !'));
        }
        die;
    }

    // public function pagination()
    // {
    //     $dt    = $this->user_model->getAllUser();
    //     $start = $this->input->post('start');
    //     $data  = array();
    //     $acc = array();
    //     foreach ($dt['data'] as $row) {
    //         $id       = encrypt($row->user_id);
    //         $li_btn   = array();

    //         $li_btn[] = '<a href="javascript:;" class="btnShow_' . $id . '" onClick=\'show_function(' . $id . ')\'>Show</a>';
    //         $li_btn[] = '<a href="javascript:;" class="btnEdit_' . $id . '" onClick=\'edit_function("show",' . $id . ')\'>Edit</a>';
    //         $li_btn[] = '<a href="javascript:;" class="btnDelete_' . $id . '" onClick=\'delete_function(' . $id . ')\'>Delete</a>';

    //         $th1 = ++$start . '.';
    //         $th2 = $row->nama;
    //         $th3 = $row->email;
    //         $th4 = $row->username;
    //         $th5 = $row->nama_role;

    //         $th6 = generateBtnAction($li_btn);
    //         $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6));
    //     }
    //     $dt['data'] = $data;
    //     echo json_encode($dt);
    //     die;
    // }

    public function pagination()
    {
        $dt    = $this->user_model->getAllUser();
        $start = $this->input->post('start');
        $data  = array();
        foreach ($dt['data'] as $row) {
            $id       = encrypt($row->user_id);
            $li_btn   = array();

            if (userHasPermissions('user-show')) {
                $li_btn[] = '<a href="javascript:;" class="btnShow_' . $id . '" onClick=\'show_function(' . $id . ')\'>Show</a>';
            }
            if (userHasPermissions('user-update')) {
                $li_btn[] = '<a href="javascript:;" class="btnEdit_' . $id . '" onClick=\'edit_function("show",' . $id . ')\'>Edit</a>';
            }
            if (userHasPermissions('user-delete')) {
                $li_btn[] = '<a href="javascript:;" class="btnDelete_' . $id . '" onClick=\'delete_function(' . $id . ')\'>Delete</a>';
            }

            $th1 = ++$start . '.';
            $th2 = $row->nama;
            $th3 = $row->email;
            $th4 = $row->username;
            $th5    = $row->nama_role;
            $th6    = generateBtnAction($li_btn);
            $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6));
        }
        $dt['data'] = $data;
        echo json_encode($dt);
        die;
    }
}
