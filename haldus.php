<?php
require_once ('conf.php');
global $yhendus;
// punktid nulliks UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET punktid=0 WHERE id=?");
    $kask->bind_param('i', $_REQUEST['punkt']);
    $kask->execute();
    header("location: $_SERVER[PHP_SELF]");
}

//nimi lisamine konkurssi
if(!empty($_REQUEST['nimi'])){
    $kask=$yhendus->prepare("
    INSERT INTO konkurs(nimi, pilt, lisamisaeg)
    VALUES (?,?,NOW())");
    $kask->bind_param('ss',$_REQUEST['nimi'],$_REQUEST['pilt']);
    $kask->execute();
    header("location: $_SERVER[PHP_SELF]");
}
// nimi näitamine avalik=1 UPDATE
if(isset($_REQUEST['avamine'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET avalik=1 WHERE id=?");
    $kask->bind_param('i', $_REQUEST['avamine']);
    $kask->execute();
}
// nimi näitamine avalik=0 UPDATE
if(isset($_REQUEST['peitmine'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET avalik=0 WHERE id=?");
    $kask->bind_param('i', $_REQUEST['peitmine']);
    $kask->execute();
}
// kustutamine
if(isset($_REQUEST['kustuta'])){
    $kask=$yhendus->prepare("DELETE FROM konkurs WHERE id=?");
    $kask->bind_param('i', $_REQUEST['kustuta']);
    $kask->execute();
}
?>
<!DOCTYPE HTML>
<html lang="et">
<head>
    <title>FotoKonkurssi halduseleht</title>
    <link rel="stylesheet" type="text/css" href="css.css">
</head>
<body>
<nav>
    <ul>
        <a href="haldus.php">Administreerimise leht</a>
        <a href="konkurs.php">Kasutaja leht</a>
        <a href="https://github.com/Andreikorsunov?tab=repositories">Github</a>
    </ul>
</nav>
<?php
// tabeli konkurss sisu näitamine
$kask=$yhendus->prepare("SELECT id, nimi, pilt, lisamisaeg, punktid, kommentaar, avalik FROM konkurs");
$kask->bind_result($id, $nimi, $pilt, $lisamisaeg, $punktid, $kommentaar, $avalik);
$kask->execute();
echo "<table><tr><td></td><td></td><td></td><td>Nimi</td><td>Pilt</td><td>LisamisAeg</td><td>Punktid</td><td></td><td>Kommentaar</td></tr>";
while($kask->fetch()){
    // Peida-näita
    $avatekst="Ava";
    $param="avamine";
    $seisund="Peidetud";
    if($avalik==1){
        $avatekst="Peida";
        $param="peitmine";
        $seisund="Avatud";
    }
    echo "<tr><td>$seisund</td>";
    echo "<td><a href='?$param=$id'>$avatekst</a></td>";
    echo "<td><a href='$_SERVER[PHP_SELF]?kustuta=$id'>Kustuta</a></td>";
    echo "<td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'</td>";
    echo "<td>$lisamisaeg</td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>XXX</a></td>";
    echo "<td>$kommentaar</td>";
    echo "</tr>";
}
echo "<table>";
?>
<h2>Uue pilti lisamine konurssi</h2>
<form action="?">
    <input type="text" name="nimi" placeholder="uus nimi">
    <br>
    <textarea name="pilt">Pildi linki aadress</textarea>
    <br>
    <input type="submit" value="Lisa">
</form>
</body>
</html>