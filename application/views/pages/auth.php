<?php include 'application/views/templates/include_css.php'; ?>

<body>
    <script src="<?= base_url() ?>template/src/assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                    </div>
                    <h1>Log in</h1>
                    <p class="mb-3">Log in to continue.</p>
                    <?= form_open() ?>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="text" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?> " placeholder="Username" name="username">
                        <div class="form-control-icon">
                            <i class="bi bi-person"></i>
                        </div>
                        <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="form-group position-relative has-icon-left mb-4">
                        <input type="password" class="form-control <?= form_error('password') ? 'is-invalid' : '' ?> " placeholder="Password" name="password" id="password">
                        <div class="form-control-icon">
                            <i class="bi bi-shield-lock"></i>
                        </div>
                        <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                        <div class="form-check form-check-sm mt-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                    class="form-check-input form-check-primary"
                                    name="customCheck" id="checkboxSize1" onclick="myFunction()">
                                <label class="form-check-label" for="checkboxSize1">Show password</label>
                            </div>
                        </div>
                    </div>


                    <button class="btn btn-primary btn-block shadow-lg mt-0" type="submit">Log in</button>
                    <?= form_close() ?>
                    <div class="text-center mt-3 text-sm">
                        <a class="font-bold" href="<?= base_url('forgot') ?>">Forgot password?</a>
                    </div>
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
<script>
    function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>

</html>