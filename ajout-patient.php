<?php
$page = "Partie 2 "; // Définir la variable pour changer le titre !
include 'header.php';
include 'verifications.php';
?>
<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron bg-light text-center">
                <?php
                if ($isSubmitted && count($errors) == 0) {
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

                    $sth = $db->prepare('INSERT INTO `patients`(lastname , firstname , birthdate , phone , mail ) VALUE(:lastname, :firstname, :birthdate, :phone, :mail)');
                    // Tableau associatif dans lequel on associe les valeurs aux variables
                    $sth->bindValue(':lastname', $lastName, PDO::PARAM_STR);
                    $sth-> bindValue(':firstname', $firstName, PDO::PARAM_STR);
                    $sth-> bindValue(':birthdate', $birthDate, PDO::PARAM_STR);
                    $sth-> bindValue(':phone', $phoneNumber, PDO::PARAM_STR);
                    $sth-> bindValue(':mail' , $mail, PDO::PARAM_STR);
                    
                    $sth->execute();
                   
                    $message = 'Le patient ' . $lastName . ' ' . $firstName . ' a bien été enregistré';
                    ?>
                    <p><?= $message ?></p>
                    <?php
                } else {
                    ?>
                    <h2 class="text-center">Ajouter un patient</h2>
                    <hr>
                    <p class="text-center">Veuillez entrer les informations du patient</p>

                    <form action="#" method="POST" novalidate>
                        <div class="form-group">
                            <label class="lastName" for="lastName">Nom : </label>
                            <input class="form-control" type="text" name="lastName" id="lastName " value="<?= $lastName ?>" />
                            <span class="text-danger"><?= ($errors['lastName']) ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label class="firstName" for="firstName">Prénom : </label>
                            <input class="form-control" type="text" name="firstName" id="firstName" value="<?= $firstName ?>" />
                            <span class="text-danger"><?= ($errors['firstName']) ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label class="birthDate" for="birthDate">Date de naissance : </label>
                            <input class="form-control" type="date" name="birthDate" id="birthDate" value="<?= $birthDate ?>" />
                            <span class="text-danger"><?= ($errors['birthDate']) ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label class="phoneNumber" for="phoneNumber">Téléphone : </label>
                            <input class="form-control" type="text" name="phoneNumber" id="phoneNumber" value="<?= $phoneNumber ?>" />
                            <span class="text-danger"><?= ($errors['phoneNumber']) ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label class="mail" for="mail">Mail : </label>
                            <input class="form-control" type="email" name="mail" id="mail" value="<?= $mail ?>" />
                            <span class="text-danger"><?= ($errors['mail']) ?? '' ?></span>
                        </div>
                        <div class="text-center pt-2">
                            <button class="btn btn-outline-success mt-3" type="submit" name="submit" id="button">Enregistrer</button>
                        </div>
                    </form>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php
include 'footer.php';
?>
