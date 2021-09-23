<script src="<?php echo base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
var id_edit;
var id_show;

function reset_form() {
    $("#editModalForm")[0].reset();
    $('.form-line').removeClass('focused');
    $('#editModalForm select[name=nama_role] option[value=""]').prop("checked", true).trigger('change');
}

function show_form() {
    $("#showModalForm")[0].reset();
    $('.form-line').removeClass('focused');
    $('#showModalForm select[name=nama_role] option[value=""]').prop("checked", true).trigger('change');
}

function updateAllTable() {
    table.ajax.reload(null, false);
}

function add_function() {
    $.ajax({
        method: 'POST',
        url: '<?php echo base_url() . 'user/add' ?>',
        data: $('#add-form').serialize(),
        dataType: 'json',
        success: function(resp) {
            if (resp['status'] == 'success') {
                updateAllTable();
                $("#add-form")[0].reset();
            }
            return swal({
                timer: 1300,
                showConfirmButton: true,
                title: resp['msg'],
                type: resp['status']
            });
        }
    });
}

function delete_function(id) {
    $.ajax({
        method: 'POST',
        url: '<?php echo base_url() . 'user/delete/' ?>' + id,
        dataType: 'json',
        success: function(resp) {
            updateAllTable();
            return swal({
                timer: 1300,
                showConfirmButton: false,
                title: resp['msg'],
                type: resp['status']
            });
        }
    });
}

function show_function(id) {
    show_form();
    $('#showModal').modal();
    $.ajax({
        method: 'POST',
        url: '<?php echo base_url() . 'user/show/' ?>' + id,
        dataType: 'json',
        success: function(resp) {
            if (resp.length > 0) {
                for (var i = 0; i < resp.length; i++) {
                    id_show = resp[i]['user_id'];
                    $('#nama').text(resp[i]['nama']);
                    $("#email").text(resp[i]['email']);
                    $("#username").text(resp[i]['username']);
                    $("#nama_role").text(resp[i]['nama_role']);
                }
                $('#showModalForm div[class=form-line]').addClass('focused');
            }
        }
    });
}

function edit_function(task, id) {
    if (task == 'show') {
        reset_form();
        $('#editModal').modal();
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . 'user/edit/' ?>' + id,
            dataType: 'json',
            success: function(resp) {
                if (resp.length > 0) {
                    for (var i = 0; i < resp.length; i++) {
                        id_edit = resp[i]['user_id'];
                        $("#editModalForm input[name=nama]").val(resp[i]['nama']);
                        $("#editModalForm input[name=email]").val(resp[i]['email']);
                        $('#editModalForm select[name=nama_role] option[value="' + resp[i]['nama_role'] +
                            '"]').prop("selected", true).trigger('change');
                        $("#editModalForm input[name=username]").val(resp[i]['username']);
                    }
                    $('#editModalForm div[class=form-line]').addClass('focused');
                }
            }
        });
    } else if (task == 'save') {
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . 'user/update/' ?>' + id_edit,
            data: $('#editModalForm').serialize(),
            dataType: 'json',
            success: function(resp) {
                updateAllTable();
                return swal({
                    html: true,
                    timer: 1300,
                    showConfirmButton: false,
                    title: resp['msg'],
                    type: resp['status']
                });
            }
        });
    } else if (task == 'reset') {
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . 'user/reset/' ?>' + id_edit,
            data: $('#resetModalForm').serialize(),
            dataType: 'json',
            success: function(resp) {
                if (resp['status'] == 'success') {
                    updateAllTable();
                }
                $("#editModalForm")[0].reset();
                return swal({
                    html: true,
                    timer: 1300,
                    showConfirmButton: false,
                    title: resp['msg'],
                    type: resp['status']
                });
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", function(event) {
    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('user/pagination') ?>",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [0],
            "className": "center",
            "orderable": false,
        }],
    });
});
</script>

<div class="content">
    <div class="clearfix">
        <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
            <?php
            if (userHasPermissions('user-add')) { ?>
            <button type="button" class="btn bg-blue col-white waves-effect" data-toggle="collapse"
                data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <span>Tambah Pengguna</span>
            </button>
            <?php } ?>
            <div class="collapse" id="collapseExample">
                <div class="card">
                    <h4 class="card-header card-header-primary">Tambahkan Pengguna</h4>
                    <div class="card-body d-flex flex-column">
                        <?php echo form_open('user', array('id' => 'add-form', 'autocomplete' => "off")); ?>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="nama" class="form-control" placeholder="Nama"
                                                required>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="password" name="password" placeholder="Password"
                                                class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="password" name="confirm_password" class="form-control"
                                                placeholder="Confirm Password" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-float">
                                        <div class="form-line">
                                            <input type="text" name="username" class="form-control"
                                                placeholder="Username" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-float">
                                        <p>Pilih Hak Akses</p>
                                        <?php
                                        if (is_array($nama_role)) {
                                            foreach ($nama_role as $row) : ?>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="form-check-input" name="role_id[]"
                                                    id="role_id[]"
                                                    value="<?php echo $row->role_id; ?>"><?php echo $row->nama_role; ?>
                                            </label>
                                        </div>
                                        <?php endforeach;
                                        } ?>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            <br><br>
                            <div class="submit-footer">
                                <button type="button" class="btn bg-grey col-white waves-effect" data-toggle="collapse"
                                    data-target="#collapseExample" aria-expanded="false"
                                    aria-controls="collapseExample"><span>CANCEL</span></button>
                                <button type="button" class="btn bg-green col-white waves-effect"
                                    onclick="add_function()"><span>SUBMIT</span></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div><br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Daftar User Sistem</h4>
                    <p class="card-category"> List Daftar User Sistem</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example" id="table">
                            <thead class="text-primary">
                                <tr>
                                    <th> # </th>
                                    <th> Nama</th>
                                    <th> Email </th>
                                    <th> Username </th>
                                    <th> Role </th>
                                    <th> Aksi </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open('user', array('id' => 'editModalForm', 'autocomplete' => "off")); ?>
                        <div class="col-md-12">
                            <p><b></strong> Nama</b></p>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="text" name="nama" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p><b>Email</b></p>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="text" name="email" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <p><b> Username</b></p>
                            <div class="input-group">
                                <div class="form-line">
                                    <input type="text" name="username" class="form-control">
                                </div>
                            </div>
                        </div>
                        <?php if (userIsAdmin()) { ?>
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <p>Pilih Hak Akses</p>
                                <?php
                                    if (is_array($nama_role)) {
                                        foreach ($nama_role as $row) : ?>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="role_id[]" id="role_id[]"
                                            value="<?php echo $row->role_id; ?>"><?php echo $row->nama_role; ?>
                                    </label>
                                </div>

                                <?php endforeach;
                                    } ?>
                            </div>
                        </div>
                        <?php } ?>
                        <?php echo form_close(); ?>
                        <div class="modal-footer">
                            <button type="button" class="btn bg-green waves-effect col-white"
                                onClick="edit_function('save')">SAVE CHANGES</button>
                            <button type="button" class="btn bg-grey waves-effect col-white"
                                data-dismiss="modal">CLOSE</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Show -->
        <div class="modal fade" id="showModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">User Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open('user', array('id' => 'showModalForm', 'autocomplete' => "off")); ?>
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>
                                    <div id="nama"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>:</td>
                                <td>
                                    <div id="email"></div>
                                </td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>:</td>
                                <td>
                                    <div id="username"></div>
                                </td>
                            </tr>

                            <tr>
                                <th>Role</th>
                                <td>:</td>
                                <td>
                                    <div id="nama_role"></div>
                                </td>
                            </tr>
                        </table>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>