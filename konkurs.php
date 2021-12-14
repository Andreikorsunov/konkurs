<?php
require_once ('conf.php');
global $yhendus;
// punktide lisamine UPDATE
if(isset($_REQUEST['punkt'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET punktid=punktid+1 WHERE id=?");
    $kask->bind_param('i', $_REQUEST['punkt']);
    $kask->execute();
    header("location: $_SERVER[PHP_SELF]");
}
// uue kommentaari lisamine
if(isset($_REQUEST['uus_komment'])){
    $kask=$yhendus->prepare("UPDATE konkurs SET kommentaar=CONCAT(kommentaar, ?) WHERE id=?");
    $kommentaarlisa=$_REQUEST['komment']."\n";
    $kask->bind_param('si', $kommentaarlisa, $_REQUEST['uus_komment']);
    $kask->execute();
    header("location: $_SERVER[PHP_SELF]");
}
?>
<!DOCTYPE HTML>
<html lang="et">
<head>
    <title>FotoKonkurss "Ajalugu"</title>
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
$kask=$yhendus->prepare("SELECT id, nimi, pilt, kommentaar, punktid FROM konkurs WHERE avalik=1");
$kask->bind_result($id, $nimi, $pilt, $kommentaar, $punktid);
$kask->execute();
echo "<table><tr><th>Nimi</th>
<th>Pilt</th>
<th>Kommentaar</th>
<th>Lisa kommentaar</th>
<th>Punktid</th></tr>";
while($kask->fetch()){
    echo "<tr><td>$nimi</td>";
    echo "<td><img src='$pilt' alt='pilt'</td>";
    echo "<td>".nl2br($kommentaar)."</td>";
    echo "<td>
    <form action='?'>
        <input type='hidden' name='uus_komment' value='$id'>
        <input type='text' name='komment'>
        <input type='submit' value='OK'>
    </form></td>";
    echo "<td>$punktid</td>";
    echo "<td><a href='?punkt=$id'>+1punkt</a></td>";
    echo "</tr>";
}
echo "<table>";
?>
</body>
</html>