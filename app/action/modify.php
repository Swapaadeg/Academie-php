<?php
    include('../includes/function.php');
    // Creation d'une condition, si un "id" est trouvé on reste sur la page sinon on retourne sur l'index
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);

            // ----------REQUEST READ-----------
            // On créer une requete READ pour mettre les valeurs existante dans les champs de formulaire
            $requestRead = $bdd->prepare('  SELECT *
                                            FROM bestiaire
                                            WHERE id = :id'
                );

            $requestRead->execute(array(
                    'id'=>$id
                ));
            $data = $requestRead->fetch();

         
            // On vérifie si l'utilisateur est bien celui qui a créé la fiche
            if ($_SESSION['userid'] != $data['user_id'] && !($_SESSION['userid'] == 1 && $_SESSION['role'] == 'admin')) {
                header("location:/Academie/index.php?error=2");
                exit();
            }

    }else{
        header('location:/Academie/index.php');
    }

        // RECUPERATION DES DONNEES POST (POUR l'UPDATE)
        if(isset($_POST['nom']) && isset($_POST['description']) && isset($_POST['type'])){
            $nom=htmlspecialchars($_POST['nom']);
            $description=htmlspecialchars($_POST['description']);
            $type=htmlspecialchars($_POST['type']);
            $id=htmlspecialchars($_POST['id']);

            
            // REQUETE SQL POUR vérifier si la fiche appartient bien a l'utilisateur et pour plus tard que le nom du fichier appartenant a la fiche film concernée
            $request = $bdd->prepare('  SELECT id,img,user_id
                                        FROM bestiaire 
                                        WHERE id = ? '
        
            );

            $request->execute(array($id));

            $data = $request->fetch();

            // VERIFICATION si la fiche appartient bien a l'utilisateur
            if ($_SESSION['userid'] == $data['user_id'] || ($_SESSION['userid'] == 1 && $_SESSION['role'] == 'admin')) {

                    // --------------TRAITEMENT DE L'IMAGE------------
                    //    Si le champ image est vide on fait la requête update sans l'image
                if($_FILES['image']['error'] === UPLOAD_ERR_NO_FILE){

                                // REQUETE UPDATE SANS IMG
                                $request = $bdd->prepare('  UPDATE bestiaire
                                SET nom = :nom, type=:type,description=:description
                                WHERE id = :id'
                            );

                        $request->execute(array(
                        'nom' =>  $nom,
                        'description' =>  $description,
                        'type'  =>  $type,
                        'id'    =>  $id
                        ));

                    header("location:/Academie/index.php?success=2");

                }else{
                    $imageName = htmlspecialchars($_FILES['image']['name']);
                    $imageInfo = pathinfo($imageName);
                    $imageExt = $imageInfo['extension'];
                // Tableau qui va permettre de spécifier les extensions autorisées
                    $autorizedExt = ['png','jpeg','jpg','webp','bmp','svg'];

                // Verification de l'extention du fichier

                    if(in_array($imageExt,$autorizedExt)){
                        $img = time() . rand(1,1000) . "." . $imageExt;
                        // On stocke le fichier en local 
                        move_uploaded_file($_FILES['image']['tmp_name'],"../../assets/img/".$img);


                        unlink("../../assets/img/" . $data['img']);
                    
                    }else{
                        // echo 'location:/perigueux_php_full/index.php?success=1';
                    }


                        // -----------REQUETE UPDATE---------------
                        $request = $bdd->prepare('  UPDATE bestiaire
                        SET nom = :nom, type=:type,description=:description,img=:img
                        WHERE id = :id'
                        );

                    $request->execute(array(
                    'nom' =>  $nom,
                    'type'  =>  $type,
                    'description' =>  $description,
                    'img'   =>  $img,
                    'id'    =>  $id
                    ));
                    // Renvois de l'utilisateur sur l'index aprés validation de formulaire
                    header("location:/Academie/index.php?success=2");
                    exit();
                }

            }else{
                header("location:/Academie/index.php?error=2");
            }

        }

  
?>

<?php include('../includes/head.php'); ?>
<body>
    <?php include('../includes/nav.php') ?>
    <form action="modify.php?id=<?= $data['id'] ?>" method="POST" enctype="multipart/form-data">
        <label for="nom">Ajoutez une nouvelle créature</label>
        <input id="nom" type="text" name="nom" value="<?php echo $data['nom'];?>">
        <label for="description">Entrez la description</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($data['description']) ?></textarea>
        <select id="type" name="type" required>
            <option value="">-- Sélectionner un type --</option>
            <option value="aquatique">Aquatique</option>
            <option value="démoniaque">Démoniaque</option>
            <option value="mort-vivante">Mort-vivante</option>
            <option value="mi-bête">Mi-bête</option>
        </select>
        <input type="hidden" name="id" value="<?php echo $data['id'];?>">
        <label for="image">Choisissez une image</label>
        <input id="image" type="file" name="image">

        <button>Modifier</button>
    </form>
    
</body>
<?php include('../includes/footer.php')?>
</html>