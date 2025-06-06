<?php
    include('../includes/function.php');
//BESTIAIRE
    if(isset($_GET['id'])){
        $id = htmlspecialchars($_GET['id']);

            // On créer une requete qui va nous permettre de vérifier si la fiche film appartien bien a l'utilisateur
            $requestRead = $bdd->prepare('  SELECT *
                                            FROM bestiaire
                                            WHERE id = :id'
                );

            $requestRead->execute(array(
                    'id'    =>  $id
                ));
            $data = $requestRead->fetch();
            
            // Verification de l'utilisateur
            if ($_SESSION['userid'] == $data['user_id'] || ($_SESSION['userid'] == 1 && $_SESSION['role'] == 'admin')) {
                // Suppression du fichier en local
                unlink('../../assets/img/' . $data['img']);

                //ON EXECUTE LA REQUETE DELETE SI CA CORRESPOND
                $request = $bdd->prepare('DELETE FROM bestiaire
                                        WHERE id=:id');

                $request->execute(['id' =>$id]);

                // echo $id;
                header('location:/Academie/index.php?success=3');
                exit();
            }else{
                header('location:/Academie/index.php?error=1');
            }

        }else{
            header('location:/Academie/index.php');
        }
?>