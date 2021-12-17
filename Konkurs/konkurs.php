<?php
require_once('conf.php');
session_start();
if(!isset($_SESSION["tuvastamine"])){
    header("Location:login.php");
    exit();
}

global $yhendus;
if(isset($_REQUEST['punkt'])) {
    $kask = $yhendus->prepare("UPDATE konkurs SET punktid=punktid+1 WHERE id = ?");
    $kask->bind_param('i', $_REQUEST['punkt']);
    $kask->execute();
    header("location:$_SERVER[PHP_SELF]");
}
if(isset($_REQUEST['uus_komment'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET kommentarid=CONCAT(kommentarid,?) WHERE id = ?");
    $kommentlisa=$_REQUEST['komment']."\n";
    $kask -> bind_param('si',$kommentlisa,$_REQUEST['uus_komment']);
    $kask -> execute();
    header("location:$_SERVER[PHP_SELF]");
}
?>
<!DOCTYPE html>

<html lang="et">
<head>
    <meta charset="UTF-8">


    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<head>
    <title>FOTO Konkurs</title>
</head>
<body>
<div>
    <p><?=$_SESSION['kasutaja']?> on sisse logitud</p>
    <form action="logout.php" method="post">
        <input type="submit" value="Logi valja" name="logout">
    </form>
</div>
<nav>
<?php
    if ($_SESSION['onAdmin']==1){
    echo '<a href="haldus.php">Admin Leht</a>
    <a href="lisamine.php">Lisamis Leht</a>';
    
    }
    
    ?>
    <a href="konkurs.php">Kasutaja Leht</a>
    <a href="https://github.com/nikolaiGrigorjev/foto/tree/main/Konkurs" target="_blank">Github</a>
</nav>

    <h1>Fotokunkurs "Joker"</h1>
<?php
//tabeli konkursi sisu naitamine
$kask=$yhendus->prepare("SELECT id,nimi,kommentarid,pilt,punktid FROM konkurs WHERE avalik=1");
$kask->bind_result($id,$nimi,$kommentarid,$pilt,$punktid);
$kask->execute();

echo "<table>";
    if ($_SESSION["onAdmin"]==0){
        echo "<tr>
        
        <th>Nimi</th>
        <th>Pilt</th>
        <th>Kommentaarid</th>
        <th>Lisa komment</th>
        <th>Punktikd</th>
        <th>Tegevused</th>
        </tr>";
    }else{
        echo "<tr>
        
        <th>Nimi</th>
        <th>Pilt</th>
        <th>Kommentaarid</th>
        <th>Punktikd</th>
        </tr>";
    }
while($kask->fetch()){
        echo "<tr>";
        
        echo "<td>$nimi</td>";
        echo "<td><img src='$pilt' alt='pilt'></td>";
        echo "<td>".nl2br($kommentarid)."</td>";
        if ($_SESSION["onAdmin"]==0){
            echo "<td>
        <form action='?'>
            <input type='hidden' name='uus_komment' value='$id'>
            <input type='text' name='komment'>
            <input type='submit' value='OK'>
        </form>
        </td>";
        }

        echo "<td>$punktid</td>";
        if ($_SESSION["onAdmin"]==0){
            echo "<td><a href='?punkt=$id'>Lisa punkt</a></td>";
        }
        echo "</tr>";
    }
    echo "</table>"

?>
</body>
</html>