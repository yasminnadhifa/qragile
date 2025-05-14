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
                    <?php include 'application/views/templates/include_menu.php'; ?>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-right">
                            <li class="breadcrumb-item"><a href="<?= base_url('dev/projects/doc/') . $project['id_project'] ?>">Documentation</a></li>
                            <li class="breadcrumb-item active" aria-current="page">FR User story</li>
                        </ol>
                    </nav>
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                   FR User Story
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>User Story ID</th>
                                                <th>Functional Requirement</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($fus as $fus) : ?>
                                                <tr>
                                                    <td><?= $i; ?>.</td>
                                                    <td> <?= $fus['id_us_fr']; ?></td>
                                                    <td><?= $fus['name']; ?></td>
                                                    <td class="text-wrap" style="max-width: 400px;">
                                                        <?= !empty($fus['description']) ? $fus['description'] : 'No Description'; ?>
                                                    </td>

                                                    <td>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $fus['id_us_fr']; ?>" class="btn icon icon-left btn-secondary"><i data-feather="edit"></i> Edit</button>
                                                        <!-- modal -->
                                                        <div class="modal fade text-left" id="editModal<?= $fus['id_us_fr']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="false">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary">
                                                                        <h4 class="modal-title white" id="myModalLabel33">Edit Form</h4>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i data-feather="x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <?= form_open('dev/edit_fus/' . $project['id_project'] . '/' . $fus['id_us_fr'], 'id="editUserForm"') ?>

                                                                    <div class="modal-body">
                                                                        <label>Description</label>
                                                                        <div class="form-group">
                                                                            <textarea type="text" name="description" class="form-control"  rows="5" required placeholder="As a [description of user]&#10I want [functionality]&#10so that [benefit]"><?= $fus['description']; ?></textarea>
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
                                                        <!-- end modal -->
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

</html>