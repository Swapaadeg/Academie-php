<?php 
$pageTitle = "Académie des Arcanes";
include('app/includes/function.php');?>
<?php include('app/includes/head.php');?>

<?php include('app/includes/nav.php'); ?>
<header>
    <h1>Grimoire des Arcanes</h1>
</header>
<body>
    <!-- ucfirst ça passe le 1er caractere en Maj -->
    <?php if (isset($_SESSION['users'])): ?>
        <h3>Bonjour <?= ucfirst(htmlspecialchars($_SESSION['users'])) ?> !</h3>  
    <?php endif; ?>

    <!-- AFFICHAGE D'UN MESSAGE DE CONFIRMATION D'OPERATION -->
    <?php
        if(isset($_GET['success'])){
            // MESSAGE SUCCESS
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
                case 4: 
                    echo "<p class='success'> 🥳 Félicitations invocateur! Votre sort a bien été ajouté</p>";
                    break;
                case 5: 
                    echo "<p class='success'> 🥳 Félicitations invocateur! Votre sort a bien été supprimé</p>";
                    break;
                case 6: 
                    echo "<p class='success'> 🥳 Félicitations invocateur! Votre sort a bien été modifié</p>";
                    break;
            }
        }
            // MESSAGE ERROR
        if(isset($_GET['error'])){
            switch($_GET['error']){
                case 1:
                    echo "<p class='error'>🛑 Vous ne pouvez pas supprimer une créature qui ne vous appartient pas !</p>";
                    break;
                case 2:
                    echo "<p class='error'>🛑 Vous ne pouvez pas modifier une créature qui ne vous appartient pas !</p>";
                    break;
                case 3:
                    echo "<p class='error'>⛔ Tu ne maîtrises pas cet élément. Tu ne peux pas inscrire ce sort dans le grimoire.</p>";
                    break;
                case 4:
                    echo "<p class='error'>⛔ Tu ne maîtrises pas cet élément. Tu ne peux pas supprimer ce sort du grimoire.</p>";
                    break;
                case 5:
                    echo "<p class='error'>⛔ Tu ne maîtrises pas cet élément. Tu ne peux pas modifier ce sort du grimoire.</p>";
                    break;
        }
}
    ?>

    <!-- BESTIAIRE -->
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
                        echo '<div class="image-container">';
                        echo '<img src="assets/img/' . htmlspecialchars($data['img']) . '" alt="Image ajoutée par la communauté : ' . htmlspecialchars($data['nom']) . '">';
                        echo '</div>';
                    }

                    echo '<h3>' . ucfirst(($data['nom'])) . '</h3>';
                    echo '<p><strong>Type :</strong> ' . ($data['type']) . '</p>';
                    echo '<p>' . ($data['description']) . '</p>';
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


    <!-- CODEX -->
    <h2>Codex des sorts</h2>
    <section>
        <div class="elements">
            <?php
            $request = $bdd->query('SELECT sorts.*, elements.nom AS element_nom, users.username, users.role
                                    FROM sorts
                                    JOIN elements ON sorts.element_id = elements.id
                                    JOIN users ON sorts.user_id = users.id');
            while ($data = $request->fetch()) {
                $elementClass = strtolower($data['element_nom']);
                echo '<div class="element ' . $elementClass . '">';

                echo '<div class="codex-title"><h3>' . ucfirst($data['nom']) . '</h3></div>';

                echo '<div class="element-body">';
                    if (!empty($data['img'])) {
                        echo '<img src="assets/img/' . htmlspecialchars($data['img']) . '" alt="Image du sort ' . htmlspecialchars($data['nom']) . '">';
                    }

                    echo '<div class="element-info">';
                        echo '<p><strong>Élément :</strong> ' . ucfirst(htmlspecialchars($data['element_nom'])) . '</p>';
                        echo '<p class="author"><strong>Ajouté par :</strong> ' . ucfirst(htmlspecialchars($data['username'])) . '</p>';

                        // Affichage des spécialistes
                        $stmt = $bdd->prepare('SELECT username 
                                            FROM users
                                            JOIN user_elements 
                                            ON users.id = user_elements.user_id
                                            WHERE user_elements.element_id = :element_id');
                        $stmt->execute(['element_id' => $data['element_id']]);
                        $specialistes = $stmt->fetchAll(PDO::FETCH_COLUMN);

                        if (!empty($specialistes)) {
                            echo '<p><strong>Spécialiste(s) :</strong> ' . implode(' / ', array_map('ucfirst', $specialistes)) . '</p>';
                        }
                    echo '</div>'; // .element-info
                echo '</div>'; // .element-body

                // Boutons
                echo '<div class="btn-card-codex">';
                    echo '<a class="btn" href="/Academie/app/action/modify_codex.php?id=' . $data['id'] . '">Modifier</a>';
                    echo '<a class="btn" href="/Academie/app/action/delete_codex.php?id=' . $data['id'] . '" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer ce sort 🪄 ?\')">Supprimer</a>';
                echo '</div>';

                echo '</div>'; // .element
            }
            ?>
        </div>
    </section>
</body>
<?php include('app/includes/footer.php')?>
</html>
