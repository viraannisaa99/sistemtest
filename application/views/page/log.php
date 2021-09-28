<script src="<?= base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" />
<script src="//code.jquery.com/jquery-1.10.2.js"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "order": [
            [0, "desc"]
        ],
        "lengthMenu": [
            [15, 25, 50, -1],
            [15, 25, 50, "All"]
        ],
        "ajax": {
            "url": "<?= site_url('log/pagination') ?>",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [0],
            "className": "center",
        }],
    });
});

$(document).ready(function() {
    jQuery(function($) {
        $("#datepicker_from").datepicker({
            showOn: "button",
            "onSelect": function(date) {
                minDateFilter = new Date(date).getTime();
                oTable.fnDraw();
            }
        }).keyup(function() {
            minDateFilter = new Date(this.value).getTime();
            oTable.fnDraw();
        });

        $("#datepicker_to").datepicker({
            showOn: "button",
            buttonImage: "images/calendar.gif",
            buttonImageOnly: false,
            "onSelect": function(date) {
                maxDateFilter = new Date(date).getTime();
                oTable.fnDraw();
            }
        }).keyup(function() {
            maxDateFilter = new Date(this.value).getTime();
            oTable.fnDraw();
        });
    });
});
</script>

<div class="content">
    <div class="row">
        <div class="clearfix"></div><br>
        <div class="col-md-12">
            <a href="<?php echo base_url('log/export'); ?>" class="btn bg-blue col-white waves-effect">Export Log</a>
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Daftar User Sistem</h4>
                    <p class="card-category"> List Daftar User Sistem</p>
                </div>

                <div class="card-body">
                    <!-- <td>
                        <div id="datepicker_from"></div>
                    </td>
                    <td>
                        <div id="datepicker_to"></div>
                    </td> -->

                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example" id="table">
                            <thead class="text-primary">
                                <tr>
                                    <th> # </th>
                                    <th> Jenis Aksi</th>
                                    <th> Keterangan </th>
                                    <th> Tanggal </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- <div class="col-md-12">
            <a href="<?php echo base_url('log/export'); ?>" class="btn bg-blue col-white waves-effect">Export Log</a>
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
                    <?= $links; ?>
                </div>
            </div>
        </div> -->
</div>
</div>