<script src="<?php echo base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>

<div class="content">
    <div class="row">
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
                                    <th>Timestamp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($log as $row) : ?>
                                    <tr>
                                        <td><?= ++$start ?></td>
                                        <td><?= $row->nama ?></td>
                                        <td><?= $row->jenis_aksi ?></td>
                                        <td><?= $row->keterangan ?></td>
                                        <td><?= time_passed(strtotime($row->tgl)) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <?php echo $links; ?>
                </div>
            </div>
        </div>
    </div>
</div>