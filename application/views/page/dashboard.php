<script src="<?php echo base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    // document.addEventListener("DOMContentLoaded", function(event) {
    //     table = $('#table_log').DataTable({
    //         "processing": true,
    //         "serverSide": true,
    //         "order": [],
    //         "lengthMenu": [
    //             [15, 25, 50, -1],
    //             [15, 25, 50, "All"]
    //         ],
    //         "responsive": true,
    //         "ajax": {
    //             "url": "<?php echo site_url('log/pagination') ?>",
    //             "type": "POST"
    //         },
    //         "order": [
    //             [0, "desc"]
    //         ],
    //         "columnDefs": [{
    //             "targets": [0],
    //             "className": "center"
    //         }]
    //     });
    // });
</script>


<style>
    ul.list-group.list-group-striped li:nth-of-type(odd) {
        background: #edf2fb;
    }

    ul.list-group.list-group-striped li:nth-of-type(even) {
        background: #d7e3fc;
    }

    ul.list-group.list-group-hover li:hover {
        background: #CCCCFF;
    }
</style>


<div class="content">
    <div class="container-fluid">
        <div class="row clearfix">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-warning card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">person</i>
                        </div>
                        <p class="card-category">Pengguna</p>
                        <h3 class="card-title">
                            <?php echo $jumlah_user[0]->total ?>
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">warning</i> Jumlah Pengguna
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-success card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">person</i>
                        </div>
                        <p class="card-category">Admin</p>
                        <h3 class="card-title">
                            <?php echo $jumlah_admin[0]->total ?>
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">warning</i>Jumlah Admin
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-danger card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">person</i>
                        </div>
                        <p class="card-category">Pegawai</p>
                        <h3 class="card-title">
                            <?php echo $jumlah_pegawai[0]->total ?>
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">warning</i> Jumlah Pegawai
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="card card-stats">
                    <div class="card-header card-header-primary card-header-icon">
                        <div class="card-icon">
                            <i class="material-icons">person</i>
                        </div>
                        <p class="card-category">Kunjungan</p>
                        <h3 class="card-title">
                            <?php echo $jumlah_kunjungan[0]->total ?>
                        </h3>
                    </div>
                    <div class="card-footer">
                        <div class="stats">
                            <i class="material-icons">warning</i> Jumlah Kunjungan
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Aktivitas User Sistem</h4>
                    <p class="card-category"> Here is a subtitle for this table</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example" id="table_log">
                            <thead class=" text-primary">
                                <tr>
                                    <th>#</th>
                                    <th>User</th>
                                    <th>Aksi</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">TOP 30 User Activity</h4>
                    <p class="card-category"> Here is a subtitle for this table</p>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-hover list-group-striped">
                        <?php $i = 1;
                        foreach ($log as $row) : ?>
                            <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                                <div class="flex-column">
                                    <h4><b><?= $row->nama ?></b></h4>
                                    <?= $row->keterangan ?>
                                </div>
                                <div class="flex-column">
                                    <h4><span class="badge badge-info badge-pill"><?= time_passed(strtotime($row->tgl)) ?></span></h4>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="card-footer">
                        <?php echo $links; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>