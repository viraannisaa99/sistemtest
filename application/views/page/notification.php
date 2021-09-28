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
        </div>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Notification List</h4>
                    <p class="card-category"> List Notifikasi User</p>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-hover list-group-striped">
                        <?php $i = 1;
                        foreach ($notif as $row) : ?>
                            <li class="list-group-item list-group-item d-flex justify-content-between align-items-center">
                                <div class="flex-column">
                                    <h4><b><?= $row->judul ?></b></h4>
                                    <?= $row->tipe ?><br>
                                    <a href="<?= $row->link ?>">Lihat perubahan</a>

                                </div>
                                <div class="flex-column">
                                    <h4><span class="badge badge-info badge-pill"><?= time_passed(strtotime($row->tanggal)) ?></span>
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