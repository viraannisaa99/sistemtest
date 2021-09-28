<h2>
    <center>Profile User</center>

    <img src="<?= $profile->picture ?>" alt="Admin" class="rounded-circle" width="150">
</h2>

<table width="100%">
    <tr>
        <td>Nama</td>
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
        <td>Role</td>
        <td>:</td>
        <td><?= implode(", ", $this->session->userdata('nama_role')); ?></td>
    </tr>


</table>