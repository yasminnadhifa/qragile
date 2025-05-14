<?php include 'application/views/templates/include_css.php'; ?>
<body>
    <script src="<?= base_url() ?>template/src/assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                    </div>
                    <h1 >Forgot your password?</h1>
                    <p class="mb-3">Enter your email address to receive a password reset link.</p>
                    <?= form_open() ?>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="email" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?> " placeholder="Email" name="email">
                            <div class="form-control-icon">
                                <i class="bi bi-person"></i>
                            </div>
                            <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                        </div>

                        <button class="btn btn-primary btn-block shadow-lg mt-2" type="submit">check</button>
                        <?= form_close() ?>
                    <!-- <div class="text-center mt-3 text-sm">
                        <a class="font-bold" href="auth-forgot-password.html">Forgot password?</a>
                    </div> -->
                </div>
            </div>
            <div class="col-lg-7 d-none d-lg-block">
                <div id="auth-right">
                </div>
            </div>
        </div>

    </div>
</body>
<?php if ($this->session->flashdata('message')) : ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "<?= $this->session->flashdata('message') ?>",
        });
    </script>
<?php endif; ?>
<?php if ($this->session->flashdata('success')) : ?>
    <script>
        Swal.fire({
            icon: "success",
            title: "Good job!",
            text: "<?= $this->session->flashdata('success') ?>",
        });
    </script>
<?php endif; ?>
</html>