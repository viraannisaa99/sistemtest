<script src="<?= base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>

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
                            <?= $jumlah_user[0]->total ?>
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
                            <?= $jumlah_admin[0]->total ?>
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
                            <?= $jumlah_pegawai[0]->total ?>
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
                            <?= $jumlah_kunjungan[0]->total ?>
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

    <div class="row">
        <div class="col-md-6">
            <div class="card card-chart">
                <div class="card-header">
                    <canvas id="myChart"></canvas>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Kunjungan Perminggu</h4>
                    <p class="card-category">
                        <span class="text-success"> </span> jumlah kunjungan
                        seluruh user perminggu
                    </p>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">access_time</i> updated 4 minutes ago
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-chart">
                <div class="card-header">
                    <canvas id="userChart"></canvas>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Jumlah Kunjungan Per-Role</h4>
                    <p class="card-category">
                        <span class="text-success"> </span> jumlah kunjungan
                        setiap user per-role
                    </p>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">access_time</i> updated 4 minutes ago
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">TOP 30 User Activity</h4>
                    <p class="card-category"> List Top 30 Aktivitas User</p>
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
                                    <h4><span class="badge badge-info badge-pill"><?= time_passed(strtotime($row->tgl)) ?></span>
                                    </h4>
                                </div>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="card-footer">
                        <?= $links; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script type="text/javascript">
    var ctx = document.getElementById('myChart').getContext('2d');

    var gradientStroke = ctx.createLinearGradient(500, 0, 100, 0);
    gradientStroke.addColorStop(0, "#80b6f4");
    gradientStroke.addColorStop(1, "#f49080");

    $(document).ready(function() {
        // Log graph per week
        $.ajax({
            url: "<?= base_url() . 'dashboard/weekBar/' ?>",
            success: function(data) {
                var parse = jQuery.parseJSON(data);
                var chart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: parse.tgl,
                        datasets: [{
                            label: 'Jumlah Kunjungan',
                            backgroundColor: gradientStroke,
                            borderColor: '#93C3D2',
                            data: parse.total
                        }]
                    }
                });
            }
        });

        // Log Graph per role
        $.ajax({
            url: "<?= base_url() . 'dashboard/roleBar/' ?>",
            success: function(data) {
                var parse = jQuery.parseJSON(data);

                var ctx = document.getElementById('userChart').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: parse.nama_role,
                        datasets: [{
                            label: 'Jumlah Kunjungan',
                            backgroundColor: gradientStroke,
                            borderColor: '#93C3D2',
                            data: parse.total
                        }]
                    }
                });
            }
        });
    });
</script>