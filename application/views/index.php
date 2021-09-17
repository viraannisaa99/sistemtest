<?php include "template/header.php"; ?>
<link href="<?php echo base_url() . 'assets/' ?>css/bootstrap-select.css" rel="stylesheet" />

<body class="">
    <div class="wrapper ">
        <?php include "template/include_sidebar.php"; ?>
        <div class="main-panel">
            <?php include "template/include_navbar.php"; ?>

            <?php include 'page/' . $page_name . '.php'; ?>

        </div>
        <!-- <?php include "template/footer.php"; ?> -->
    </div>
    <?php include "template/include_js.php"; ?>
</body>

</html>