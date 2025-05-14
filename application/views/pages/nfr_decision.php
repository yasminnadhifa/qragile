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
                            <li class="breadcrumb-item active" aria-current="page">QR Decision</li>
                        </ol>
                    </nav>
                    
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">
                                    QR Decisions
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>QR</th>
                                                <th>Decision summary</th>
                                                <th>Affected component</th>
                                                <th>Rationale</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($dec as $us) : ?>
                                                <tr>
                                                    <td><?= $i; ?>.</td>
                                                    <td><?= $us['name']; ?></td>
                                                    <td><?= !empty($us['dec_summary']) ? $us['dec_summary'] : '-'; ?></td>
                                                    <td><?= !empty($us['affected']) ? $us['affected'] : '-'; ?></td>
                                                    <td class="text-wrap" style="max-width: 400px;"><?= !empty($us['rationale']) ? $us['rationale'] : '-'; ?></td>


                                                    <td>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $us['id_decision']; ?>" class="btn icon icon-left btn-secondary"><i data-feather="edit"></i> Edit</button>
                                                        <!--login form Modal -->
                                                        <div class="modal fade text-left" id="editModal<?= $us['id_decision']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="false">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary">
                                                                        <h4 class="modal-title white" id="myModalLabel33">Edit Form </h4>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i data-feather="x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <?= form_open('dev/edit_dec/' . $us['id_decision'] . '/' . $project['id_project'], 'id="editUserForm"') ?>

                                                                    <div class="modal-body">
                                                                        <label>Decision summary</label>
                                                                        <div class="form-group">
                                                                            <input name="dec_update" class="form-control" value="<?= $us['dec_summary']; ?>" required>
                                                                        </div>
                                                                        <label>Affected component</label>
                                                                        <div class="form-group">
                                                                            <input name="aff_update" class="form-control" value="<?= $us['affected']; ?>" required>
                                                                        </div>
                                                                        <label>Rationale</label>
                                                                        <div class="form-group">
                                                                            <textarea type="text" name="rat_update" class="form-control" required><?= $us['rationale']; ?></textarea>
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
                                                        <button onclick="confirmDelete(<?= $us['id_decision']; ?>,<?= $project['id_project'] ?>)" class="btn icon icon-left btn-danger"><i data-feather="delete"></i> Delete</button>
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
    function confirmDelete(param1, project_id) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `<?= base_url('dev/delete_dec/'); ?>${encodeURIComponent(param1)}/${encodeURIComponent(project_id)}`;
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