<?php include('../includes/function.php');?>

<?php
    if(isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['type'])){
        $nom=htmlspecialchars($_POST['nom']);
        $description=htmlspecialchars($_POST['description']);
        $type=htmlspecialchars($_POST['type']);

        $img = NULL;

        if (!empty($_FILES['image']) && $_FILES['image']['error'] === 0) {
            $imageName = htmlspecialchars($_FILES['image']['name']);
            $imageInfo = pathinfo($imageName);
            $imageExt = strtolower($imageInfo['extension']);
            $autorizedExt = ['png', 'jpeg', 'jpg', 'webp', 'bmp', 'svg'];

            if(in_array($imageExt,$autorizedExt)){
                $img = time() . rand(1,1000) . "." . $imageExt;
                move_uploaded_file($_FILES['image']['tmp_name'],"../../assets/img/" . $img);
            };
        };

        $bdd = new PDO('mysql:host=mysql;dbname=academie;charset=utf8', 'root', 'root');

        $request=$bdd->prepare('INSERT INTO bestiaire (nom, description,type,img,user_id) 
                                VALUES (:nom,:description,:type,:img,:user_id)'
                                );
        $success = $request->execute(array(
            'nom' =>  $nom,
            'description'  =>  $description,
            'type' =>  $type,
            'user_id'=> $_SESSION['userid'],
            'img'   => $img,
        ));

        if ($success) {
            $message = "<h3>🛡️ Vous avez vaincu cette créature ! Elle a bien été ajoutée au bestiaire 🐾</h3>";
        }else{
            $message = "<h3>💀 Votre créature s'est rebellée... Elle n'a pas été ajoutée au bestiaire 😱</h3>";
        }
    }
?>
    <?php 
        $pageTitle = "Ajouter une créature";
        include('../includes/head.php');
    ?>
<body>
    <?php include('../includes/nav.php') ?>

    <section>
        <form action="add_bestiaire.php" method="POST" class="creature-form" enctype="multipart/form-data">
        <label for="nom">Nom de la créature :</label>
        <input type="text" id="nom" name="nom" required>

        <label for="description">Description :</label>
        <textarea id="description" name="description" required></textarea>

        <label for="type">Type :</label>
        <select id="type" name="type" required>
            <option value="">-- Sélectionner un type --</option>
            <option value="aquatique">Aquatique</option>
            <option value="démoniaque">Démoniaque</option>
            <option value="mort-vivante">Mort-vivante</option>
            <option value="mi-bête">Mi-bête</option>
        </select>

        <label for="image">Choisissez une image</label>
        <input id="image" type="file" name="image">

        <button type="submit">Ajouter la créature</button>
        </form>
        <?php if (isset($message)) echo $message; ?>
    </section>
   
    
</body>
<?php include('../includes/footer.php')?>
</html>