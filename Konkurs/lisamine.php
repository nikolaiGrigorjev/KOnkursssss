<?php
require_once ('conf.php');
session_start();
if (!isset($_SESSION['tuvastamine'])){
    header('Location:login.php');
    exit();
}

global $yhendus;

if (!empty($_REQUEST['nimi'])){
$kask=$yhendus->prepare("Insert into konkurs(nimi,pilt,lisamisaeeg) values(?,?,Now())");
$kask->bind_param("ss",$_REQUEST['nimi'],$_REQUEST['pilt']);
$kask->execute();
header("Location: haldus.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <title>Fotokonkurss Lisamis Leht</title>
</head>
<body>
<nav>
    <?php
    if ($_SESSION['onAdmin']==1){
        echo '<a href="haldus.php">Admin Leht</a>
    <a href="lisamine.php">Lisamis Leht</a>';
    }
    ?>
    <a href="konkurs.php">Kasutaja Leht</a>
    <a href="https://github.com" target="_blank">Github</a>
</nav>
<div class="user">
    <p><?=$_SESSION["kasutaja"]?> on sisse logitud</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi välja" name="logout">
    </form>
</div>

<h1>Fotokonkurss Lisamis Leht</h1>
<?php
//tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi, pilt, lisamisaeeg, punktid,kommentarid,avalik FROM konkurs");
$kask->bind_result($id,$nimi,$pilt,$aeg,$punktid,$kommentarid,$avalik);
$kask->execute();
?>
<form action="?">
    </label><input type="text" name="nimi" placeholder="Uus nimi"><br>
    <textarea name="pilt" cols="30" rows="10"></textarea><br>
    <input type="submit" name="lisa">
</form>

</body>
</html>