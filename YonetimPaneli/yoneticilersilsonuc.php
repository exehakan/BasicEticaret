<?php
global $veritabani;
global $YoneticiKullaniciAdi;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }
    if($GelenID != ""){
        //Burada mantıken yönetici yönetici panelindeyken herhangi bir yöneticiyi silemez. Eğer ancak illa bir yönetici silmek istiyor ise kendisini silebilir.
        $sil = $veritabani->prepare("DELETE FROM yoneticiler WHERE id = ? AND KullaniciAdi = ? AND SilinmeyecekYoneticiDurumu = ? LIMIT 1");
        $sil->execute([$GelenID,$YoneticiKullaniciAdi,0]);
        $SilCount = $sil->rowCount();
        if($SilCount>0){
            yonlendir("index.php?SKD=0&SKI=80");
        }else{
            yonlendir("index.php?SKD=0&SKI=81");
        }
    }else{
        yonlendir("index.php?SKD=0&SKI=81");
    }
}else{
    yonlendir("index.php?SKD=1");
}

?>