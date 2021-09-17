<script src="<?php echo base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    function show_function(id) {
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
                        $('#level').text(resp[i]['level']).prop("selected", true);
                        $("#username").text(resp[i]['username']);
                    }
                }
            }
        });
    }
</script>

<?php include "template/header.php"; ?>

<body class="">
    <div class="wrapper ">
        <?php include "template/include_sidebar.php"; ?>
        <div class="main-panel">
            <?php include "template/include_navbar.php"; ?>
            <div class="content">
                <div class="clearfix">
                    <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
                        <table class="table">
                            <tr>
                                <th>Nama</th>
                                <td>:</td>
                                <td>
                                    <span id="nama" name="nama"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>:</td>
                                <td>
                                    <span id="email" name="email"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Username</th>
                                <td>:</td>
                                <td>
                                    <span id="username" name="username"></span>
                                </td>
                            </tr>
                            <tr>
                                <th>Level</th>
                                <td>:</td>
                                <td>
                                    <span id="level" name="level"></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <?php include "template/footer.php"; ?>
        </div>
    </div>
    <?php include "template/include_js.php"; ?>
</body>