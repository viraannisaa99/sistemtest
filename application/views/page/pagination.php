<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Data Role</title>
    <!--Load file bootstrap.css-->
    <link rel="stylesheet" type="text/css" href="<?php echo base_url() . 'assets/css/bootstrap.css' ?>">
</head>

<body>

    <div class="container">
        <h1>Data <strong>Role</strong></h1>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>NAMA</th>
                </tr>
            </thead>
            <tbody>
                <!--Fetch data dari database-->
                <?php foreach ($data->result() as $row) : ?>
                    <tr>
                        <td><?php echo $row->nama_role; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="row">
            <div class="col">
                <!--Tampilkan pagination-->
                <?php echo $pagination; ?>
            </div>
        </div>


    </div>
    <!--Load file bootstrap.js-->
    <script type="text/javascript" src="<?php echo base_url() . 'assets/js/bootstrap.js' ?>"></script>
</body>

</html>