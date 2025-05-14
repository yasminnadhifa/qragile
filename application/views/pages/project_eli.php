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
                    <section class="section">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">QR Elicitation</h5>
                                <a data-bs-toggle="modal" data-bs-target="#addModal" class="btn icon icon-left btn-secondary">Manage QR</a>
                                <!--login form Modal -->
                                <div class="modal fade text-left" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel33" aria-hidden="true" data-bs-backdrop="false" >
                                    <div class="modal-dialog modal-dialog-centered " role="document" >
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h4 class="modal-title white" id="myModalLabel33">Add Form </h4>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <i data-feather="x"></i>
                                                </button>
                                            </div>
                                            <?= form_open('dev/add_nfr_eli'); ?>
                                            <?= form_hidden('id_project', $project['id_project']); ?>
                                            <div class="modal-body" style="max-height: 500px;" >
                                                <label>Role</label>
                                                <div class="form-group">
                                                        <select class="choices form-select" id="basicSelect" name="nfr" required  >
                                                            <option disabled selected>Choose QR</option>
                                                            <?php foreach ($nfr as $p) : ?>
                                                                <option value="<?= $p['name']; ?>"><?= $p['name']; ?></option>
                                                            <?php endforeach; ?>

                                                        </select>
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
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <h6 class="text-primary mb-0">Project QRs:</h6>
                                        <div class="table-responsive">
                                            <table class="table" id="table1">
                                                <thead>
                                                    <tr>
                                                        <th>QR</th>
                                                        <th>Delete QR</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($project_nfr as $us) : ?>
                                                        <tr>
                                                            <td><?= $us['name'] ?></td>
                                                            <td> <button onclick="confirmDelete(event, <?= $us['id_nfr_list']; ?>, <?= $project['id_project'] ?>)" class="btn icon icon-left btn-danger"><i data-feather="delete"></i> Delete</button></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </section>
                    <section>
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Recommended QRs</h5>
                            </div>
                            <div class="card-body">

                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingOne">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                                <h6 class="text-primary mb-0">Based On Research</h6>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-12">

                                                        <div>
                                                            <?php

                                                            $seen_domain_values = [];
                                                            $seen_system_values = [];
                                                            $combined_iso_nfrs = [];
                                                            $domain_types = [];
                                                            $system_types = [];

                                                            foreach ($all_rec as $us) {
                                                                // Manage domain types
                                                                if (!in_array($us['domain'], $seen_domain_values)) {
                                                                    $domain_types[] = htmlspecialchars($us['domain']);
                                                                    $seen_domain_values[] = $us['domain'];
                                                                }

                                                                // Manage system types
                                                                if (!in_array($us['system'], $seen_system_values)) {
                                                                    $system_types[] = htmlspecialchars($us['system']);
                                                                    $seen_system_values[] = $us['system'];
                                                                }

                                                                // Combine ISO NFRs
                                                                if (is_array($us['iso_system'])) {
                                                                    $combined_iso_nfrs = array_merge($combined_iso_nfrs, $us['iso_system']);
                                                                } else {
                                                                    $combined_iso_nfrs[] = $us['iso_system'];
                                                                }

                                                                if (is_array($us['iso_domain'])) {
                                                                    $combined_iso_nfrs = array_merge($combined_iso_nfrs, $us['iso_domain']);
                                                                } else {
                                                                    $combined_iso_nfrs[] = $us['iso_domain'];
                                                                }
                                                            }


                                                            $combined_iso_nfrs = array_unique($combined_iso_nfrs);
                                                            sort($combined_iso_nfrs);

                                                            $domain_paragraph = !empty($domain_types) ? '<strong>Domain Types:</strong> ' . implode(', ', $domain_types) : '';
                                                            $system_paragraph = !empty($system_types) ? '<strong>System Types:</strong> ' . implode(', ', $system_types) : '';
                                                            $iso_paragraph = !empty($combined_iso_nfrs) ? '<strong>ISO 25010:</strong> ' . implode(', ', array_map('htmlspecialchars', $combined_iso_nfrs)) : '';


                                                            function clean_paragraph($paragraph)
                                                            {

                                                                return rtrim($paragraph, ', .');
                                                            }


                                                            $domain_paragraph = clean_paragraph($domain_paragraph);
                                                            $system_paragraph = clean_paragraph($system_paragraph);
                                                            $iso_paragraph = clean_paragraph($iso_paragraph);
                                                            ?>


                                                            <?php if ($domain_paragraph) : ?>
                                                                <p><?= $domain_paragraph; ?></p>
                                                            <?php endif; ?>


                                                            <?php if ($system_paragraph) : ?>
                                                                <p><?= $system_paragraph; ?></p>
                                                            <?php endif; ?>


                                                            <?php if ($iso_paragraph) : ?>
                                                                <p><?= $iso_paragraph; ?></p>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-headingTwo">
                                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                                                <h6 class="text-primary mb-0">Project History</h6>
                                            </button>
                                        </h2>
                                        <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body">
                                                <div class="table-responsive">
                                                    <table class="table" id="table2">
                                                        <thead>
                                                            <tr>
                                                                <th>QR</th>
                                                                <th>Count Used</th>
                                                                <th>Total Projects</th>
                                                                <th>Usage Percentage</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($nfr_usage as $nfr_id => $usage) : ?>
                                                                <?php if ($usage['used_count'] > 0) : ?>
                                                                    <tr>
                                                                        <td><?= $nfr_id ?></td>
                                                                        <td><?= $usage['used_count'] ?></td>
                                                                        <td><?= $usage['total_count'] ?></td>
                                                                        <td><?= number_format($usage['usage_percentage'], 2) ?>%</td>
                                                                    </tr>
                                                                <?php endif; ?>
                                                            <?php endforeach; ?>

                                                        </tbody>

                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                const url = `<?= base_url('dev/delete_eli/'); ?>${encodeURIComponent(param1)}/${encodeURIComponent(project_id)}`;
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