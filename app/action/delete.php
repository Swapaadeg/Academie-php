<?php
    include('../includes/function.php');

    $id = (int) $_GET['id'];
    $userId = $_SESSION['userid'];

    // Vérifie si la créature appartient à l'utilisateur
    $req = $bdd->prepare("SELECT * 
                        FROM bestiaire
                        WHERE id = :id 
                        AND user_id = :user_id");
    $req->execute(['id' => $id, 'user_id' => $userId]);
    $data = $req->fetch();

    if (!$data) {
        echo("Suppression non autorisée.");
    }

    // Supprime la créature
    $delete = $bdd->prepare("DELETE FROM bestiaire
                            WHERE id = :id 
                            AND user_id = :user_id");
    $delete->execute(['id' => $id, 'user_id' => $userId]);
?>