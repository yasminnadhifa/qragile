<?php include 'application/views/templates/include_css.php'; ?>
<style>
.table-responsive {
    overflow: auto;
    max-height: 700px;
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
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">Add Validation Question</h4>
                                        <a href="<?= base_url('dev/projects/val/categories/'  . $project['id_project']); ?>">Manage Categories</a>
                                    </div>

                                    <div class="card-body">
                                        <?= form_open('dev/add_quest'); ?>
                                        <?= form_hidden('id_project', $project['id_project']); ?>
                                        <div class="row">
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Categories</label>
                                                    <fieldset class="form-group">
                                                        <select class="form-select <?= form_error('cat') ? 'is-invalid' : '' ?>" id="basicSelect" name="id_cat">
                                                            <option disabled selected>Choose Categories</option>
                                                            <?php foreach ($cat as $p) : ?>
                                                                <option value="<?= $p['id_cat']; ?>"><?= $p['name']; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <?= form_error('id_cat', '<small class="text-danger">', '</small>'); ?>
                                                    </fieldset>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-12">
                                                <div class="form-group">
                                                    <label for="first-name-column">Question</label>
                                                    <input type="text" id="first-name-column" class="form-control <?= form_error('quest') ? 'is-invalid' : '' ?>" name="quest">
                                                    <?= form_error('quest', '<small class="text-danger">', '</small>'); ?>
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
                                <h5 class="card-title">Checklist-Based Reading</h5>
                            </div>
                            <div class="card-body">
                                <?= form_open('dev/add_val'); ?>
                                <?= form_hidden('id_project', $project['id_project']); ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="sticky-header">
                                            <tr>
                                                <th rowspan="2" class="sticky-col sticky-header">Category</th>
                                                <th rowspan="2" class="sticky-col sticky-header">Question</th>
                                                <th colspan="<?= count($project_nfr); ?>" class="sticky-header">Quality Requirements</th>
                                                <th rowspan="2" class="sticky-header">Action</th>
                                            </tr>
                                            <tr>
                                                <?php foreach ($project_nfr as $nfr) : ?>
                                                    <th class="text-center" class=" sticky-header"><?php echo $nfr['name']; ?></th>
                                                <?php endforeach; ?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($questions)) : ?>
                                                <?php
                                                $current_category = '';
                                                $rowspan = 0;
                                                foreach ($questions as $index => $us) :
                                                    if ($current_category != $us['category_name']) {
                                                        $current_category = $us['category_name'];
                                                        $rowspan = 0;
                                                        foreach ($questions as $count_us) {
                                                            if ($count_us['category_name'] == $current_category) {
                                                                $rowspan++;
                                                            }
                                                        }
                                                        echo '<tr>';
                                                        echo '<td rowspan="' . $rowspan . '" class="font-weight-bold align-middle sticky-col">' . $current_category . '</td>';
                                                    }
                                                ?>
                                                    <td class="sticky-col"><?php echo $us['quest']; ?></td>
                                                    <?php foreach ($project_nfr as $nfr) : ?>
                                                        <td class="text-center">
                                                        <div class="d-flex justify-content-center">
                                                            <?php
                                                            $checked = '';
                                                            foreach ($vals as $val) {
                                                                if ($val['id_quest'] == $us['id_quest'] && $val['id_nfr'] == $nfr['id_nfr_list']) {
                                                                    $checked = 'checked';
                                                                    break;
                                                                }
                                                            }
                                                            ?>
                                                            <input type="checkbox" class="form-check-input" name="val[<?= $us['id_quest'] ?>][<?= $nfr['id_nfr_list'] ?>]" value="1" <?= $checked; ?>>
                                                            </div>
                                                        </td>
                                                    <?php endforeach; ?>
                                                    <td><button onclick="confirmDelete(event,<?= $us['id_quest']; ?>,<?= $project['id_project'] ?>)" class="btn icon btn-sm btn-danger"><i data-feather="delete"></i></button></td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="<?= count($project_nfr) + 3; ?>" class="text-center">No Questions found.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <?php if (!empty($questions)) : ?>
                                    <button type="submit" class="btn btn-primary">Save</button>
                                <?php endif; ?>
                                <?= form_close(); ?>
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
                const url = `<?= base_url('dev/delete_quest/'); ?>${encodeURIComponent(param1)}/${encodeURIComponent(project_id)}`;
                console.log(url); // Log the URL to check it
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