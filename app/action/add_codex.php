<?php include('../includes/function.php');?>

<?php
    $check = $bdd->prepare("SELECT * FROM user_elements WHERE user_id = :user_id AND element_id = :element_id");
    $check->execute([
        'user_id' => $_SESSION['userid'],
        'element_id' => $_POST['element_id']
    ]);

    if ($check->rowCount() > 0 || $_SESSION['role'] == 'admin') {
        // Il peut ajouter le sort
        // INSERT INTO sorts ...
    } else {
        echo "⛔ Tu ne maîtrises pas cet élément !";
    }
?>