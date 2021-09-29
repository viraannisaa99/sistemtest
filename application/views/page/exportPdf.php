<h2>
    <center>Profile User</center>
    <br>

</h2>

<center>
    <img src="<?= $profile->picture; ?>" alt="Admin" class="rounded-circle" width="150">
</center>


<h3><b>Data Diri </b></h3>
<hr>
</hr>

<table width="100%" style="margin-left:auto;margin-right:auto;">
    <tr>
        <td>Nama User</td>
        <td>:</td>
        <td><?= $profile->nama; ?></td>
    </tr>

    <tr>
        <td>Email</td>
        <td>:</td>
        <td><?= $profile->email; ?></td>
    </tr>

    <tr>
        <td>Username</td>
        <td>:</td>
        <td><?= $profile->username; ?></td>
    </tr>

    <tr>
        <td>Status</td>
        <td>:</td>
        <td><?= ($profile->status == 1) ? 'Aktif' : 'Non Aktif'; ?></td>
    </tr>
</table>

<h3><b>Role & Permission </b></h3>
<hr>
</hr>

<table width="100%" border="1">
    <tr style="text-align:center">
        <td>Role</td>
        <td>Permission</td>
    </tr>
    <tr>
        <td style="text-align:center">
            <?= implode(", ", $this->session->userdata('nama_role')); ?>
        </td>
        <td>
            <?php $perm = $this->session->userdata('permissions');
                foreach($perm as $row):
            ?>
            <ul>
                <li><?= $row; ?></li>
            </ul>
            <?php endforeach; ?>
        </td>
    </tr>
</table>