<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $Gelenid = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $Gelenid = "";
    }


    if($Gelenid !=""){
        $UyeyiAktiflestir = $veritabani->prepare("UPDATE uyeler SET SilinmeDurumu = ? WHERE id = ? LIMIT 1");
        $UyeyiAktiflestir->execute([0,$Gelenid]);
        $UyeyiAktiflestirSayisi = $UyeyiAktiflestir->rowCount();

        if($UyeyiAktiflestirSayisi>0){
            yonlendir("index.php?SKD=0&SKI=88");
        }else{
            yonlendir("index.php?SKD=0&SKI=89");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=89");
    }
}else{
    yonlendir("index.php?SKD=1");
}
?>