<div class="content">
    <div class="clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <a href="<?php echo base_url('profile/export'); ?>" class="btn bg-blue col-white waves-effect">Export
                Profile</a>
            <div class="main-body">
                <div class="row gutters-sm">
                    <div class="col-md-5 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex flex-column align-items-center text-center">
                                    <img src="<?= $profile->picture ?>" alt="Admin" class="rounded-circle" width="150">
                                    <div class="mt-3">
                                        <h4><?= $profile->nama ?></h4>
                                        <p class="text-secondary mb-1">
                                            <?= ($profile->status == 1) ? 'Active' : 'Non Active'; ?></p>
                                        <!-- <p class="text-muted font-size-sm">Bay Area, San Francisco, CA</p> -->
                                        <button class="btn btn-primary" class="btn bg-blue col-white waves-effect" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Reset Password</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse" id="collapseExample">
                            <div class="card mt-3">
                                <?= form_open('user', array('id' => 'resetForm', 'autocomplete' => "off")); ?>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="col-sm-12 text-secondary">
                                            <input type="password" name="password" class="form-control" placeholder="New Password">
                                        </div>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                        <div class="col-sm-12 text-secondary">
                                            <input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password">
                                        </div>
                                    </li>
                                </ul>
                                <?= form_close() ?>
                                <button type="button" class="btn bg-green waves-effect col-white" onClick="edit_function('reset')">RESET PASSWORD</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card mb-3">
                            <div class="card-body">
                                <?= form_open('profile', array('id' => 'editForm', 'autocomplete' => "off")); ?>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Nama</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="nama" class="form-control" value="<?= $profile->nama ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Username</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="username" class="form-control" value="<?= $profile->username ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Email</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <input type="text" name="email" class="form-control" value="<?= $profile->email ?>">
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Role</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?= implode(", ", $this->session->userdata('nama_role')); ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <h6 class="mb-0">Permission</h6>
                                    </div>
                                    <div class="col-sm-9 text-secondary">
                                        <?= implode(", ", $this->session->userdata('permissions')); ?>
                                    </div>
                                </div>
                                <hr>
                                <?= form_close() ?>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button type="submit" class="btn btn-primary px-4" onClick="edit_function('save')">Edit Profile</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
    var id_edit;

    function edit_function(task, id) {
        if (task == 'show') {
            $.ajax({
                method: 'POST',
                url: '<?= base_url() . 'profile/edit/' ?>',
                dataType: 'json',
                success: function(resp) {
                    if (resp) {
                        $("#editForm input[name=nama]").val(resp.nama);
                        $("#editForm input[name=email]").val(resp.email);
                        $("#editForm input[name=username]").val(resp.username);
                    }
                }
            });
        } else if (task == 'save') {
            $.ajax({
                method: 'POST',
                url: '<?= base_url() . 'profile/update/' ?>',
                data: $('#editForm').serialize(),
                dataType: 'json',
                success: function(resp) {
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
                url: '<?= base_url() . 'profile/reset/' ?>',
                data: $('#resetForm').serialize(),
                dataType: 'json',
                success: function(resp) {
                    if (resp['status'] == 'success') {

                    }

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
</script>