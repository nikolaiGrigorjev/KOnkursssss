<?php
require_once('conf.php');
session_start();
if(!isset($_SESSION["tuvastamine"])){
    header('Location:login.php');
    exit();
}
global $yhendus;
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET punktid=punktid=0 WHERE id = ?");
    $kask -> bind_param('i',$_REQUEST['punkt']);
    $kask -> execute();
    header("location:$_SERVER[PHP_SELF]");
}

if(isset($_REQUEST['avamine'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET avalik=1 WHERE id = ?");
    $kask -> bind_param('i',$_REQUEST['avamine']);
    $kask -> execute();

}
if(isset($_REQUEST['peitmine'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET avalik=0 WHERE id = ?");
    $kask -> bind_param('i',$_REQUEST['peitmine']);
    $kask -> execute();

}

if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare(" DELETE FROM konkurs WHERE id = ?");
    $kask -> bind_param('i',$_REQUEST['kustuta']);
    $kask -> execute();

}

?>
<!DOCTYPE html>

<html lang="et">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<head>
    <title>FOTOKonkursi haldusleht </title>
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
$kask=$yhendus->prepare("SELECT id, nimi , pilt, lisamisaeeg, punktid,avalik FROM konkurs");
$kask->bind_result($id,$nimi,$pilt,$aeg,$punktid,$avalik);
$kask->execute();
echo "<table>";
echo "<tr><td>Nimi</td><td>Pilt</td><td>Lisamisaeg</td><td>Punkti</td></tr>";


while ($kask->fetch()){
    $avatekst="Ava";
    $param="avamine";
    $seisund="Peitatud";
    if($avalik==1){
        $avatekst="Peida";
        $param="peitmine";
        $seisund="Avatud";
    }

    echo "<tr><td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'></td>";
    echo "<td>$aeg</td>";



    echo "<td>$punktid</td>";
    echo "<td><a href ='?punkt=$id'>xxx</a></td>";


    $ask ='"Continue"';

    echo "<td>$seisund</td>";
    echo "<td><a href='?$param=$id'>$avatekst</a></td>";
    echo "<td><a href='?kustuta=$id' onClick='return confirm($ask);'>Kustuta</a></td>";
    echo"</tr>";

}
?>



</form>
</body>
</html>

