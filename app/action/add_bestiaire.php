<?php include('../includes/function.php');?>

<?php

if(isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['type'])){
    $nom=sanitarize($_POST['nom']);
    $description=sanitarize($_POST['description']);
    $type=sanitarize($_POST['type']);

    if(empty($_FILES['img'])){
        $img = NULL;
    }else{
        $imageName = sanitarize($_FILES['image']['name']);
        $imageInfo = pathinfo($imageName);
        $imageExt = $imageInfo['extension'];
        $autorizedExt = ['png','jpeg','jpg','webp','bmp','svg'];

        if(in_array($imageExt,$autorizedExt)){
            $img = time() . rand(1,1000) . "." . $imageExt;
            move_uploaded_file($_FILES['image']['tmp_name'],"../../assets/img".$img)
        };
    };

    $bdd = new PDO('mysql:host=mysql;dbname=academie;charset=utf8', 'root', 'root');

    $request=$bdd->prepare('INSERT INTO bestiaire (nom, description,type,img,user_id) 
                            VALUE (:nom,:description,:type,:img,:user_id'
                            );
    $request->execute(array(
    'nom' =>  $nom,
    'description'  =>  $description,
    'type' =>  $type,
    'user_id'=> $_SESSION['userid'],
    'img'   => $img,
    ));

    header('location:/Academie/index.php?success=1')
}
?>
<body>
    <?php include('../includes/nav.php') ?>
    <?php include('../includes/head.php');?>

    <section>
        <form action="app/action/add.php" method="POST" class="creature-form">
        <label for="name">Nom de la créature :</label>
        <input type="text" id="name" name="name" required>

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

    </section>
   
    
</body>
</html>