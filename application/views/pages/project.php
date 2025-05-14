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
                                        <h4 class="card-title">Add Project</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= form_open('dev/add_project'); ?>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Name Project</label>
                                                    <input type="text" id="first-name-column" class=" form-control <?= form_error('name_project') ? 'is-invalid' : '' ?>" name="name_project">
                                                    <?= form_error('name_project', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="basicInput">System Type</label>
                                                    <fieldset class="form-group">
                                                        <select class="form-select <?= form_error('system') ? 'is-invalid' : '' ?>" id="basicSelect" name="system">
                                                            <option disabled selected>Choose System Type</option>
                                                            <?php foreach ($system as $p) : ?>
                                                                <option value="<?= $p['id_system']; ?>"><?= $p['type']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('system', '<small class="text-danger">', '</small>'); ?>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="basicInput">Domain Type</label>
                                                    <fieldset class="form-group">
                                                        <select class="form-select <?= form_error('domain') ? 'is-invalid' : '' ?>" id="basicSelect" name="domain">
                                                            <option disabled selected>Choose Domain Type</option>
                                                            <?php foreach ($domain as $p) : ?>
                                                                <option value="<?= $p['id_domain']; ?>"><?= $p['type']; ?></option>
                                                            <?php endforeach; ?>

                                                        </select>
                                                        <?= form_error('domain', '<small class="text-danger">', '</small>'); ?>
                                                    </fieldset>
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
                                    Data Projects
                                </h5>

                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Project Name</th>
                                                <th>Domain Type</th>
                                                <th>System Type</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($project as $us) : ?>
                                                <?php
                                            $status = $us['validate'];
                                            if ($status == 1) {
                                                $class = 'badge bg-light-success';
                                                $text = 'Confirmed QRs';
                                            } else if ($status == 0) {
                                                $class = 'badge bg-light-danger';
                                                $text = 'Unconfirmed QRs';
                                            } else {
                                                $class = 'badge bg-light-secondary'; 
                                                $text = 'Unknown Status'; 
                                            }
                                            ?>
                                                <tr>
                                                    <td><?= $i; ?>.</td>
                                                    <td><?= $us['name_project']; ?></td>
                                                    <td><?= $us['domain']; ?></td>
                                                    <td><?= $us['system']; ?></td>
                                                    <td><span class="<?=$class?>"><?=$text?></span></td>
                                                    <td>
                                                    <a class="btn icon icon-left btn-info" href="<?= base_url('dev/projects/detail/') . $us['id_project']; ?>"><i data-feather="info"></i> Detail</a>
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $us['id_project']; ?>" class="btn icon icon-left btn-secondary"><i data-feather="edit"></i> Edit</button>
                                                        <!--login form Modal -->
                                                        <div class="modal fade text-left" id="editModal<?= $us['id_project']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="false">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary">
                                                                        <h4 class="modal-title white" id="myModalLabel33">Edit Form </h4>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i data-feather="x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <?= form_open('dev/edit_project/' . $us['id_project'], 'id="editUserForm"') ?>
                                                                    <div class="modal-body">
                                                                        <label>Project Name </label>
                                                                        <div class="form-group">
                                                                            <input name="name_update" class="form-control" value="<?= $us['name_project']; ?>" required>
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
                                                       
                                                        <button onclick="confirmDelete(<?= $us['id_project']; ?>)" class="btn icon icon-left btn-danger"><i data-feather="delete"></i> Delete</button>

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
                window.location.href = "<?= base_url('dev/delete_project/'); ?>" + param1;
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