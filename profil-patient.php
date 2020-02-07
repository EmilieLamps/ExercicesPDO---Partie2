<?php
$page = "Partie 2 "; // Définir la variable pour changer le titre !
include 'header.php';
require_once 'verifications.php';
$id = '';
// Récupère l'identifant du patient pour pouvoir être appelé ultérieurement
if (!empty($_GET['id'])) {
    $id = $_GET['id'];
}

// Connexion à la BDD
function connectDb() {
    require_once 'params.php';
    $dsn = 'mysql:dbname=' . DB . ';host=' . HOST;
    try {
        $db = new PDO($dsn, USER, PASSWD);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $db;
    } catch (Exception $ex) {
        die('La connexion à la base de données a échoué !');
    }
}

$db = connectDb();

// Préparation et exécution  de la requête SELECT
$sth = $db->prepare('SELECT * FROM `patients` WHERE `patients`.`id` = :id');
$sth->bindValue(':id', $id, PDO::PARAM_STR);
$sth->execute();


// Condition pour la mise à jour
$usersList = $sth->fetchAll(PDO::FETCH_ASSOC);
if ($isSubmitted && count($errors) == 0) {
    $sth = $db->prepare('UPDATE `patients` SET `lastname` = :lastname, `firstname` = :firstname, `birthdate` = :birthdate, `phone`= :phone, `mail` = :mail WHERE `id`= :id');
    $sth->bindValue(':id', $id, PDO::PARAM_STR);
    $sth->bindValue(':lastname', $lastName, PDO::PARAM_STR);
    $sth->bindValue(':firstname', $firstName, PDO::PARAM_STR);
    $sth->bindValue(':birthdate', $birthDate, PDO::PARAM_STR);
    $sth->bindValue(':phone', $phoneNumber, PDO::PARAM_STR);
    $sth->bindValue(':mail', $mail, PDO::PARAM_STR);
    $sth->execute();
}
// Boucle pour permettre de lister ou d'afficher chaque patient lors des requêtes d'affichage ou de mise à jour
foreach ($usersList as $value) {
    
}
?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 mt-5">
            <form action="#" method="POST" novalidate>
                <div class="form-group">
                    <label class="lastName" for="lastName">Nom : </label>
                    <input class="form-control" type="text" name="lastName" id="lastName " value="<?= $value['lastname'] ?>" />
                    <span class="text-danger"><?= ($errors['lastName']) ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label class="firstName" for="firstName">Prénom : </label>
                    <input class="form-control" type="text" name="firstName" id="firstName" value="<?= $value['firstname'] ?>" />
                    <span class="text-danger"><?= ($errors['firstName']) ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label class="birthDate" for="birthDate">Date de naissance : </label>
                    <input class="form-control" type="date" name="birthDate" id="birthDate" value="<?= $value['birthdate'] ?>" />
                    <span class="text-danger"><?= ($errors['birthDate']) ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label class="phoneNumber" for="phoneNumber">Téléphone : </label>
                    <input class="form-control" type="text" name="phoneNumber" id="phoneNumber" value="<?= $value['phone'] ?>" />
                    <span class="text-danger"><?= ($errors['phoneNumber']) ?? '' ?></span>
                </div>
                <div class="form-group">
                    <label class="mail" for="mail">Mail : </label>
                    <input class="form-control" type="email" name="mail" id="mail" value="<?= $value['mail'] ?>" />
                    <span class="text-danger"><?= ($errors['mail']) ?? '' ?></span>
                </div>
                <div class="text-center pt-2">
                    <button class="btn btn-outline-success mt-3" type="submit" name="submit" id="button">Enregistrer</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>
