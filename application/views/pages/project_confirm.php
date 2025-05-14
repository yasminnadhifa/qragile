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
                            <div class="card-header">
                                <h5 class="card-title">Confirm QRs</h5>
                            </div>
                            <div class="card-body">
                                <?php if (empty($project_nfr)) : ?>
                                    <p class="text-danger">Analysis phase not completed yet</p>
                                <?php else : ?>
                                    <?php echo form_open('dev/confirm', array('id' => 'nfr-form')); ?>
                                    <?= form_hidden('id_project', $project['id_project']); ?>
                                    <div class="row">
                                        <?php
                                        $max_per_column = 10;
                                        $total_nfr = count($project_nfr);
                                        $columns = ceil($total_nfr / $max_per_column);

                                        for ($col = 0; $col < $columns; $col++) :
                                        ?>
                                            <div class="col-12 col-md-6 col-lg-4 mb-lg-4 mb-sm-0">
                                                <?php
                                                $start = $col * $max_per_column;
                                                $end = min($start + $max_per_column, $total_nfr);
                                                for ($i = $start; $i < $end; $i++) :
                                                    $nfr = $project_nfr[$i];
                                                ?>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" name="nfrs[]" value="<?php echo htmlspecialchars($nfr['name']); ?>" <?php if ($nfr['status'] == 2) echo 'checked'; ?>>
                                                        <label class="form-check-label">
                                                            <?= htmlspecialchars($nfr['name']); ?>
                                                        </label>
                                                    </div>
                                                <?php endfor; ?>
                                            </div>
                                        <?php endfor; ?>
                                    </div>
                                    <div class="text-end mt-3">
                                        <button type="button" class="btn btn-primary" id="submit-button">Confirm QRs</button>
                                    </div>
                                    <?= form_close(); ?>
                                <?php endif; ?>
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
    document.getElementById('submit-button').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the form from submitting immediately

        Swal.fire({
            title: "Are you sure you want to confirm these QRs?",
            text: "Confirming will apply changes to the project. Do you want to proceed?",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Confirm",
            denyButtonText: "Discard"
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit the form if confirmed
                document.getElementById('nfr-form').submit();
            } else if (result.isDenied) {
                Swal.fire("Changes are not confirmed", "No updates were made to the project.", "info");
            }
        });
    });
</script>

</html>