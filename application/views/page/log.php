<script src="<?php echo base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        table = $('#table_log').DataTable({
            "processing": true,
            "serverSide": true,
            "order": [],
            "lengthMenu": [
                [15, 25, 50, -1],
                [15, 25, 50, "All"]
            ],
            "responsive": true,
            "ajax": {
                "url": "<?php echo site_url('log/pagination') ?>",
                "type": "POST"
            },
            "order": [
                [0, "desc"]
            ],
            "columnDefs": [{
                "targets": [0],
                "className": "center"
            }]
        });
    });
</script>

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
                                    <th>Tanggal</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>