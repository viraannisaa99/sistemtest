<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<style>
.dompdf {
    border: 1px solid white;
    background: cadetblue;
    text-align: center;
}
</style>


<div class="container">
    <!-- <div class="dompdf">
        <div class="row">
            <div class="col-xs-1">.col-xs-1</div>
            <div class="col-xs-1">.col-xs-1</div>
            <div class="col-xs-1">.col-xs-1</div>
        </div>
        <div class="row">
            <div class="col-xs-2">.col-xs-2</div>
            <div class="col-xs-3">.col-xs-3</div>
            <div class="col-xs-7">.col-xs-7</div>
        </div>
        <div class="row">
            <div class="col-xs-4">.col-xs-4</div>
            <div class="col-xs-4">.col-xs-4</div>
            <div class="col-xs-4">.col-xs-4</div>
        </div>
        <div class="row">
            <div class="col-xs-5">.col-xs-5</div>
            <div class="col-xs-7">.col-xs-7</div>
        </div>
        <div class="row">
            <div class="col-xs-6">.col-xs-6</div>
            <div class="col-xs-6">.col-xs-6</div>
        </div>
        <div class="row">
            <div class="col-xs-12">.col-xs-12</div>
        </div>
    </div> -->
    <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column align-items-center text-center">
                    <img src="<?= $profile->picture ?>" alt="Admin" class="rounded-circle" width="150">
                </div>
            </div>
        </div>

        <h3 style="margin-top:10px">Data Diri</h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Nama</th>
                            <td><?= $profile->nama; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Email</th>
                            <td><?= $profile->email; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Username</th>
                            <td><?= $profile->username; ?></td>
                        </tr>
                        <tr>
                            <th scope="row">Status</th>
                            <td><?= ($profile->status == 1) ? 'Active' : 'Non Active'; ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <h3 style="margin-top:10px">Role & Permission</h3>
        <div class="row">
            <div class="col-xs-12">
                <table class="table table-striped">
                    <tbody>
                        <tr>
                            <th scope="row">Role</th>
                            <td><?php $role = $this->session->userdata('nama_role');
                                foreach ($role as $row) :
                                ?>
                                <ul>
                                    <li><?= $row; ?></li>
                                </ul>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">Permissions</th>
                            <td><?php $perminssion = $this->session->userdata('permissions');
                                foreach ($perminssion as $row) :
                                ?>
                                <ul>
                                    <li><?= $row; ?></li>
                                </ul>
                                <?php endforeach; ?>
                            </td>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


</html>