<ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= ($this->session->flashdata('current_page') == 'dev/projects/detail/' . $project['id_project']) ? 'active' : '' ?>" href="<?= base_url('dev/projects/detail/' . $project['id_project']) ?>">Information</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= ($this->session->flashdata('current_page') == 'dev/projects/elicitation/' . $project['id_project']) ? 'active' : '' ?>" href="<?= base_url('dev/projects/elicitation/') . $project['id_project'] ?>">Elicitation Document</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= ($this->session->flashdata('current_page') == 'dev/projects/analysis/' . $project['id_project']) ? 'active' : '' ?>" href="<?= base_url('dev/projects/analysis/') . $project['id_project'] ?>">
            Analysis Document</a>
    </li>

    <!-- <li class="nav-item" role="presentation">
        <a class="nav-link <?= ($this->session->flashdata('current_page') == 'dev/projects/doc/' . $project['id_project']) ? 'active' : '' ?>"   href="<?= base_url('dev/projects/doc/') . $project['id_project'] ?>">
            Documentation</a>
    </li> -->
    <li class="nav-item" role="presentation">
        <?php
        $current_page = $this->session->flashdata('current_page');
        $base_url = base_url('dev/projects/doc/');
        $project_id = $project['id_project'];
        $routes = [
            "dev/projects/doc/{$project_id}",
            "dev/projects/doc/fr_userstory/{$project_id}",
            "dev/projects/doc/nfr_decision/{$project_id}",
            "dev/projects/doc/nfr_userstory/{$project_id}"

        ];
        $is_active = in_array($current_page, $routes) ? 'active' : '';
        ?>
        <a class="nav-link <?= $is_active ?>" href="<?= $base_url . $project_id ?>">
            Documentation
        </a>
    </li>

    <li class="nav-item" role="presentation">
        <a class="nav-link <?= ($this->session->flashdata('current_page') == 'dev/projects/val/' . $project['id_project']) ? 'active' : '' ?>" href="<?= base_url('dev/projects/val/') . $project['id_project'] ?>">
            Validation</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link <?= ($this->session->flashdata('current_page') == 'dev/projects/confirm/' . $project['id_project']) ? 'active' : '' ?>" href="<?= base_url('dev/projects/confirm/') . $project['id_project'] ?>">
        Confirm QRs</a>
    </li>
</ul>