<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=university;charset=utf8','root','');
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$CNE = $_GET['CNE'] ?? null;
if (!$CNE){
    header("Location: index.php");
    exit;
}

$statement = $pdo ->prepare('SELECT * FROM etudiant WHERE CNE = :CNE');
$statement->bindValue(':CNE', $CNE);
$statement->execute();
$etudiant = $statement->fetch(PDO::FETCH_ASSOC);
//echo '<pre>';
//var_dump($etudiant);
//echo '</pre>';
//exit;
$errors = [];
$Nom =$etudiant['Nom'];
$Prenom = $etudiant['Prenom'];
$Age = $etudiant["Age"];
$Adresse = $etudiant["Adresse"];
$Sexe = $etudiant["Sexe"];
$Moyenne = $etudiant["Moyenne"];


if ($_SERVER['REQUEST_METHOD']==='POST') {

    $Nom = $_POST['Nom'];
    $Prenom = $_POST['Prenom'];
    $Age = $_POST["Age"];
    $Adresse = $_POST["Adresse"];
    $Sexe = $_POST["Sexe"];
    $Moyenne = $_POST["Moyenne"];



    if (!$Nom){
        $errors[]='Nom est obligatoire';
    }if (!$Prenom){
        $errors[]='Prenom est obligatoire';
    }if (!$Age){
        $errors[]='NAge est obligatoire';
    }if (!$Adresse){
        $errors[]='Adresse est obligatoire';
    }if (!$Sexe){
        $errors[]='Sexe est obligatoire';
    }if (!$Moyenne){
        $errors[]='Moyenne est obligatoire';
    }
    if (empty($errors)) {

        $statement = $pdo->prepare("UPDATE etudiant SET Nom= :Nom, Prenom= :Prenom , Age= :Age , Adresse= :Adresse , Sexe= :Sexe , Moyenne= :Moyenne  WHERE CNE= :CNE");
        $statement->bindValue(':Nom', $Nom);
        $statement->bindValue(':Prenom', $Prenom);
        $statement->bindValue(':Age', $Age);
        $statement->bindValue(':Adresse', $Adresse);
        $statement->bindValue(':Sexe', $Sexe);
        $statement->bindValue(':Moyenne', $Moyenne);
        $statement->bindValue(':CNE', $CNE);
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
    <title>Etudiants Ensam Casa</title>
</head>
<body>

<p>
    <a href="index.php" class="btn btn-secondary">List des Etudiants</a>
</p>

<h1>Update Etudiant <b><?php echo $etudiant['Nom']." ".$etudiant['Prenom']?></b></h1>
<?php if (!empty($errors)):?>
    <div class="alert alert-danger">
        <?php foreach  ($errors as $error): ?>
            <div><?php  echo $error ?></div>
        <?php endforeach; ?>
    </div>
<?php endif;?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="Nom">Nom</label>
            <input type="text" class="form-control" id="Nom"  name ="Nom" placeholder="Enter your Name" value="<?php echo $Nom?>">
        </div>
        <div class="form-group col-md-6">
            <label for="Prenom">Prenom</label>
            <input type="text" class="form-control" id="Prenom"  name ="Prenom" placeholder="Enter your Last Name" value="<?php echo $Prenom?>">
        </div>

    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="Age">Age</label>
            <input type="text" class="form-control" id="Age"  name ="Age" placeholder="Enter your Age" value="<?php echo $Age?>">
        </div>
    </div>
    <div class="form-group">
        <label for="Adresse">Address</label>
        <input type="text" class="form-control" id="Adresse"  name ="Adresse" placeholder="1234 Main St" value="<?php echo $Adresse?>">
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

</form>
</body>
</html>
