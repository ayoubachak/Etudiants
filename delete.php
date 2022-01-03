<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=university;charset=utf8','root','');
$pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$CNE = $_POST['CNE'] ?? null;
if (!$CNE){
    header("Location: index.php");
    exit;
}
$statement = $pdo ->prepare('DELETE FROM etudiant WHERE CNE = :CNE');
$statement->bindValue(':CNE', $CNE);
$statement->execute();
header("Location: index.php");