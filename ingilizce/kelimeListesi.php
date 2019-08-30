<?php
try{
    $db = new PDO("mysql:dbname=exehakan;host=localhost;charset=utf8","root","");
}catch (PDOException  $hatalar){
    echo $hatalar->getMessage();
}

    $sonuclar = "";
    $getir = $db->prepare("SELECT * FROM ingilizce ORDER BY id ASC");
    $getir->execute();
    $Sonuclar = $getir->fetchAll(PDO::FETCH_ASSOC);
    foreach($Sonuclar as $kayitlar){
       echo str_repeat($kayitlar["ingilizceKelimeParcali"] . " . ".$kayitlar["ingilizceKelimeorjinal"] ." . ".$kayitlar["ingilizceKelimeAnlami"] . ".<br/>",10);

    }

?>
<!doctype html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>



</body>
</html>


