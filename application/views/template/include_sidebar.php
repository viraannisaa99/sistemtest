<div class="sidebar" data-color="purple" data-background-color="white" data-image="<?php echo base_url() . 'assets/' ?>img/apple-icon.png">
    <div class="logo"><a href="http://www.creative-tim.com" class="simple-text logo-normal">
            <?php
            echo $this->session->userdata('nama');
            ?>
            <br>
            <?php
            echo $this->session->userdata('login_type');
            ?>
        </a></div>
    <div class="sidebar-wrapper">
        <ul class="nav">
            <li class="nav-item active">
                <a class="nav-link" href="<?php echo base_url() . 'dashboard' ?>">
                    <i class=" material-icons">dashboard</i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="<?php echo base_url() . 'user' ?>">
                    <i class="material-icons">person</i>
                    <p>User Panel</p>
                </a>
            </li>

            <?php
            if ($this->session->userdata('login_type') == "Administrator") { ?>
                <li class="nav-item ">
                    <a class="nav-link" href="<?php echo base_url() . 'role' ?>">
                        <i class="material-icons">person</i>
                        <p>Role Panel</p>
                    </a>
                </li>
            <?php } ?>
            <li class="nav-item ">
                <a class="nav-link" href="<?php echo base_url() . 'log' ?>">
                    <i class="material-icons">library_books</i>
                    <p>Log System</p>
                </a>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="<?php echo base_url() . 'login/logout' ?>">
                    <i class="material-icons">logout</i>
                    <p>Logout</p>
                </a>
            </li>
        </ul>
    </div>
</div>