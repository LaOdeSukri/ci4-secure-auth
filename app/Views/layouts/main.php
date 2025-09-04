<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title><?= esc($title ?? 'CI4 Secure Auth') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/captcha/style.css" rel="stylesheet">
</head>
<body>
<div class="container py-4">
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>
    <?= $content ?? '' ?>
</div>
</body>
</html>
