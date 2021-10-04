<div class="content">
    <div class="clearfix">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Daftar User Sistem</h4>
                    <p class="card-category"> List Daftar User Sistem</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Filter Tanggal</label>
                            <form action="<?php echo base_url('log/export'); ?>" method="POST" targets="_blank" id="cpa-form">
                                <div class="row">
                                    <div class="form-group col-md-4 form-float">
                                        <div class="form-line">
                                            <input type="date" name="start_d" id="start_d" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 form-float">
                                        <div class="form-line">
                                            <input type="date" name="end_d" id="end_d" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group col-md-4 form-float">
                                        <input type="submit" class="btn btn-primary btn-sm" name="excel" id="excel" value="Export To Excel" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- <a class="text" href="<?= base_url() . 'log/export/' ?>">Download</a> -->

                    </div>
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

<script src="<?= base_url() . 'assets/' ?>plugins/jquery/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {
        var table = $('#table').DataTable({
            "processing": false,
            "serverSide": true,
            "responsive": true,
            "destroy": true,
            "order": [
                [0, "desc"]
            ],
            "lengthMenu": [
                [15, 25, 50, -1],
                [15, 25, 50, "All"]
            ],
            "ajax": {
                url: "<?= site_url('log/pagination') ?>",
                type: "POST",
                data: {
                    start_d: function() {
                        return $('#start_d').val()
                    },
                    end_d: function() {
                        return $('#end_d').val()
                    }
                },
            },
            dom: "<'row'<'col-4'B><'col-4'l><'col-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'ip>>",
            buttons: ['excel', 'print']
        });

        $('#start_d, #end_d').on('keyup change', function() {
            $('#table').DataTable().ajax.reload();
        });
    });
</script>