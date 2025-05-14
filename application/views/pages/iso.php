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
                                        <h4 class="card-title">Add ISO Type</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= form_open('dev/add_iso'); ?>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">ISO Type</label>
                                                    <input type="text" id="first-name-column" class="form-control-lg form-control <?= form_error('type') ? 'is-invalid' : '' ?>" name="type">
                                                    <?= form_error('type', '<small class="text-danger">', '</small>'); ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                <label for="first-name-column">Recommendation</label>

                                                    <select class="choices form-select multiple-remove " multiple="multiple" name="nfr[]">
                                                        <optgroup label="Choose">
                                                        <?php foreach ($nfr as $us) : ?>
                                                            <option value="<?= $us['name']; ?>"><?= $us['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </optgroup>
                                                       
                                                    </select>
                                                    <?= form_error('nfr[]', '<small class="text-danger">', '</small>'); ?>
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
                                    Data ISOs
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table" id="table1">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>ISO Type</th>
                                                <th>QRs</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $i = 1; ?>
                                            <?php foreach ($iso as $us) : ?>
                                                <tr>
                                                    <td><?= $i; ?>.</td>
                                                    <td><?= $us['type']; ?></td>
                                                    <td class="text-wrap" style=" max-width: 400px;"><?= $us['nfr']; ?></td>
                                                    <td>
                                                        <button type="button" data-bs-toggle="modal" data-bs-target="#editModal<?= $us['id_iso']; ?>" class="btn icon icon-left btn-secondary"><i data-feather="edit"></i> Edit</button>
                                                        <!--login form Modal -->
                                                        <div class="modal fade text-left" id="editModal<?= $us['id_iso']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="false">
                                                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-primary">
                                                                        <h4 class="modal-title white" id="myModalLabel33">Edit Form </h4>
                                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                                            <i data-feather="x"></i>
                                                                        </button>
                                                                    </div>
                                                                    <?= form_open('dev/edit_iso/' . $us['id_iso'], 'id="editUserForm"') ?>
                                                                    <div class="modal-body">
                                                                        <label>ISO Type </label>
                                                                        <div class="form-group">
                                                                            <input name="type_update" class="form-control" value="<?= $us['type']; ?>" required>
                                                                        </div>
                                                                        <label>Recommendation</label>
                                                                        <div class="form-group">
                                                                            <textarea type="text" name="nfr_update" class="form-control" required><?= $us['nfr']; ?></textarea>
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
                                                        <button onclick="confirmDelete(<?= $us['id_iso']; ?>)" class="btn icon icon-left btn-danger"><i data-feather="delete"></i> Delete</button>
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
                window.location.href = "<?= base_url('dev/delete_iso/'); ?>" + param1;
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