<?php include "template/header.php"; ?>

<body class="login-page">
    <div class="login-box">
        <div class="logo">
            <a href="javascript:void(0);">Login</a>
        </div>
        <div class="card">
            <div class="body">
                <?php echo form_open('login/oauth', array('id' => 'add-form', 'autocomplete' => "off")); ?>
                <?php if ($this->session->flashdata('error')) { ?>
                    <div class="clearfix alert alert-danger">
                        <strong>Oopss !</strong> <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon">
                        <i class="material-icons">lock</i>
                    </span>
                    <div class="form-line">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 justify-content-center">
                        <button class="btn btn-primary mx-auto d-block" type="submit">SIGN IN</button>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</body>

<?php include "template/include_js.php"; ?>