<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Register</h2>
<form method="post" action="/register">
    <?= csrf_field() ?>
    <div class="mb-3">
        <input class="form-control" type="text" name="username" placeholder="Username" required value="<?= old('username') ?>">
    </div>
    <div class="mb-3">
        <input class="form-control" type="email" name="email" placeholder="Email" required>
    </div>
    <div class="mb-3">
        <input class="form-control" type="password" name="password" placeholder="Password" required>
        <div class="form-text">Min 8 chars, uppercase, lowercase, number & symbol</div>
    </div>
    <button class="btn btn-primary">Register</button>
</form>
<?= $this->endSection() ?>
