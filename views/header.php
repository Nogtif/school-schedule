<header>
    <div class="container">
        <div class="logo">
            <a href="./"><img src="./assets/img/logo.png" alt="logo"><span>Université d'Artois</span></a>
        </div>
        <nav>
            <ul>
                <li <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'class="active"' : null ?>>
                    <a href="./"> Emploi du temps</a>
                </li>
                <li <?= (basename($_SERVER['PHP_SELF']) == 'gestion.php') ? 'class="active"' : null ?>>
                    <a href="./gestion"> Gestion des cours</a>
                </li>
                <li <?= (basename($_SERVER['PHP_SELF']) == 'admin.php') ? 'class="active"' : null ?>>
                    <a href="./admin">Administration</a>
                </li>
                
            </ul>
        </nav>
    </div>
</header>