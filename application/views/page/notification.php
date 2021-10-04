<div class="content">
    <div class="clearfix">
        <div class="col-md-12">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <button type="button" class="btn bg-blue col-white waves-effect" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <span>Export By Date</span>
                </button>
                <div class="collapse" id="collapseExample">
                    <div class="card">
                        <h4 class="card-header card-header-primary">Masukkan Tanggal</h4>
                        <div class="card-body d-flex flex-column">
                            <form action="<?php echo base_url('notification/exportRange'); ?>" method="POST" targets="_blank">
                                <div class="col-md-12">
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
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Daftar Notifikasi User</h4>
                    <p class="card-category"> List Daftar Notifikasi User</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="form-group col-md-6">
                            <label>Filter Tanggal</label>
                            <!-- <form action="<?php echo base_url('notif/export'); ?>" method="POST" targets="_blank"> -->
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
                                    <!-- <input type="submit" class="btn btn-primary btn-sm" name="excel" id="excel" value="Export To Excel" class="form-control"> -->
                                    <button type="button" id="export" onclick="qget()">Export Data</button>
                                </div>
                            </div>
                            <!-- </form> -->
                        </div>
                    </div>
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
                url: "<?= site_url('notification/pagination') ?>",
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
            "columnDefs": [{
                "targets": [0],
                "className": "center",
            }],

            dom: "<'row'<'col-4'B><'col-4'l><'col-4'f>><'row'<'col-sm-12'tr>><'row'<'col-sm-12'ip>>",
            buttons: ['excel', 'print']
        });

        $('#start_d, #end_d').on('keyup change', function() {
            $('#table').DataTable().ajax.reload();
        });
    });


    $('#export').on('click', function() {
        $.ajax({
            url: "<?= base_url('notification/export') ?>",
            type: "POST",
            data: {
                start_d: function() {
                    return $('#start_d').val()
                },
                end_d: function() {
                    return $('#end_d').val()
                }
            },
            cache: false,
            success: function(data) {
                window.open('<?= base_url('notification/export') ?>');
            }
        });
    });

    // function qget() {
    //     var data = new URLSearchParams();
    //     data.append("start_d", $('#start_d').val());
    //     data.append("end_d", $('#end_d').val());

    //     var url = "<?= base_url('notification/export') ?>?" + data.toString();
    //     location.href = url;
    // }
</script>