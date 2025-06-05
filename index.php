<?php include('app/includes/function.php');?>
<?php include('app/includes/head.php');?>

<header>
    <?php include('app/includes/nav.php'); ?>
    <h1>L'Institut Gandalf le Fabuleux</h1>
</header>
<body>
    <!-- ucfirst ça passe le 1er caractere en Maj -->
    <?php if (isset($_SESSION['users'])): ?>
        <h3>Bonjour <?= ucfirst(htmlspecialchars($_SESSION['users'])) ?> !</h3>  
    <?php endif; ?>

    <!-- AFFICHAGE D'UN MESSAGE DE CONFIRMATION D'OPERATION -->
    <?php
        if(isset($_GET['success'])){
            // DIFFERENT MESSAGE EN FONCTION DE L'OPERATION EFFECTUé
            switch($_GET['success']){
                case 1:
                    echo "<p class='success'> 🥳 Votre Créature à bien été ajoutée</p>";
                    break;
                case 2:
                    echo "<p class='success'> 🥳 Votre créature à bien été modifiée</p>";
                    break;
                case 3:
                    echo "<p class='success'> 🥳 Votre créature a bien été supprimée</p>";
                    break;
            }
        }

        if(isset($_GET['error'])){
            switch($_GET['error']){
                case 1:
                    echo "<p class='error'>🛑 Vous ne pouvez pas supprimer une créature qui ne vous appartient pas !</p>";
                    break;
                case 2:
                    echo "<p class='error'>🛑 Vous ne pouvez pas modifier une créature qui ne vous appartient pas !</p>";
                    break;
        }
}
    ?>
    <h2>Bestiaire</h2>
    <section class="bestiaire">
        <div class="cards">
        <?php
            $request = $bdd->query('SELECT bestiaire.*, users.username, users.role
                                    FROM bestiaire
                                    JOIN users ON bestiaire.user_id = users.id');
            while ($data = $request->fetch()) {
                echo '<div class="card">';
                
                if (!empty($data['img'])) {
                    echo '<img src="assets/img/' . htmlspecialchars($data['img']) . '" alt="Image ajoutée par la communauté : ' . htmlspecialchars($data['nom']) . '">';
                }

                echo '<h3>' . ucfirst(htmlspecialchars($data['nom'])) . '</h3>';
                echo '<p><strong>Type :</strong> ' . htmlspecialchars($data['type']) . '</p>';
                echo '<p>' . htmlspecialchars($data['description']) . '</p>';
                echo '<p class="author">Ajouté par : ' . ucfirst(htmlspecialchars($data['username'])) . '</p>';

                echo '<div class="btn-card">';
                echo '<a class="btn" href="/Academie/app/action/modify.php?id=' . $data['id'] . '">Modifier</a>';
                echo '<a class="btn" href="/Academie/app/action/delete.php?id=' . $data['id'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cette créature 🐦‍🔥 ?\')">Supprimer</a>';
                echo '</div>';
                echo '</div>';
            }
        ?>
        </div>
    </section>

    <section>
        <h2>Codex des sorts</h2>
    </section>

</body>
</html>
