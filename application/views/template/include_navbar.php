<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <a class="navbar-brand" href="javascript:;">
                <h3 style="margin-top:0px"><b><?php echo $page_title ?></b></h3>
            </a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index"
            aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="javascript:;">
                        <i class="material-icons">dashboard</i>
                        <p class="d-lg-none d-md-block">
                            Stats
                        </p>
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">notifications</i>
                        <span class="notification" id="total-notif"></span>
                        <p class="d-lg-none d-md-block">
                            Some Actions
                        </p>
                    </a>
                    <div class="dropdown-menu notif dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#" id="judul" name="judul"></a>
                        <a class="dropdown-item" href="<?= base_url() . "notification" ?>">Lihat notifikasi lainnya</a>
                    </div>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link" href="javascript:;" id="navbarDropdownProfile" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="material-icons">person</i>
                        <p class="d-lg-none d-md-block">
                            Account
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownProfile">
                        <a class="dropdown-item" href="<?php echo base_url() . 'profile' ?>">Profile</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="<?php echo base_url() . 'login/logout' ?>">Log out</a>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script src="<?php echo base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    setInterval(function() {
        $.ajax({
            url: "<?= base_url() ?>notification/totalNotif", // count notifikasi
            type: "POST",
            dataType: "json",
            data: {},
            success: function(data) {
                $("#total-notif").html(data.total);
            }
        });
    }, 2000);
})

$(document).ready(function() {
    $.ajax({
        url: "<?= base_url() ?>notification/listNotif", // list notifikasi
        type: "POST",
        dataType: "json",
        success: function(resp) {
            if (resp) {
                // $('#judul').html(resp.judul);
                $.each(resp.judul, function() {
                    $("#judul").html(resp.judul);
                });
                resp.preventDefault();
            }
        }
    });
})

$(document).on('click', '.notif', function() {
    $.ajax({
        url: "<?= base_url() ?>notification/isRead", // jika sudah di read, maka ubah baca = 1
        type: "POST",
        dataType: "json",
        data: {},
        success: function(data) {
            $('#total-notif').html('');
        }
    });
    $('#total-notif').html('');
});
</script>