<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=university;charset=utf8','root','');
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$search = $_GET['search']?? '';
if ($search){
    $statement = $pdo ->prepare('SELECT * FROM etudiant WHERE Nom LIKE :Nom ORDER BY DateInscription DESC ');
    $statement ->bindValue(":Nom", "%$search%" );
}else{

    $statement = $pdo ->prepare('SELECT * FROM etudiant ORDER BY DateInscription DESC ');
}

$statement->execute();
$etudiants = $statement->fetchAll(PDO::FETCH_ASSOC);

//echo '<pre>';
//var_dump($products);
//echo '</pre>';

?>

<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <link rel = 'stylesheet' href="app.css">
    <title>Etudiants Ensam Casa</title>
</head>
<body>
<h1>Etudiants Ensam Casa</h1>
<p>
<a href = 'create.php' class = 'btn btn-success'>Ajouter  Etudiant</a>
</p>
<form>
    <div class="input-group mb-3">
        <input type="text" class="form-control" placeholder="Chercher par Nom" value="<?php echo $search ?>" name="search">
        <button class="btn btn-outline-secondary" type="submit" >Search</button>
    </div>
</form>
<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">CNE</th>
        <th scope="col">Nom</th>
        <th scope="col">Prenom</th>
        <th scope="col">Age</th>
        <th scope="col">Date d'Inscription</th>
        <th scope="col">Adresse</th>
        <th scope="col">Sexe</th>
        <th scope="col">Moyenne</th>
        <th scope="col">Action</th>
    </tr>
    </thead>
    <tbody>
<?php   foreach($etudiants as $i => $etudiant):?>
    <tr>
        <th scope="row"><?php echo $i +1?></th>
        <td><?php echo $etudiant["CNE"];?></td>
        <td><?php echo $etudiant["Nom"];?></td>
        <td><?php echo $etudiant["Prenom"];?></td>
        <td><?php echo $etudiant["Age"];?></td>
        <td><?php echo $etudiant["DateInscription"];?></td>
        <td><?php echo $etudiant["Adresse"];?></td>
        <td><?php
            if(strtolower($etudiant["Sexe"]) == "m"){
                echo "Male";
            }else if(strtolower($etudiant["Sexe"]) == "f"){
                echo "Female";
            }else{
                echo "-";
            } ?>
        </td>
        <td><?php echo $etudiant["Moyenne"];?></td>
        <td>
            <a href="update.php?CNE=<?php echo $etudiant['CNE']?>" class="btn-sm btn-primary">Edit</a>
            <form style="display: inline-block" method="post" action="delete.php">
                <input type="hidden" name="CNE" value="<?php echo $etudiant['CNE']?>">
                <button type="submit" class="btn-sm btn-outline-danger">Delete</button>
            </form>
        </td>
    </tr>
<?php endforeach;  ?>
    </tbody>
</table>

</body>
</html>