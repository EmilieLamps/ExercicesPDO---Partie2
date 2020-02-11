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
$query = 'SELECT * FROM `appointments`';
$usersQueryStat = $db->query($query);
$usersList = $usersQueryStat->fetchAll(PDO::FETCH_ASSOC);

if (isset($_GET['deleteButton'])) {
    $sth = $db->prepare('DELETE FROM `appointments` WHERE `id`= :id');
    $sth->bindValue(':id', $_GET['deleteButton'], PDO::PARAM_STR);
    $sth->execute();
    // Permet de recharger la page 
    header("location: liste-rendezvous.php");
}
?>
<div class="container">
    <div class="jumbotron bg-light pt-5">
        <h2 class="text-center">Liste des rendez-vous</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Id</th>
                    <th class="text-center">Prénom</th>
                    <th class="text-center">Nom</th>
                    <th class="text-center">Rendez-vous</th>
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
                        <td class="text-center"> <?= $user['appointments'] ?> </td>                        
                <a  href="rendezvous.php.php?id=<?= $user['id'] ?>">  <button class="btn btn-outline-success" type="submit"  id="button">Consulter</button></a>
                </td>
                <td>
                    <a href="javascript:deleteButton(<?= $user['id']; ?>)"><button type="button" class="btn btn-danger">Supprimer </button></a>
                </td>
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