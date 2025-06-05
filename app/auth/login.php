<?php
    include('../includes/function.php');

    if(!empty($_POST['username']) && !empty($_POST['password'])){
        $entryUsername= htmlspecialchars($_POST['username']);
        $entryPassword =($_POST['password']);

        $request = $bdd->prepare("SELECT *
                                FROM users
                                WHERE username = :username"
                                );
        $request->execute(['username' => $entryUsername]);
        $data = $request->fetch();
        var_dump($data);

        if($data && password_verify($entryPassword, $data['password'])) {
            $_SESSION['users'] = $data['username'];
            $_SESSION['userid'] = $data['id'];
            $_SESSION['role'] = $data['role'];
            header('location:/Academie/index.php');
        }else{
            echo '<p class=error">Entrées incorrectes</p>';
        }
    }    
?>

<?php include('../includes/head.php'); ?>
<body>
    <?php include('../includes/nav.php') ?>
    <h2>Connexion</h2>
    <div class="formulaire">
        <form id="auth" action="login.php" method='POST'>
            <label for="username">Votre nom de magicien</label>
            <input type="text" name="username" id="username">
            <label for="password">Votre mot de passe</label>
            <input type="password" name="password" id="password">
            <button>Prendre mes fonctions</button>
        </form> 
    </div>
</body>
</html>