<script src="<?php echo base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
var id_edit;
var id_show;

function reset_form() {
    $("#editModalForm")[0].reset();
    $('.form-line').removeClass('focused');
}

function show_form() {
    $("#showModalForm")[0].reset();
    $('.form-line').removeClass('focused');
}

function updateAllTable() {
    table.ajax.reload(null, false);
}

function add_function() {
    $.ajax({
        method: 'POST',
        url: '<?php echo base_url() . 'role/add' ?>',
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
        url: '<?php echo base_url() . 'role/delete/' ?>' + id,
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
        url: '<?php echo base_url() . 'role/show/' ?>' + id,
        dataType: 'json',
        success: function(resp) {
            if (resp.length > 0) {
                for (var i = 0; i < resp.length; i++) {
                    id_show = resp[i]['user_id'];
                    $('#nama_role').text(resp[i]['nama_role']);
                    $('#action').text(resp[i]['action'] + " ");
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
            url: '<?php echo base_url() . 'role/edit/' ?>' + id,
            dataType: 'json',
            success: function(resp) {
                if (resp) {
                    for (var i = 0; i < resp.length; i++) {
                        id_edit = resp[i].role_id;
                        $("#editModalForm input[name=nama_role]").val(resp[i].nama_role);
                        for (var r = 0; r < resp[i].permission_id.length; r++) {
                            $(`#editModalForm input[name="permission_id[]"][value="${resp[i].permission_id[r]}"]`)
                                .prop('checked', true);
                        }
                    }
                }
            }
        });

    } else if (task == 'save') {
        $.ajax({
            method: 'POST',
            url: '<?php echo base_url() . 'role/update/' ?>' + id_edit,
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
    }
}

document.addEventListener("DOMContentLoaded", function(event) {
    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "order": [],
        "ajax": {
            "url": "<?php echo site_url('role/pagination') ?>",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [0],
            "orderable": false,
            "className": "center"
        }],
    });
});
</script>

<div class="content">
    <div class="clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <?php
            if (userHasPermissions('role-add')) { ?>
            <button type="button" class="btn bg-blue col-white waves-effect" data-toggle="collapse"
                data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <span>Tambah Role</span>
            </button>
            <?php } ?>
            <div class="collapse" id="collapseExample">
                <div class="card">
                    <h4 class="card-header card-header-primary">Tambahkan Role</h4>
                    <div class="card-body d-flex flex-column">
                        <?php echo form_open('role', array('id' => 'add-form', 'autocomplete' => "off")); ?>
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <div class="form-line">
                                    <input type="text" name="nama_role" class="form-control" placeholder="Nama Role"
                                        required>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <p>Pilih Role Permission</p>
                                <?php foreach ($permission as $row) : ?>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" class="form-check-input" name="permission[]"
                                            id="permission[]"
                                            value="<?php echo $row->permission_id; ?>"><?php echo $row->action; ?>
                                    </label>
                                </div>
                                <?php endforeach; ?>

                                <?php echo form_close(); ?>
                                <br><br>
                                <div class="submit-footer">
                                    <button type="button" class="btn bg-grey col-white waves-effect"
                                        data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
                                        aria-controls="collapseExample"><span>CANCEL</span></button>
                                    <button type="button" class="btn bg-green col-white waves-effect"
                                        onclick="add_function()"><span>SUBMIT</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div><br>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Daftar Role Sistem</h4>
                    <p class="card-category"> Here is a subtitle for this table</p>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-hover js-basic-example" id="table">
                                <thead class="text-primary">
                                    <tr>
                                        <th> # </th>
                                        <th> Nama Role </th>
                                        <th> Aksi </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Edit Role</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open('role', array('id' => 'editModalForm', 'autocomplete' => "off")); ?>
                        <div class="col-md-12">
                            <div class="form-group form-float">
                                <p><b></strong> Nama Role </b></p>
                                <div class="input-group">
                                    <div class="form-line">
                                        <input type="text" name="nama_role" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group form-float">
                                <?php
                                if (is_array($permission)) {
                                    foreach ($permission as $row) : ?>
                                <div class="form-check-inline">
                                    <label class="form-check-label">
                                        <input type="checkbox" name="permission_id[]" id="permission_id[]"
                                            value="<?= $row->permission_id ?>">
                                        <?= $row->action ?>
                                    </label>
                                </div>
                                <?php endforeach;
                                } ?>
                            </div>
                        </div>

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
                        <h5 class="modal-title" id="exampleModalLongTitle">Role Detail</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo form_open('role', array('id' => 'showModalForm', 'autocomplete' => "off")); ?>
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>
                                    <p id="nama_role"></p>
                                </td>
                            </tr>
                            <tr>
                                <th>Permission</th>
                                <td>:</td>
                                <td>
                                    <p id="action"></p>
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