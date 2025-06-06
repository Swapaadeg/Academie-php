<?php include('../includes/function.php'); ?>
    
<!-- CODEX DELETE-->
<?php
    if (isset($_GET['id'])) {
        $id = htmlspecialchars($_GET['id']);
        $userId = $_SESSION['userid'];
        $userRole = $_SESSION['role'] ?? 'eleve';

        // Lecture du sort
        $requestRead = $bdd->prepare('SELECT * 
                                    FROM sorts 
                                    WHERE id = :id'
                                    );
        $requestRead->execute(['id' => $id]);
        $data = $requestRead->fetch();

        if (!$data) {
            header('location:/Academie/index.php?error=4');
            exit();
        }

        $elementId = $data['element_id'];

        if ($userRole === 'admin') {
            $hasPermission = true;
        } else {
            // Si user maitrise l'élément
            $check = $bdd->prepare('SELECT * 
                                    FROM user_elements 
                                    WHERE user_id = :user_id 
                                    AND element_id = :element_id'
                                    );
            $check->execute([
                'user_id' => $userId,
                'element_id' => $elementId
            ]);
            $hasPermission = $check->rowCount() > 0;
        }

        if ($hasPermission) {
            if (!empty($data['img'])) {
                unlink('../../assets/img/' . $data['img']);
            }

            $delete = $bdd->prepare('DELETE FROM sorts 
                                    WHERE id = :id'
                                    );
            $delete->execute(['id' => $id]);

            header('location:/Academie/index.php?success=5');
            exit();
        } else {
            header('location:/Academie/index.php?error=4');
            exit();
        }
    } else {
        header('location:/Academie/index.php');
        exit();
    }