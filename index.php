<?php include('app/includes/function.php');?>
<?php include('app/includes/head.php');?>

<header>
    <?php include('app/includes/nav.php'); ?>
    <h1>L'Institut Gandalf le Fabuleux</h1>
</header>
<body>
    <?php if (isset($_SESSION['users'])): ?>
        <h3>Bonjour <?= htmlspecialchars($_SESSION['users']) ?> !</h3>
    <?php endif; ?>

    <h2>Bestiaire</h2>
    <section class="bestiaire">
        <div class="cards">
        <?php
            $request = $bdd->query('SELECT bestiaire.*, users.username, users.role
                                    FROM bestiaire
                                    JOIN users ON bestiaire.user_id = users.id');
            while($data = $request->fetch()) {
                echo '<div class="card">';
                if (!empty($data['img'])) {
                    echo '<img src="assets/img/' . htmlspecialchars($data['img']) . '" alt="' . htmlspecialchars($data['nom']) . '">';
                }
                echo '<h3>' . htmlspecialchars($data['nom']) . '</h3>';
                echo '<p><strong>Type :</strong> ' . htmlspecialchars($data['type']) . '</p>';
                echo '<p>' . htmlspecialchars($data['description']) . '</p>';
                echo '<p class="author">Ajouté par : ' . htmlspecialchars($data['username']) . '</p>';
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
