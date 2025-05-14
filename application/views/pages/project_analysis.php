<?php include 'application/views/templates/include_css.php'; ?>
<style>
.table-responsive {
    overflow: auto;
    max-height: 600px;
    /* Adjust the height as needed */
}

.sticky-header {
    position: sticky;
    top: 0;
    z-index: 1; /* Higher z-index to be on top of other elements */
    background-color: var(--bs-card-cap-bg) !important;

}

.sticky-col {
    position: sticky;
    left: 0;
    z-index: 0; /* Higher z-index to be on top of other elements */
    background-color: var(--bs-card-cap-bg) !important;
}

.sticky-header.sticky-col {
    z-index: 2; /* Ensure it is above other sticky headers and columns */
}
table {
    border-collapse: separate;
    border-spacing: 0; /* Ensure borders are not collapsed */
}

td, th {
 /* Ensure cells have a border */
    box-shadow: inset 0 -1px 0 0 #ddd !important;
}


.sticky-header.sticky-col {
    z-index: 3; /* Ensure highest z-index */
}

</style>

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
                    <section id="multiple-column-form">
                        <div class="row match-height">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4 class="card-title">Add
                                            Functional Requirement</h4>
                                    </div>
                                    <div class="card-body">
                                        <?= form_open('dev/add_fr'); ?>
                                        <?= form_hidden('id_project', $project['id_project']); ?>
                                        <div class="row">
                                            <div class="col-md-12 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Name</label>
                                                    <input type="text" id="first-name-column" class="form-control <?= form_error('name') ? 'is-invalid' : '' ?>" name="name">
                                                    <?= form_error('name', '<small class="text-danger">', '</small>'); ?>
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
                                <h5 class="card-title">Mapping FRxQR</h5>
                            </div>
                            <div class="card-body">
                                <?= form_open('dev/add_mapp_fr'); ?>
                                <?= form_hidden('id_project', $project['id_project']); ?>
                                <div class="table-responsive" >
                                    <table class="table table-bordered">
                                        <thead class="sticky-header">
                                            <tr>
                                                <th rowspan="2" class="sticky-col sticky-header">Functional Requirement</th>
                                                <th colspan="<?= count($project_nfr); ?>"  class=" sticky-header">Quality Requirements</th>
                                                <th rowspan="2" class="sticky-header">Action</th>
                                            </tr>
                                            <tr>
                                                <?php foreach ($project_nfr as $nfr) : ?>
                                                    <th class="sticky-header"><?php echo $nfr['name']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($frs)) : ?>
                                                <?php foreach ($frs as $fr) : ?>
                                                    <tr>
                                                        <td class="sticky-col"><?php echo $fr['name']; ?></td>
                                                        <?php foreach ($project_nfr as $nfr) : ?>
                                                            <td class="text-center">
                                                                <div class="d-flex justify-content-center">
                                                                    <?php
                                                                    $checked = '';
                                                                    foreach ($mappings as $mapping) {
                                                                        if ($mapping['id_fr'] == $fr['id_fr'] && $mapping['id_nfr'] == $nfr['id_nfr_list']) {
                                                                            $checked = 'checked';
                                                                            break;
                                                                        }
                                                                    }
                                                                    ?>
                                                                    <input type="checkbox" class="form-check-input" name="mapping[<?= $fr['id_fr'] ?>][<?= $nfr['id_nfr_list'] ?>]" value="1" <?= $checked; ?>>
                                                                </div>
                                                            </td>
                                                        <?php endforeach; ?>
                                                        <td >
                                                            <div class="btn-group mb-1">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-primary dropdown-toggle me-1" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <h6 class="dropdown-header">Action</h6>
                                                                        <button type="button" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?= $fr['id_fr']; ?>" data-name="<?= $fr['name']; ?>">
                                                                            Edit
                                                                        </button>
                                                                        <a onclick="confirmDelete(event, <?= $fr['id_fr']; ?>, <?= $project['id_project'] ?>)" class="dropdown-item">Delete</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="<?= count($project_nfr) + 2; ?>" class="text-center">No Functional Requirements found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>



                                <?php if (!empty($frs)) : ?>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                <?php endif; ?>
                                <?= form_close(); ?>
                            </div>

                    </section>
                    <!-- Edit Modal -->
                    <div class="modal fade text-left" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="false">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <h4 class="modal-title white" id="editModalLabel">Edit Form</h4>
                                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                        <i data-feather="x"></i>
                                    </button>
                                </div>
                                <?= form_open('', 'id="editUserForm"') ?>
                                <div class="modal-body">
                                    <label>Functional Requirement</label>
                                    <div class="form-group">
                                        <input type="text" id="edit-name" name="name" class="form-control" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                        <i class="bx bx-x d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Close</span>
                                    </button>
                                    <button type="submit" class="btn btn-primary ms-1">
                                        <i class="bx bx-check d-block d-sm-none"></i>
                                        <span class="d-none d-sm-block">Save Changes</span>
                                    </button>
                                </div>
                                <?= form_close(); ?>
                            </div>
                        </div>
                    </div>
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Mapping QRxQR</h5>
                            </div>
                            <div class="card-body">
                                <section>
                                    <div class="accordion accordion-flush" id="accordionFlushExample">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="flush-headingOne">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                    <h6 class="text-primary">Guidelines</h6>
                                                </button>
                                            </h2>
                                            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">(X) means there is conflict, (*) means not always in conflict (0) means no conflict and Blank means no information
                                                    <div class="d-flex justify-content-center">
                                                        <img src="<?= base_url() ?>template/assets/static/images/samples/mapping.jpg" alt="Sample Image" style="width: 500px; height: auto;" class="d-block img-fluid">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>


                                <?= form_open('dev/add_mapp_nfr'); ?>
                                <?= form_hidden('id_project', $project['id_project']); ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class="sticky-col sticky-header">Quality Requirements</th>
                                            </tr>
                                            <tr>
                                                <?php foreach ($nfr_list as $nfr) : ?>
                                                    <th class=" sticky-header"><?php echo $nfr['name']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($nfr_list)) : ?>
                                                <?php foreach ($nfr_list as $nfr1) : ?>
                                                    <tr>
                                                        <td class="sticky-col"><?php echo $nfr1['name']; ?></td>
                                                        <?php foreach ($nfr_list as $nfr2) : ?>
                                                            <td>
                                                                <fieldset class="form-group">
                                                                    <select class="form-select full-width-select" name="mapping[<?= $nfr1['id_nfr_list']; ?>][<?= $nfr2['id_nfr_list']; ?>]" id="basicSelect">
                                                                        <option value=""></option>
                                                                        <option value="0" <?= isset($mappings_nfr_formatted[$nfr1['id_nfr_list']][$nfr2['id_nfr_list']]) && $mappings_nfr_formatted[$nfr1['id_nfr_list']][$nfr2['id_nfr_list']] === '0' ? 'selected' : '' ?>>0</option>
                                                                        <option value="X" <?= isset($mappings_nfr_formatted[$nfr1['id_nfr_list']][$nfr2['id_nfr_list']]) && $mappings_nfr_formatted[$nfr1['id_nfr_list']][$nfr2['id_nfr_list']] === 'X' ? 'selected' : '' ?>>X</option>
                                                                        <option value="*" <?= isset($mappings_nfr_formatted[$nfr1['id_nfr_list']][$nfr2['id_nfr_list']]) && $mappings_nfr_formatted[$nfr1['id_nfr_list']][$nfr2['id_nfr_list']] === '*' ? 'selected' : '' ?>>*</option>
                                                                    </select>
                                                                </fieldset>
                                                            </td>
                                                        <?php endforeach; ?>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="<?= count($nfr_list) + 1; ?>" class="text-center">No Non-Functional Requirements found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (!empty($nfr_list)) : ?>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                <?php endif; ?>
                                <?= form_close(); ?>
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
    document.addEventListener('DOMContentLoaded', function() {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function(event) {
            var button = event.relatedTarget;
            var id = button.getAttribute('data-id');
            var name = button.getAttribute('data-name');
            var modalTitle = editModal.querySelector('.modal-title');
            var inputName = editModal.querySelector('#edit-name');
            var form = editModal.querySelector('form');

            modalTitle.textContent = 'Edit Functional Requirement';
            inputName.value = name;
            var baseURL = '<?= base_url("dev/edit_fr/"); ?>';
            form.action = baseURL + id + '/' + <?= $project['id_project']; ?>;
        });
    });


    function confirmDelete(event, param1, project_id) {
        event.preventDefault();
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, delete it"
        }).then((result) => {
            if (result.isConfirmed) {
                const url = `<?= base_url('dev/delete_fr/'); ?>${encodeURIComponent(param1)}/${encodeURIComponent(project_id)}`;
                window.location.href = url;
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