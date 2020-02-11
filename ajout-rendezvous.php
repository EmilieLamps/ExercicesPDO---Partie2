<?php
$page = "Partie 2 "; // Définir la variable pour changer le titre !
include 'header.php';
require_once 'verificationsRdv.php';
$dateHour = $appointmentDate . ' ' . $appointmentHour;
$message = '';
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

$query = 'SELECT id, lastname, firstname FROM `patients`';
$usersQueryStat = $db->query($query);
$usersList = $usersQueryStat->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="row mt-5 justify-content-center">
        <div class="col-md-6">
            <div class="jumbotron bg-light text-center">
                <?php
                if ($isSubmitted && count($errors) == 0) {

                    $sth = $db->prepare('INSERT INTO `appointments`(dateHour, idPatients) VALUES(:dateHour, :patients)');
                    $sth->bindValue(':dateHour', $dateHour, PDO::PARAM_STR);
                    $sth->bindValue(':patients', $patients, PDO::PARAM_STR);
                    $sth->execute();
                    

                    $message = 'Le rendez-vous du patient  a bien été enregistré';
                    ?>
                    <p><?= $message ?></p>
                    <div class="text-center pt-2">
                        <a href="http://exercicespdo2.info/ajout-patient.php"<button class="btn btn-outline-dark mt-3" type="submit" name="submit" id="registerButton">Enregistrer un nouveau patient</button></a>
                    </div>
                    <div class="text-center pt-2">
                        <a href="http://exercicespdo2.info/index.php" <button class="btn btn-light mt-3" type="submit" name="homeButton" id="homeButton">Retourner à l'accueil</button></a>
                    </div>
                    <div class="text-center pt-2">
                        <a href="http://exercicespdo2.info/liste-patients.php" <button class="btn btn-litht mt-3" type="submit" name="patientslList" id="patientslList">Voir la liste des patients</button></a>
                    </div>
                <?php } else { ?>
                    <h2 class="text-center">Prendre un rendez-vous</h2>
                    <hr>
                    <form action="#" method="POST" novalidate>
                        <label for="patients-select">Choisir un patient :</label>
                        <select name="patients" id="patients-select">
                            <option value="0">--Choix du patient--</option>
                            <?php foreach ($usersList as $patient) : ?>
                                <option value="<?= $patient['id'] ?>"><?= $patient['lastname'] . ' ' . $patient['firstname'] ?></option>
                                
                            <?php endforeach; ?>
                                
                        </select>
                          <span class="text-danger"><?= ($errors['patient']) ?? '' ?></span>
                        <div class="form-group">
                            <label class="appointmentDate" for="appointmentDate">Date du rendez-vous : </label>
                            <input class="form-control" type="date" name="appointmentDate" id="appointmentDate" value="<?= $appointmentDate ?>" />
                            <span class="text-danger"><?= ($errors['appointmentDate']) ?? '' ?></span>
                        </div>
                        <div class="form-group">
                            <label class="appointmentHour" for="appointmentHour">Heure du rendez-vous : </label>
                            <input class="form-control" type="time" name="appointmentHour" id="appointmentHour" min="09:00" max="18:00" required value="<?= $appointmentHour ?>" />
                            <span class="text-danger"><?= ($errors['appointmentHour']) ?? '' ?></span>
                        </div>
                        <div class="text-center pt-2">
                            <button class="btn btn-outline-success mt-3" type="submit" name="submit" id="button">Enregistrer</button>
                        </div>
                    </form>
                    <?php
                }
              
                ?>
            </div>
        </div>
    </div>
    <?php
    include 'footer.php';
    