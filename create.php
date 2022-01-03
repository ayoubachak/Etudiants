<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=university;charset=utf8','root','');
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);





$errors = [];

$CNE ='';
$Nom = '';
$Prenom = '';
$Age = '';
$Adresse = '';
$Sexe = '';
$Moyenne = '';
$DateInscription = '';

if ($_SERVER['REQUEST_METHOD']==='POST') {
    $CNE = $_POST['CNE'];
    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $Age = $_POST["Age"];
    $Adresse = $_POST["Adresse"];
    $Sexe = $_POST["Sexe"];
    $Moyenne = $_POST["Moyenne"];
    $DateInscription = date("Y-m-d H:i:s");


    if (!$CNE){
        $errors[]='CNE est obligatoire';
    }if (!$Nom){
        $errors[]='Nom est obligatoire';
    }if (!$Prenom){
        $errors[]='Prenom est obligatoire';
    }if (!$Age){
        $errors[]='Age est obligatoire';
    }if (!$Adresse){
        $errors[]='Adresse est obligatoire';
    }if (!$Sexe){
        $errors[]='Sexe est obligatoire';
    }if (!$Moyenne){
        $errors[]='Moyenne est obligatoire';
    }

    if (empty($errors)) {

        $statement = $pdo->prepare("INSERT INTO etudiant (CNE, Nom, Prenom, Age, DateInscription, Adresse, Sexe, Moyenne)   VALUES  (:CNE, :Nom, :Prenom, :Age, :DateInscription, :Adresse, :Sexe, :Moyenne)");
        $statement->bindValue(':CNE', $CNE);
        $statement->bindValue(':Nom', $Nom);
        $statement->bindValue(':Prenom', $Prenom);
        $statement->bindValue(':Age', $Age);
        $statement->bindValue(':DateInscription', $DateInscription);
        $statement->bindValue(':Adresse', $Adresse);
        $statement->bindValue(':Sexe', $Sexe);
        $statement->bindValue(':Moyenne', $Moyenne);
        $statement->execute();
        header("Location: index.php");
    }
}
function randomString($n){

    $characters = '0123456789'.'abcdefghijklmnopqrstuvwxyz'.strtoupper('abcdefghijklmnopqrstuvwxyz');
    $str = '';
    for ($i =0 ; $i<$n; $i++){
        $index = rand(0, strlen($characters)-1);
        $str .= $characters[$index];
    }
    return $str;
}
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
    <title>Products CRUD</title>
</head>
<body>
<h1>Nouvau Etudiant</h1>
<?php if (!empty($errors)):?>
    <div class="alert alert-danger">
        <?php foreach ($errors as $error): ?>
            <div><?php  echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif;?>

<form class="form" method="post" action="">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="Nom">Nom</label>
            <input type="text" class="form-control" id="Nom"  name ="Nom" placeholder="Entrer le nom" value="<?php echo $Nom?>">
        </div>
        <div class="form-group col-md-6">
            <label for="Prenom">Prenom</label>
            <input type="text" class="form-control" id="Prenom"  name ="Prenom" placeholder="Entrer le prenom" value="<?php echo $Prenom?>">
        </div>

    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="Age">Age</label>
            <input type="text" class="form-control" id="Age"  name ="Age" placeholder="Entrer l'age " value="<?php echo $Age?>">
        </div>
        <div class="form-group col-md-6">
            <label for="CNE">CNE</label>
            <input type="text" class="form-control" id="CNE"  name ="CNE" placeholder="Carte Nationale d'etudiant" value="<?php echo $CNE?>">
        </div>
    </div>
    <div class="form-group">
        <label for="Adresse">Address</label>
        <input type="text" class="form-control" id="Adresse"  name ="Adresse" placeholder="Addresse..." value="<?php echo $Adresse?>">
    </div>
    <div class="form-row">

        <div class="form-group col-md-4">
            <label for="Sexe">Sexe</label>
            <input type="text" class="form-control" id="Sexe"  name ="Sexe" placeholder="M or F" value="<?php echo $Sexe?>">
        </div>
        <div class="form-group col-md-2">
            <label for="Moyenne">Moyenne</label>
            <input type="text" class="form-control" id="Moyenne"  name ="Moyenne" placeholder="" value="<?php echo $Moyenne?>">
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <a href="index.php" class="btn btn-primary">Back</a>
</form>

</body>
</html>