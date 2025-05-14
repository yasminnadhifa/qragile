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
                    <div class="row">
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title">FR User story</h4>
                                    </div>
                                    <img class="img-fluid w-100" src="<?= base_url() ?>template/assets/compiled/content/userstory.png" alt="Card image cap">
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <a class="btn btn-light-primary" href="<?= base_url('dev/projects/doc/fr_userstory/') . $project['id_project'] ?>">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title">QR User story</h4>
                                    </div>
                                    <img class="img-fluid w-100" src="<?= base_url() ?>template/assets/compiled/content/userstory.png" alt="Card image cap">
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <a class="btn btn-light-primary" href="<?= base_url('dev/projects/doc/nfr_userstory/') . $project['id_project'] ?>">Read More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-md-6 col-sm-12">
                            <div class="card">
                                <div class="card-content">
                                    <div class="card-body">
                                        <h4 class="card-title">QR Decision</h4>
                                    </div>
                                    <img class="img-fluid w-100" src="<?= base_url() ?>template/assets/compiled/content/userstory.png" alt="Card image cap">
                                </div>
                                <div class="card-footer d-flex justify-content-between">
                                    <a class="btn btn-light-primary" href="<?= base_url('dev/projects/doc/nfr_decision/') . $project['id_project'] ?>">Read More</a>
                                </div>
                            </div>
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