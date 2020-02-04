<?php
$page = "Partie 2 "; // Définir la variable pour changer le titre !
include 'header.php';

// Connexion à la BDD
function connectDb() {
    require_once 'params.php';

    $dsn = 'mysql:dbname=' . DB . ';host=' . HOST;

    try {
        $db = new PDO($dsn, USER, PASSWD);
        return $db;
    } catch (Exception $ex) {
        die('La connexion à la base de données a échoué !');
    }
}

$db = connectDb();

$query = 'SELECT * FROM `patients`';
$usersQueryStat = $db->query($query);
$usersList = $usersQueryStat->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="container">
    <div class="jumbotron bg-light pt-5">

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Prénom</th>
                    <th class="text-center">Nom</th>
                    <th class="text-center">Modifier</th>
                    <th class="text-center">Supprimer</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($usersList as $key => $user):
                    ?>
                    <tr> 
                        <td class="text-center"><?= $key + 1 ?></td>
                        <td class="text-center"><?= $user['firstname'] ?></td>
                        <td class="text-center"><?= $user['lastname'] ?> </td>
                        <td class="text-center">                         
                            <a  href="profil-patient.php?id=<?=$user['id'] ?>">  <button class="btn btn-outline-success" type="submit" name="submit" id="button">Consulter</button></a>
                        </td>
                        <td class="text-center">                         
                            <button class="btn btn-outline-danger" type="submit" name="deleteButton" id="deleteButton">Supprimer</button>
                        </td>
                    </tr>

                    <?php
                endforeach;
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include 'footer.php';
?>
