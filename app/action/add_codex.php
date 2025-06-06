<?php include('../includes/function.php');?>

<?php
    // On vérifie que user est co
    if (!isset($_SESSION['userid'])) {
        header('Location: login.php');
        exit();
    }


    if(isset($_POST['nom']) && isset($_POST['element_id'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $element_id = (int) $_POST['element_id'];
        $user_id = $_SESSION['userid'];
        $role = $_SESSION['role'] ?? 'eleve';

        // Vérifie si l'utilisateur maîtrise l'élément OU s'il est admin
        $request = $bdd->prepare("SELECT * FROM user_elements WHERE user_id = :user_id AND element_id = :element_id");
        $request->execute([
            'user_id' => $user_id,
            'element_id' => $element_id
        ]);

        $hasAccess = $request->rowCount() > 0 || $role === 'admin';

        if ($hasAccess) {
            $img = NULL;

            if (!empty($_FILES['image']) && $_FILES['image']['error'] === 0) {
                $imageName = htmlspecialchars($_FILES['image']['name']);
                $imageInfo = pathinfo($imageName);
                $imageExt = strtolower($imageInfo['extension']);
                $authorizedExt = ['png', 'jpeg', 'jpg', 'webp', 'bmp', 'svg'];

                if (in_array($imageExt, $authorizedExt)) {
                    $img = time() . rand(1,1000) . "." . $imageExt;
                    move_uploaded_file($_FILES['image']['tmp_name'], "../../assets/img/" . $img);
                }
            }

            $insert = $bdd->prepare("INSERT INTO sorts (nom, element_id, user_id, img)
                                    VALUES (:nom, :element_id, :user_id, :img)");
            $insert->execute([
                'nom' => $nom,
                'element_id' => $element_id,
                'user_id' => $user_id,
                'img' => $img
            ]);

            header('Location: /Academie/index.php?success=4');
            exit();
        } else {
            header('Location: /Academie/index.php?error=3');
        }
    }
?>

<?php 
    $pageTitle = "Ajouter un sort";
    include('../includes/head.php');
?>

<body>
    <?php include('../includes/nav.php') ?>
    <section>
        <form action="add_codex.php" method="POST" enctype="multipart/form-data">
        <label for="nom">Nom du sort :</label>
        <input type="text" name="nom" id="nom" required>

        <label for="element_id">Élément :</label>
        <select name="element_id" id="element_id" required>
            <option value="1">Feu</option>
            <option value="2">Eau</option>
            <option value="3">Air</option>
            <option value="4">Lumière</option>
        </select>

        <label for="image">Image du sort :</label>
        <input type="file" name="image" id="image">

        <button type="submit">Ajouter le sort au grimoire</button>
        </form>
    </section>
</body>
<?php include('../includes/footer.php')?>
