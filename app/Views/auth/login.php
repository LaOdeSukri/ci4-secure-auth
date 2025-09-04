<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<h2>Login</h2>
<form method="post" action="/login">
    <?= csrf_field() ?>
    <div class="mb-3">
        <input class="form-control" type="email" name="email" placeholder="Email" required value="<?= old('email') ?>">
    </div>
    <div class="mb-3">
        <input class="form-control" type="password" name="password" placeholder="Password" required>
    </div>

    <div class="mb-3">
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <button class="g-recaptcha btn btn-primary" data-sitekey="<?= getenv('recaptcha.siteKey') ?>" data-callback="recaptchaVerified">Saya Manusia</button>
    </div>

    <?= view('auth/captcha_slider') ?>

    <div class="mb-3">
        <button class="btn btn-success" type="submit">Login</button>
        <a href="/register" class="btn btn-link">Register</a>
    </div>
</form>

<script src="/assets/captcha/slider.js"></script>
<script src="/assets/captcha/puzzle.js"></script>
<script>
function recaptchaVerified(token) {
    // Could call server to validate token but AuthController does server-side verify on POST
    // Reveal slider/puzzle area if hidden
    document.querySelectorAll('.slider').forEach(el => el.style.display='block');
}
</script>
<?= $this->endSection() ?>
