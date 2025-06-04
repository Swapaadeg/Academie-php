<nav>
    <ul>
        <li><a href="/Academie/index.php">Accueil</a></li>
        <?php 
        // if(isset($_SESSION['userid'])): 
        ?>
            <li><a href="/Academie/app/action/add_bestiaire.php">Ajouter des créatures au bestiaire</a></li>
            <li><a href="/Academie/app/action/add_codex.php">Ajouter des sorts au codex</a></li>
            <li><a href="/Academie/app/auth/logout.php">Se déconnecter</a></li>
        <?php 
        // else: 
            ?>
            <li><a href="/Academie/app/auth/login.php">Se connecter</a></li>
            <li><a href="/Academie/app/auth/subscribe.php">S'inscrire</a></li>
        <?php 
        // endif 
        ?>
    </ul>
</nav>