<?php include 'application/views/templates/include_css.php'; ?>
<body>
    <script src="<?= base_url() ?>template/src/assets/static/js/initTheme.js"></script>
    <div id="auth">
        <div class="row h-100">
            <div class="col-lg-5 col-12">
                <div id="auth-left">
                    <div class="auth-logo">
                    </div>
                    <h1 >Change Password</h1>
                    <p class="mb-3">Change your password to continue.</p>
                    <?= form_open('change_password') ?>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control <?= form_error('passwordnew') ? 'is-invalid' : '' ?> " placeholder="New password" name="passwordnew" id="passwordnew">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <?= form_error('passwordnew', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="form-group position-relative has-icon-left mb-4">
                            <input type="password" class="form-control <?= form_error('passwordconfirm') ? 'is-invalid' : '' ?> " placeholder="Confirm password" name="passwordconfirm" id="passwordconfirm">
                            <div class="form-control-icon">
                                <i class="bi bi-shield-lock"></i>
                            </div>
                            <?= form_error('passwordconfirm', '<small class="text-danger">', '</small>'); ?>
                            <div class="form-check form-check-sm mt-2">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox"
                                    class="form-check-input form-check-primary"
                                    name="customCheck" id="checkboxSize1" onclick="myFunction()">
                                <label class="form-check-label" for="checkboxSize1">Show password</label>
                            </div>
                        </div>
                        </div>
                        <button class="btn btn-primary btn-block shadow-lg mt-0" type="submit">Change</button>
                        <?= form_close() ?>
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
<script>
    function myFunction() {
        var newPassword = document.getElementById("passwordnew");
        var confirmPassword = document.getElementById("passwordconfirm");

        if (newPassword.type === "password") {
            newPassword.type = "text";
            confirmPassword.type = "text";
        } else {
            newPassword.type = "password";
            confirmPassword.type = "password";
        }
    }
</script>

</html>