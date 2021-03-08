<div class="sidebar d-flex flex-column align-items-center justify-content-between">
    <div class="cont-bar">
        <a class="logo" href="./">
            <i class="mdi mdi-cube-outline"></i>
            <span class="title-logo">Université d'Artois</span>
        </a>
    </div>

    <div class="sidebar-menu">
        <ul>
            <li>
                <a href="./" <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : null ?>> <i class="mdi mdi-calendar"></i> Emploi du temps</a>
            </li>
            <li>
                <a href="./gestion" <?= (basename($_SERVER['PHP_SELF']) == 'gestion.php') ? 'class="active"' : null ?>><i class="mdi mdi-notebook-outline"></i> Gestion des cours</a>
            </li>
            <li>
                <a href="" <?= (basename($_SERVER['PHP_SELF']) == 'admin.php') ? 'class="active"' : null ?>><i class="mdi mdi-view-grid-outline"></i> Administration</a>
            </li>
        </ul>
    </div>
    <div class="cont-bar">
        <a href="./logout" class="btn btn-primary">Déconnexion</a>
    </div>
</div>