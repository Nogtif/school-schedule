<header class="d-flex flex-row align-items-center justify-content-between">
    <div>
        <a class="logo" href="./">
            <i class="mdi mdi-cube-outline"></i>
            <span class="title-logo">ADE</span>
        </a>
    </div>

    <div class="navigation">
        <ul>
            <li><a href="./" <?= (basename($_SERVER['PHP_SELF']) == 'planning.php') ? 'class="active"' : '' ?>><i class="mdi mdi-calendar"></i> <span>Emploi du temps</span></a></li>

            <?php if($_SESSION['rang'] > 1) { ?>
                <li><a href="./cours.php" <?= (basename($_SERVER['PHP_SELF']) == 'cours.php') ? 'class="active"' : '' ?>><i class="mdi mdi-notebook-outline"></i> <span>Gerer mes cours</span></a></li>
            <?php } ?>

            <?php if($_SESSION['rang'] > 2) { ?>
                <li><a href="./admin.php" <?= (basename($_SERVER['PHP_SELF']) == 'admin.php') ? 'class="active"' : '' ?>><i class="mdi mdi-view-grid-outline"></i> <span>Administration</span></a></li>
            <?php } ?>
        </ul>

    </div>

    <div class="right-tools">
        <a href="./logout.php" class="btn btn-primary">Déconnexion</a>
    </div>
</header>