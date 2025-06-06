<?php 
include('../includes/function.php');
//Recup autant de checkbox que d'éléments en BDD
$readElements = $bdd->query('SELECT * 
                            FROM elements');
$elementsList = $readElements->fetchAll();


//Inscription
if(!empty($_POST['username']) && !empty($_POST['password'])){
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);
    $passwordConfirm = htmlspecialchars($_POST['passwordConfirm']);
    $elements = $_POST['elements'] ?? [];

    // REQUETE read qui va permettre de lire la table user
    $request = $bdd->prepare('  SELECT COUNT(*) as usernb
                                FROM users 
                                WHERE username = ? '                     
    );

    $request->execute(array($username));

    $data = $request->fetch();

    // On verifie que cet utilisateur n'existe pas déjà
    if($data['usernb'] >= 1){
        header('location:subscribe.php?error=2');
    }else{

        // Cryptage du mot de passe
        if($password == $passwordConfirm){
            $passwordCrypt = password_hash($password,PASSWORD_BCRYPT);

            // Préparation de la requête
            $request = $bdd->prepare('INSERT INTO users (username,password, role)
                                    VALUES (:username,:password, :role)'
        );


            $request->execute(array(
            'username' =>  $username,
            'password'  =>  $passwordCrypt,
            'role' => 'eleve'
            ));
            $userId = $bdd->lastInsertId();

            if (!empty($elements)) {
                foreach ($elements as $elementId) {
                    $insert = $bdd->prepare("INSERT INTO user_elements (user_id, element_id) 
                                            VALUES (:user_id, :element_id)"
                                            );
                    $insert->execute([
                        'user_id' => $userId,
                        'element_id' => (int)$elementId
                    ]);
                }
            }
            header('location:/Academie/index.php?success=4');
        }else{
            header('location:subscribe.php?error=1');
        }
    }
}

?>

<?php 
$pageTitle = "Inscription";
include('../includes/head.php'); ?>
<body>
    <?php include('../includes/nav.php') ?>
    <h2>Inscription</h2>
    
    <?php if(isset($_GET['error'])){ ?>
       <?php  switch($_GET['error']){
                case 1:
                    echo "<p class='error'>Vos mots de passe ne correspondent pas</p>";
                    break;
                case 2:
                    echo "<p class='error'>Ce nom d'utilisateur existe déjà</p>";
                    break;
            }
        } ?>
    <div class="formulaire">
        <form action="subscribe.php" method="post">
            <label for="username">Votre nom de magicien</label>
            <input type="text" name="username" id="username">
            <label for="password">Votre mot de passe</label>
            <input type="password" name="password" id="password">
            <label for="passwordConfirm">Confirmez votre mot de passe</label>
            <input type="password" name="passwordConfirm" id="passwordConfirm">
            <!-- Input checkbox -->
            <fieldset>
                <legend>Choisissez vos éléments :</legend>
                <?php foreach ($elementsList as $element): ?>
                    <label>
                        <?= htmlspecialchars($element['nom']) ?>
                        <input type="checkbox" name="elements[]" value="<?= $element['id'] ?>">
                    </label>
                <?php endforeach; ?>
            </fieldset>
            <button>Rejoindre l'Académie</button>
        </form>
    </div>    
</body>
<?php include('../includes/footer.php')?>
</html>