<h2>Google Account Details</h2>
<div class="ac-data">
    <!-- Display Google profile information -->

    <p><b>Email:</b> <?= $userData['email']; ?></p>

    <p><b>Logged in with:</b> Google</p>
    <p>Logout from <a href="<?= base_url() . 'login/logout'; ?>">Google</a></p>
</div>