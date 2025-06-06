<?php
    include('../includes/function.php');

    if (!isset($_GET['id'])) {
        header("location:/Academie/index.php");
        exit();
    }
// 1. Récupération de l'id
    if (!isset($_GET['id'])) {
        header("location:/Academie/index.php");
        exit();
    }

    $id = htmlspecialchars($_GET['id']);
    $userId = $_SESSION['userid'];
    $userRole = $_SESSION['role'] ?? 'eleve';

    // 2. Récupérer le sort
    $request = $bdd->prepare("SELECT * 
                            FROM sorts 
                            WHERE id = :id"
                            );
    $request->execute(['id' => $id]);
    $sort = $request->fetch();

    if (!$sort) {
        header("location:/Academie/index.php?error=5");
        exit();
    }

// 3. Vérification de l'accès
    $elementId = $sort['element_id'];

    $hasPermission = false;

    if ($userRole === 'admin') {
        $hasPermission = true;
    }else{
        $check = $bdd->prepare("SELECT * 
                                FROM user_elements 
                                WHERE user_id = :user_id 
                                AND element_id = :element_id"
                                );
        $check->execute(['user_id' => $userId, 'element_id' => $elementId]);
        $hasPermission = $check->rowCount() > 0;
    }

    if (!$hasPermission) {
        header("location:/Academie/index.php?error=5");
        exit();
    }

    // 4. Traitement du formulaire
    if (isset($_POST['nom']) && isset($_POST['element_id'])) {
        $nom = htmlspecialchars($_POST['nom']);
        $element_id = (int) $_POST['element_id'];
        $img = $sort['img'];

        if (!empty($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $imageInfo = pathinfo($_FILES['image']['name']);
            $ext = strtolower($imageInfo['extension']);
            $allowed = ['jpg','jpeg','png','webp','bmp','svg'];
            if (in_array($ext, $allowed)) {
                $img = time() . rand(1, 9999) . '.' . $ext;
                move_uploaded_file($_FILES['image']['tmp_name'], '../../assets/img/' . $img);
                if (!empty($sort['img'])) {
                    unlink('../../assets/img/' . $sort['img']);
                }
            }
        }

        $update = $bdd->prepare("UPDATE sorts 
                                SET nom = :nom, element_id = :element_id, img = :img 
                                WHERE id = :id");
        $update->execute([
            'nom' => $nom,
            'element_id' => $element_id,
            'img' => $img,
            'id' => $id
        ]);

        header("location:/Academie/index.php?success=6");
        exit();
    }
?>

<?php include('../includes/head.php'); ?>

<body>

    <?php include('../includes/nav.php'); ?>

    <h2>Modifier un sort</h2>

    <form action="modify_codex.php?id=<?= $sort['id'] ?>" method="POST" enctype="multipart/form-data">
        <label for="nom">Nom du sort :</label>
        <input type="text" name="nom" id="nom" value="<?= htmlspecialchars($sort['nom']) ?>" required>

        <label for="element_id">Élément :</label>
        <select name="element_id" id="element_id">
            <option value="1" <?= $sort['element_id'] == 1 ? 'selected' : '' ?>>Feu</option>
            <option value="2" <?= $sort['element_id'] == 2 ? 'selected' : '' ?>>Eau</option>
            <option value="3" <?= $sort['element_id'] == 3 ? 'selected' : '' ?>>Lumière</option>
            <option value="4" <?= $sort['element_id'] == 4 ? 'selected' : '' ?>>Air</option>
        </select>

        <label for="image">Changer l'image (facultatif) :</label>
        <input type="file" name="image" id="image">

        <button type="submit">Mettre à jour le sort</button>
    </form>

</body>
<?php include('../includes/footer.php')?>
</html>