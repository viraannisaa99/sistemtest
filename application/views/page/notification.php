<script src="<?= base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function(event) {
    table = $('#table').DataTable({
        "processing": true,
        "serverSide": true,
        "responsive": true,
        "order": [
            [0, "desc"]
        ],
        "ajax": {
            "url": "<?= site_url('notification/pagination') ?>",
            "type": "POST"
        },
        "columnDefs": [{
            "targets": [0],
            "className": "center",
        }],

        dom: "<'row'<'col-4'B><'col-4'l><'col-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'ip>>",
        buttons: ['excel', 'print']
    });
});
</script>

<div class="content">
    <div class="clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Daftar Notifikasi User</h4>
                    <p class="card-category"> List Daftar Notifikasi User</p>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover js-basic-example" id="table">
                            <thead class="text-primary">
                                <tr>
                                    <th> # </th>
                                    <th> Judul</th>
                                    <th> Tipe </th>
                                    <th> Link </th>
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