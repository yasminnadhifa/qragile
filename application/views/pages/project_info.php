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
                                <h5 class="card-title">Information</h5>
                            </div>
                            <div class="card-body">

                                <div class="row justify-content-start">
                                    <div class="row mb-2">
                                        <div class="col-4 col-md-3 fw-bold " style="max-width: 200px;">Project ID</div>
                                        <div class="col-auto w-auto d-none d-md-block">:</div>
                                        <div class="col-8 col-md-8"><?= $project['id_project'] ?></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 col-md-3 fw-bold " style="max-width: 200px;">Project Name</div>
                                        <div class="col-auto w-auto d-none d-md-block">:</div>
                                        <div class="col-8 col-md-8"><?= $project['name_project'] ?></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 col-md-3 fw-bold " style="max-width: 200px;">System Type</div>
                                        <div class="col-auto w-auto d-none d-md-block">:</div>
                                        <div class="col-8 col-md-8"><?= $project['system'] ?></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 col-md-3 fw-bold " style="max-width: 200px;">Domain Type</div>
                                        <div class="col-auto w-auto d-none d-md-block">:</div>
                                        <div class="col-8 col-md-8"><?= $project['domain'] ?></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-4 col-md-3 fw-bold " style="max-width:200px;">Project Created</div>
                                        <div class="col-auto w-auto d-none d-md-block">:</div>
                                        <div class="col-8 col-md-8"><?= $project['date_created'] ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <section class="section">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">Confirmed QRs</h5>
                            </div>
                            <div class="card-body">
                            <?php if (!empty($project_nfr)) : ?>
                                <ul>
                                        <?php foreach ($project_nfr as $us) : ?>
                                            <li><?= $us['name']; ?></li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else : ?>
                                        <span class="text-danger ">No confirmed QR</span>
                                    <?php endif; ?>
                                
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

</html>