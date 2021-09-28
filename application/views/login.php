<?php include "template/header.php"; ?>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Login</a>
        </div>
        <div class="card">
            <div class="body">
                <?= form_open('login/oauth', array('id' => 'add-form', 'autocomplete' => "off")); ?>
                <?php if ($this->session->flashdata('error')) { ?>
                <div class="clearfix alert alert-danger">
                    <strong>Oopss !</strong> <?= $this->session->flashdata('error'); ?>
                </div>
                <?php } ?>
                <div class="input-group">
                    <div class="form-line">
                        <input type="text" class="form-control" name="username" placeholder="Username" required
                            autofocus>
                    </div>
                </div>
                <div class="input-group">
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 justify-content-center mx-auto d-block">
                        <button class="btn btn-primary mx-auto d-block" type="submit">SIGN IN</button>
                    </div>
                </div>
                <?= form_close(); ?>

                <div class="row">
                    <div class="col-lg-8 justify-content-center mx-auto d-block">
                        <a role="button" class="btn bg-transparent btn-primary-outline" style="text-transform:none"
                            href="<?= $loginURL; ?>"><img width="20px" style="margin-bottom:3px; margin-right:5px"
                                alt="Google sign-in"
                                src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/53/Google_%22G%22_Logo.svg/512px-Google_%22G%22_Logo.svg.png" />
                            Login with Google
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<?php include "template/include_js.php"; ?>