<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends Middleware
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('role_model');
        $this->load->model('log_model');
        $this->load->model('user_role_model');
        $this->load->model('permission_model');
        $this->load->model('notif_model');

        $this->load->helper('permission');
        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');
        $this->load->helper('constraint');
        $this->load->helper('notif');
    }

    public function index()
    {
        $page_data['page_function']   = __FUNCTION__;
        $page_data['page_active']     = array('User');
        $page_data['page_name']       = 'user';
        $page_data['page_title']      = 'User';
        $page_data['nama_role']       = $this->role_model->getRoles()->result();
        $page_data['user']            = $this;

        $this->load->view('index', $page_data);
    }

    public function check_permission()
    {
        print_r($this->session->userdata('role_id'));
        print_r($this->session->userdata('permissions'));
        print_r($this->session->userdata('user_id'));
        // print_r($this->session->userdata('userData'));
    }

    public function add()
    {
        $page_data['permission'] = 'user-add';
        $data['nama']            = $this->input->post('nama');
        $data['email']           = $this->input->post('email');
        $data['username']        = $this->input->post('username');
        $data['password']        = hash('sha512', $this->input->post('password'));
        $data['status']          = 1;

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

                // insert user role
                $role_id = $this->input->post('role_id');
                $user_role = array();
                foreach ($role_id as $key => $val) {
                    $user_role[] = array(
                        'user_id' => $user_id,
                        'role_id' => $role_id[$key],
                    );
                }

                if (is_array($role_id)) {
                    $this->user_role_model->insert_batch($user_role); // jika role > 1 maka insert batch
                } else {
                    $this->user_role_model->insert($user_role);
                }

                $this->log_model->add(userLog('Menambah User', 'Menambah user "' . $data['nama']));
            }
        }

        echo json_encode($result);
        die;

        $this->load->view('index', $page_data);
    }

    public function show($param2 = '')
    {
        $data = array();
        $id = decrypt($param2);
        $dt = $this->user_role_model->getById($id);
        foreach ($dt as $row) {
            $nama        = $row->nama;
            $email       = $row->email;
            $username    = $row->username;
            $nama_role[] = " " . $row->nama_role;
        }
        $data[] = array("nama" => $nama, "email" => $email, "username" => $username, "nama_role" => $nama_role);

        echo json_encode($data);
        die;
    }

    public function edit($param2 = '')
    {
        $data = array();

        $id = decrypt($param2);
        $dt = $this->user_role_model->getById($id);
        foreach ($dt as $row) {
            $user_id    = encrypt($row->user_id);
            $role_id[]  = $row->role_id;
            $nama        = $row->nama;
            $email       = $row->email;
            $username    = $row->username;
            $nama_role[] = $row->nama_role;
        }

        $data = array("user_id" => $user_id, "role_id" => $role_id, "nama" => $nama, "email" => $email, "username" => $username, "nama_role" => $nama_role);
        echo json_encode($data);
        die;
    }

    public function update($param2 = '')
    {
        $user_id          = decrypt($param2);
        $data['nama']     = $this->input->post('nama');
        $data['email']    = $this->input->post('email');
        $data['username'] = $this->input->post('username');

        $this->user_model->update($user_id, $data);

        // update user role
        if (isAdmin()) {
            $this->user_role_model->delete($user_id);
            $role_id = $this->input->post('role_id');

            if (is_array($role_id) || is_object($role_id)) {
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
            }
            // insert notifikasi
            $this->notif_model->add(userNotif("Administrator Mengubah Role User " . $data['nama'], "Memperbaharui Role User", $user_id));
            $this->log_model->add(userLog('Memperbaharui User', 'Memperbaharui data user ' . $data['nama']));
        } else {
            echo json_encode(array('status' => 'error', 'msg' => 'Anda tidak bisa mengedit data ini'));
        }
        echo json_encode(array('status' => 'success', 'msg' => 'User berhasil diperbaharui'));
        die;
    }

    public function delete($param2 = '')
    {
        $user_id        = decrypt($param2);
        $temp           = $this->user_role_model->getById($user_id);
        $data['status'] = 2;
        $this->user_model->update($user_id, $data);
        $this->user_role_model->delete($user_id);
        $this->log_model->add(userLog('Menghapus User', 'Menghapus user '));
        echo json_encode(array('status' => 'success', 'msg' => 'User berhasil dihapus'));

        die;
    }

    public function reset()
    {
        if ($this->input->post('password') != $this->input->post('confirm_password')) {
            echo json_encode(array('status' => 'error', 'msg' => 'Confirm Password salah !'));
        } else {
            $user_id          = $this->session->userdata('user_id');
            $temp             = $this->user_role_model->getById($user_id);
            $data['password'] = hash('sha512', $this->input->post('password'));
            $this->user_model->update($user_id, $data);
            $this->log_model->add(userLog('Memperbaharui User', 'Reset password user ' . $temp[0]->nama));
            echo json_encode(array('status' => 'success', 'msg' => 'Reset Password Berhasil !'));
        }
        die;
    }

    public function pagination()
    {
        $dt    = $this->user_model->getAllUser();
        $start = $this->input->post('start');
        $data  = array();
        foreach ($dt['data'] as $row) {
            $id       = encrypt($row->user_id);
            $li_btn   = array();

            if (hasPermission('user-show')) {
                $li_btn[] = '<a href="javascript:;" class="btnShow_' . $id . '" onClick=\'show_function(' . $id . ')\'>Show</a>';
            }

            if (hasPermission('user-update')) {
                $li_btn[] = '<a href="javascript:;" class="btnEdit_' . $id . '" onClick=\'edit_function("show",' . $id . ')\'>Edit</a>';
            }

            if (hasPermission('user-delete')) {
                $li_btn[] = '<a href="javascript:;" class="btnDelete_' . $id . '" onClick=\'delete_function(' . $id . ')\'>Delete</a>';
            }

            $role = $this->role_model->getRoleByUser($row->user_id);
            $nama_role = json_decode(json_encode(array_column($role, 'nama_role')), true);

            $th1 = ++$start . '.';
            $th2 = $row->nama;
            $th3 = $row->email;
            $th4 = $row->username;
            $th5    = implode(", ", $nama_role);
            $th6    = generateBtnAction($li_btn);
            $data[] = gathered_data(array($th1, $th2, $th3, $th4, $th5, $th6));
        }
        $dt['data'] = $data;
        echo json_encode($dt);
        die;
    }

    public function userProfile()
    {
        if (!$this->session->userdata('logged_in')) {
            redirect('/user/userProfile');
        }

        $data['userData'] = $this->session->userdata('userData');

        $this->load->view('userProfile', $data);
    }
}
