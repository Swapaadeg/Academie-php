<?php include('../includes/function.php');?>

<body>
    <?php include('../includes/nav.php') ?>
    <?php include('../includes/head.php');?>
    <section>
        <form action="app/action/add.php" method="POST" class="creature-form">
        <label for="name">Nom de la créature :</label>
        <input type="text" id="name" name="name" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" rows="5" required></textarea>

        <label for="type">Type :</label>
        <select id="type" name="type" required>
            <option value="">-- Sélectionner un type --</option>
            <option value="aquatique">Aquatique</option>
            <option value="démoniaque">Démoniaque</option>
            <option value="mort-vivante">Mort-vivante</option>
            <option value="mi-bête">Mi-bête</option>
        </select>

        <label for="author">Ajoutée par :</label>
        <input type="text" id="author" name="author" required>

        <button type="submit">Ajouter la créature</button>
        </form>

    </section>
   
    
</body>