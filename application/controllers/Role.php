<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends Middleware
{
    function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('role_model');
        $this->load->model('log_model');
        $this->load->model('notif_model');
        $this->load->model('user_role_model');
        $this->load->model('role_permission_model');
        $this->load->model('permission_model');
        $this->load->helper('notif');

        $this->load->helper('format');
        $this->load->helper('userlog');
        $this->load->helper('encrypt');
        $this->load->helper('datetime');
        $this->load->helper('permission');

        $this->load->library('pagination');
    }

    public function index()
    {
        $page_data['page_function']   = __FUNCTION__;
        $page_data['page_active']     = array('Role');
        $page_data['page_name']       = 'role';
        $page_data['page_title']      = 'Role';
        $page_data['permission']      = $this->permission_model->getPermission()->result();

        $this->load->view('index', $page_data);
    }

    public function add()
    {
        $page_data['permission'] = 'role-add';
        $data['nama_role']       = $this->input->post('nama_role');
        $data['status']          = 1;

        $empty = check_empty_form($data, array('nama_role'));
        if ($empty) {
            $result = array('status' => 'error', 'msg' => 'Form penting tidak boleh kosong !');
        } else {
            $result = array('status' => 'success', 'msg' => 'Role berhasil ditambahkan');
            $this->role_model->add($data);

            $role_id = $this->db->insert_id();

            // insert role permission
            $permission = $this->input->post('permission');
            $role_permission = array();
            foreach ($permission as $key => $val) {
                $role_permission[] = array(
                    'role_id' => $role_id,
                    'permission_id' => $permission[$key],
                );
            }

            if (is_array($permission)) {
                $this->role_permission_model->insert_batch($role_permission);
            } else {
                $this->role_permission_model->insert($role_permission);
            }

            $this->log_model->addLog(userLog('Menambah Role', 'Menambah role "' . $data['nama_role']));
        }

        echo json_encode($result);
        die;

        $this->load->view('index', $page_data);
    }

    public function show($param2 = '')
    {
        $data = array();
        $id = decrypt($param2);
        $dt = $this->role_model->getRoleById($id);

        foreach ($dt as $row) {
            $nama_role = $row->nama_role;
        }

        $perm = $this->permission_model->getPermissionByRole($id);
        foreach ($perm as $rows) {
            $action[] = " " . $rows->action;
        }
        $data[] = array(
            "nama_role" => $nama_role,
            "action" => $action
        );

        echo json_encode($data);
        die;
    }

    public function edit($param2 = '')
    {
        $data = array();
        $id = decrypt($param2);
        $dt = $this->role_permission_model->getById($id);

        foreach ($dt as $row) {
            $data[] = array(
                "role_id" => encrypt($row->role_id),
                "nama_role" => $row->nama_role,
                "permission_id" => $row->permission_id,
                "action" => $row->action
            );
        }
        echo json_encode($data);
        die;
    }

    public function update($param2 = '')
    {
        $role_id               = decrypt($param2);
        $data['nama_role']     = $this->input->post('nama_role');

        $this->role_model->update($role_id, $data);
        $this->role_permission_model->delete($role_id);

        // update role permission
        $permission = $this->input->post('permission_id');
        if (is_array($permission) || is_object($permission)) {
            $role_permission = array();

            foreach ($permission as $key => $val) {
                $role_permission[] = array(
                    'role_id' => $role_id,
                    'permission_id' => $permission[$key],
                );
            }

            if (is_array($permission)) {
                $this->role_permission_model->insert_batch($role_permission);
            } else {
                $this->role_permission_model->insert($role_permission);
            }

            // insert notifikasi
            $select = $this->user_role_model->getUserByRole($role_id);
            $roles = array();

            foreach ($select as $key) {
                $roles[] = array(
                    'judul'   => "Administrator Mengubah Role Permission untuk " . $key->nama_role,
                    'tipe'    => "Memperbaharui Role Permission ",
                    'baca'    => 0,
                    'user_id' => $key->user_id,
                    'link'    => site_url('profile/index'),
                    'tanggal' => date("Y-m-d H:i:s")
                );
            }

            if (is_array($roles)) {
                $this->notif_model->insert_batch($roles); // jika user dengan role tersebut > 1
            } else {
                $this->notif_model->add($roles);
            }
        }
        $this->log_model->addLog(userLog('Memperbaharui Role', 'Memperbaharui data role ' . $data['nama_role']));
        echo json_encode(array('status' => 'success', 'msg' => 'Role berhasil diperbaharui'));

        die;
    }

    public function delete($param2 = '')
    {
        $role_id        = decrypt($param2);
        $temp           = $this->role_model->getRoleById($role_id);
        $data['status'] = 2;
        $this->role_model->update($role_id, $data);
        $this->log_model->addLog(userLog('Menghapus Role', 'Menghapus role '));
        echo json_encode(array('status' => 'success', 'msg' => 'Role berhasil dihapus'));

        die;
    }

    public function pagination()
    {
        $dt    = $this->role_model->getAllRole();
        $start = $this->input->post('start');
        $data  = array();
        foreach ($dt['data'] as $row) {
            $id       = encrypt($row->role_id);
            $li_btn   = array();

            if (userHasPermissions('role-show')) {
                $li_btn[] = '<a href="javascript:;" class="btnShow_' . $id . '" onClick=\'show_function(' . $id . ')\'>Show</a>';
            }

            if (userHasPermissions('role-update')) {
                $li_btn[] = '<a href="javascript:;" class="btnEdit_' . $id . '" onClick=\'edit_function("show",' . $id . ')\'>Edit</a>';
            }

            if (userHasPermissions('role-delete')) {
                $li_btn[] = '<a href="javascript:;" class="btnDelete_' . $id . '" onClick=\'delete_function(' . $id . ')\'>Delete</a>';
            }

            $th1 = ++$start . '.';
            $th2 = $row->nama_role;
            $th3    = generateBtnAction($li_btn);
            $data[] = gathered_data(array($th1, $th2, $th3));
        }
        $dt['data'] = $data;
        echo json_encode($dt);
        die;
    }
}