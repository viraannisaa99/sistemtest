<?php include "template/header.php"; ?>
<link href="<?php echo base_url() . 'assets/' ?>css/bootstrap-select.css" rel="stylesheet" />

<body class="">

    <?php include "template/include_sidebar.php"; ?>

    <div class="main-panel">
        <?php include "template/include_navbar.php"; ?>

        <br><br><br><br>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="main-body">
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="<?php echo base_url() . 'profile/update/' ?>" method="POST">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Nama</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="nama" class="form-control" value="<?= $user_edit['nama'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Username</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="username" class="form-control" value="<?= $user_edit['username'] ?>">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-3">
                                            <h6 class="mb-0">Email</h6>
                                        </div>
                                        <div class="col-sm-9 text-secondary">
                                            <input type="text" name="email" class="form-control" value="<?= $user_edit['email'] ?>">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3"></div>
                                        <div class="col-sm-9 text-secondary">
                                            <button type="submit" class="btn btn-primary px-4">Save Changes</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "template/include_js.php"; ?>
</body>

</html>