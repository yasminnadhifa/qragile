<?php include 'application/views/templates/include_css.php'; ?>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <?php include 'application/views/templates/include_sidebar.php'; ?>
        <div id="main" class='layout-navbar navbar-fixed'>
            <?php include 'application/views/templates/include_navbar.php'; ?>
            <div id="main-content">
                <div class="page-heading">
                    <div class="page-title">
                        <div class="row">
                            <div class="col-12 col-md-6 order-md-1 order-last">
                                <h3><?= $title ?></h3>
                            </div>
                        </div>
                    </div>
                    <section id="multiple-column-form">
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add User</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= form_open('console/add_user'); ?>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Name</label>
                                                    <input type="text" id="first-name-column" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" name="name">
                                                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="last-name-column">Username</label>
                                                    <input type="text" id="last-name-column" class="form-control <?= form_error('username') ? 'is-invalid' : '' ?>" name="username">
                                                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Email</label>
                                                    <input type="email" id="first-name-column" class="form-control <?= form_error('email') ? 'is-invalid' : '' ?>" name="email">
                                                    <?= form_error('email', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <div class="form-group">
                                                        <label for="basicInput">Role Access</label>
                                                        <fieldset class="form-group">
                                                            <select class="form-select <?= form_error('role') ? 'is-invalid' : '' ?>" id="basicSelect" name="role">
                                                                <option disabled selected>Choose Role</option>
                                                                <option value="Admin">Admin</option>
                                                                <option value="Developer">Developer</option>
                                                            </select>
                                                            <?= form_error('rol', '<small class="text-danger">', '</small>'); ?>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary me-1 mb-1">Submit</button>
                                            </div>
                                        </div>
                                        <?= form_close(); ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    Data Users
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name</th>
                                                <th>Username</th>
                                                <th>Email</th>
                                                <th>Role</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($user as $us) : ?>
                                                <tr>
                                                    <td><?= $i; ?>.</td>
                                                    <td><?= $us['name']; ?></td>
                                                    <td><?= $us['username']; ?></td>
                                                    <td><?= $us['email']; ?></td>
                                                    <td><?= $us['role']; ?></td>
                                                    <td>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $us['id_user']; ?>" class="btn icon icon-left btn-secondary"><i data-feather="edit"></i> Edit</button>
                                                        <!--login form Modal -->
                                                        <div class="modal fade text-left" id="editModal<?= $us['id_user']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="false">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary">
                                                                        <h4 class="modal-title white" id="myModalLabel33">Edit Form </h4>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i data-feather="x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <?= form_open('console/edit_user/' . $us['id_user'], ['id' => 'editUserForm', 'data-parsley-validate' => '']) ?>

                                                                    <div class="modal-body">
                                                                        <label>Email </label>
                                                                        <div class="form-group">
                                                                            <input name="email_update" class="form-control" value="<?= $us['email']; ?>" disabled>
                                                                        </div>
                                                                        <label>Username </label>
                                                                        <div class="form-group">
                                                                            <input name="username_update" class="form-control" value="<?= $us['username']; ?>" disabled>
                                                                        </div>
                                                                        <label>Name</label>
                                                                        <div class="form-group">
                                                                            <input type="text" name="name_update" class="form-control" value="<?= $us['name']; ?>" data-parsley-required="true" data-parsley-error-message="The Name field is required.">
                                                                        </div>
                                                                        <label>Role</label>
                                                                        <div class="form-group">
                                                                            <fieldset class="form-group">
                                                                                <select class="form-select" id="basicSelect" name="role_update">
                                                                                    <option disabled <?= empty($us['role']) ? 'selected' : '' ?>>Choose Role</option>
                                                                                    <option value="Admin" <?= $us['role'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                                                                                    <option value="Developer" <?= $us['role'] == 'Developer' ? 'selected' : '' ?>>Developer</option>
                                                                                </select>
                                                                            </fieldset>
                                                                        </div>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                                                            <i class="bx bx-x d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">Close</span>
                                                                        </button>
                                                                        <button type="submit" class="btn btn-primary ms-1" data-bs-dismiss="modal">
                                                                            <i class="bx bx-check d-block d-sm-none"></i>
                                                                            <span class="d-none d-sm-block">Save Changes</span>
                                                                        </button>
                                                                    </div>
                                                                    <?= form_close(); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <button onclick="confirmDelete(<?= $us['id_user']; ?>)" class="btn icon icon-left btn-danger"><i data-feather="delete"></i> Delete</button>
                                                    </td>
                                                </tr>
                                                <?php $i++; ?>
                                            <?php endforeach; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>

                    </section>
                </div>
            </div>

        </div>
    </div>


</body>
<?php include 'application/views/templates/include_js.php'; ?>
<?php if ($this->session->flashdata('message')) : ?>
    <script>
        Swal.fire({
            icon: "success",
            title: "Good job!",
            text: "<?= $this->session->flashdata('message') ?>",
        });
    </script>
<?php endif; ?>
<?php if ($this->session->flashdata('error')) : ?>
    <script>
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "<?= $this->session->flashdata('error') ?>",
        });
    </script>
<?php endif; ?>
<!-- JavaScript -->
<script>
    function confirmDelete(param1) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "<?= base_url('console/delete_user/'); ?>" + param1;
            } else {
                Swal.fire({
                    title: "Cancelled",
                    text: "Your data is safe :)",
                    icon: "info",
                });
            }
        });

    }
</script>

</html>