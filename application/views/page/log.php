<script src="<?= base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        var table = $('#table').DataTable({
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
                "type": "POST",
            },
            "columnDefs": [{
                "searchable": false,
                "targets": 1,
                "className": "center",
            }],
            dom: "<'row'<'col-4'B><'col-4'l><'col-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'ip>>",
            buttons: [{
                    extends: 'excel',
                    text: 'Export All Data'
                },
                {
                    extends: 'print',
                    text: 'Print Log'
                }
            ]
        });
    });
</script>

<div class="content">
    <div class="clearfix">
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
            <button type="button" class="btn bg-blue col-white waves-effect" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                <span>Export By Date</span>
            </button>
            <div class="collapse" id="collapseExample">
                <div class="card">
                    <h4 class="card-header card-header-primary">Masukkan Tanggal</h4>
                    <div class="card-body d-flex flex-column">
                        <form action="<?php echo base_url('log/export'); ?>" method="POST" targets="_blank">
                            <div class="col-md-12">
                                <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.js" integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk=" crossorigin="anonymous"></script>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="date" name="tgl_a" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <input type="date" name="tgl_b" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8">
                                        <input type="submit" class="btn btn-primary btn-sm" name="export_excel" id="export_excel" value="Export Data Range">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div><br>
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Daftar User Sistem</h4>
                    <p class="card-category"> List Daftar User Sistem</p>
                </div>
                <div class="card-body">

                    <div class="form-group">
                        <label>Pilih Role</label>
                        <select class="form-control role" name="role" id="role">
                            <option>-- Pilih --</option>
                            <?php foreach ($nama_role as $row) : ?>
                                <option value="<?= $row->nama_role ?>"><?= $row->nama_role ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- <form action="<?php echo base_url('log/export'); ?>" method="POST" targets="_blank">
                        <tbody>
                            <tr>
                                <td>From:</td>
                                <td><input name="tgl_a" id="tgl_a" type="date"></td>
                            </tr>
                            <tr>
                                <td>To:</td>
                                <td><input name="tgl_b" id="tgl_b" type="date"></td>
                            </tr>

                            <input type="submit" class="btn btn-primary btn-sm" name="export_excel" class="tanggal"
                                id="export_excel" value="Export Data Range">
                        </tbody>


                    </form> -->

                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example" id="table">
                            <thead class="text-primary">
                                <tr>
                                    <th> # </th>
                                    <th> Jenis Aksi</th>
                                    <th> Keterangan </th>
                                    <th> Tanggal </th>
                                    <th> Role </th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>