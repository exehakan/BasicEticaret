<?php
try{
    $db = new PDO("mysql:dbname=exehakan;host=localhost;charset=utf8","root","");
}catch (PDOException  $hatalar){
    echo $hatalar->getMessage();
}

if(trim($_GET["Kelime"]) != "" and $_GET["KelimeOkunusu"] != "" and $_GET["KelimeAnlami"] != ""){
    $GelenKelime = trim($_GET["Kelime"]);
    $KelimeninSayisi = strlen($GelenKelime);
    $KelimeninIngilizceOlarakTamYazilisi = trim($_GET["KelimeOkunusu"]);
    $KelimeninTurkceAnlami = trim($_GET["KelimeAnlami"]);
    $bosDegisken = "";

    if($KelimeninSayisi<=3){
        $islem = str_split($GelenKelime,1);
        foreach($islem as $kelimeler)
            $bosDegisken .= $kelimeler . " ";
    }else{
        if($KelimeninSayisi %2 == 0){
            $GelenKelimeIslemi = str_split($GelenKelime,2);
            foreach($GelenKelimeIslemi as $kelimeler){
                $bosDegisken .= trim($kelimeler) . " ";
            }
        }elseif($KelimeninSayisi %2 !== 0){
            $BirinciKarakteriYakala = substr($GelenKelime,0,1);
            $DigerKalanKelimeleriBul = substr($GelenKelime,strlen($BirinciKarakteriYakala),$KelimeninSayisi);
            $ArtıkBulduklariniParcala = str_split($DigerKalanKelimeleriBul,2);
            $bosDegisken.=$BirinciKarakteriYakala . " ";
            foreach($ArtıkBulduklariniParcala as $kelimeler){
                $Sonuc		=	iconv("UTF-8", "ISO-8859-9", $kelimeler);
                $bosDegisken .= $Sonuc . " ";
            }
        }
    }


    $Sorgu = $db->prepare("SELECT * FROM ingilizce WHERE ingilizceKelimeParcali LIKE ?");
    $Sorgu->execute([$bosDegisken]);
    $Sorguislemi = $Sorgu->rowCount();
    $sonuclar = $Sorgu->fetch(PDO::FETCH_ASSOC);
    if($Sorguislemi>0){
        echo "Üzgümün bu kelime daha önceden eklenmiş";
    }else{
        $ekle = $db->prepare("INSERT INTO ingilizce(ingilizceKelimeParcali, ingilizceKelimeorjinal, ingilizceKelimeAnlami) values(?,?,?)");
        $ekle->execute([$bosDegisken,$KelimeninIngilizceOlarakTamYazilisi,$KelimeninTurkceAnlami]);
        $ekleSonuclari = $ekle->rowCount();
        if($ekleSonuclari>0){
            echo "Başariyla Kayitlar Eklendi <br/>";
            header("Location: index.php");
        }else{
            echo "Kayitlar Başarisiz.";
        }

    }






























    /*
    */














}
