<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - MSS </title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= base_url('assets/favicon') ?>/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= base_url('assets/favicon') ?>/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url('assets/favicon') ?>/favicon-16x16.png">
    <link rel="manifest" href="<?= base_url('assets/favicon') ?> ?>/site.webmanifest">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets/css/bootstrap.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets/css/app.css">
    <link rel="stylesheet" href="<?= base_url('/') ?>assets/css/pages/auth.css">
</head>

<body>
    <div id="auth">

        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth">
                        <a href="index.html"><img src="<?= base_url('/') ?>assets/ardi.png" alt="Logo"></a>
                    </div>
                    <?php if ($this->session->flashdata('notif')) { ?>
                        <div class="alert alert-info">
                            <strong>
                                <?= $this->session->userdata('notif') ?>
                            </strong>
                        </div>
                    <?php } ?>
                    <p class="auth-subtitle mb-5">Aplikasi Surat Digital <?= pengaturan()->nama_satker ?> </p>

                    <form action="<?= base_url('auth/login') ?>" method="POST">
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input required type="text" name="username" class="form-control form-control-xl" placeholder="Username">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input required type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                        </div>

                        <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
                    </form>
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                    <img style="margin:300px" width="700" src="<?= base_url('assets/images/login.png') ?>" alt="Gambar Login">
                </div>
            </div>
        </div>
    </div>

    <script>
        const kuya = () => {
            console.log('kuya')
        }
    </script>
    <script src="<?= base_url() ?>assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>