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
                <h3>Dashboard</h3>
                <p class="text-subtitle text-muted">All systems are running smoothly!</p>
              </div>
            </div>
          </div>
          <?php if ($this->session->userdata('role') == 'Admin') : ?>
            <section class="row">
              <div class="col-12 col-lg-9 col-sm-12">
                <div class="row">
                  <div class="col-6 col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                      <div class="card-body px-4 py-4-5">
                        <div class="row">
                          <div class="col-md-4 col-lg-5 d-flex justify-content-start ">
                            <div class="stats-icon blue mb-2">
                              <i class="iconly-boldProfile"></i>
                            </div>
                          </div>
                          <div class="col-md-8 col-lg-7">
                            <h6 class="text-muted font-semibold">Total Users</h6>
                            <h6 class="font-extrabold mb-0"><?= $total_user ?></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card">
                      <div class="card-header">
                        <h4>Activity History</h4>
                      </div>
                      <div class="card-content pb-4 px-4" style="max-height: 200px; overflow-y: auto;">
                        <?php foreach ($log as $us) : ?>
                          <div class="d-flex py-3 mb-2 align-items-center">
                            <!-- Content on the left -->
                            <div class="flex-grow-1 me-3">
                              <h6 class="mb-1 text-primary"><?= $us['action_type'] ?></h6>
                              <p class="text-muted mb-0"><?= $us['action_desc'] ?></p>
                            </div>
                            <!-- Timestamp on the far right -->
                            <div>
                              <span class="badge bg-light-info"><?= $us['timestamp'] ?></span>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          <?php endif; ?>
          <?php if ($this->session->userdata('role') == 'Developer') : ?>
            <section class="row">
              <div class="col-12 col-lg-9 col-sm-12">
                <div class="row">
                  <div class="col-6 col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                      <div class="card-body px-4 py-4-5">
                        <div class="row">
                          <div class="col-md-4 col-lg-3 d-flex justify-content-start ">
                            <div class="stats-icon blue mb-2">
                              <i class="iconly-boldBookmark"></i>
                            </div>
                          </div>
                          <div class="col-md-8 col-lg-9">
                            <h6 class="text-muted font-semibold">Total Projects</h6>
                            <h6 class="font-extrabold mb-0"><?= $total_project ?></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                      <div class="card-body px-4 py-4-5">
                        <div class="row">
                          <div class="col-md-4 col-lg-3 d-flex justify-content-start ">
                            <div class="stats-icon green mb-2">
                              <i class="iconly-boldBookmark"></i>
                            </div>
                          </div>
                          <div class="col-md-8 col-lg-9">
                            <h6 class="text-muted font-semibold">Confirmed QR</h6>
                            <h6 class="font-extrabold mb-0"><?= $total_val ?></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6 col-lg-4 col-md-6 col-sm-12">
                    <div class="card">
                      <div class="card-body px-4 py-4-5">
                        <div class="row">
                          <div class="col-md-4 col-lg-3 d-flex justify-content-start ">
                            <div class="stats-icon red mb-2">
                              <i class="iconly-boldBookmark"></i>
                            </div>
                          </div>
                          <div class="col-md-8 col-lg-9">
                            <h6 class="text-muted font-semibold">Unconfirmed QR</h6>
                            <h6 class="font-extrabold mb-0"><?= $total_unval ?></h6>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card">
                      <div class="card-header">
                        <h4>Activity History</h4>
                      </div>
                      <div class="card-content pb-4 px-4" style="max-height: 200px; overflow-y: auto;">
                        <?php foreach ($log as $us) : ?>
                          <div class="d-flex py-3 mb-2 align-items-center">
                            <!-- Content on the left -->
                            <div class="flex-grow-1 me-3">
                              <h6 class="mb-1 text-primary"><?= $us['action_type'] ?></h6>
                              <p class="text-muted mb-0"><?= $us['action_desc'] ?></p>
                            </div>
                            <!-- Timestamp on the far right -->
                            <div>
                              <span class="badge bg-light-info"><?= $us['timestamp'] ?></span>
                            </div>
                          </div>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</body>
<?php include 'application/views/templates/include_js.php'; ?>

</html>