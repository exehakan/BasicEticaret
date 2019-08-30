<?php
//require_once "Config/fonksiyonlar.php";
if(isset($_POST["TakipNumarasi"])){
    $GelenKargoTakipNumarasi = SayiliIcerikleriFilitrele($_POST["TakipNumarasi"]);

}else{
    $GelenKargoTakipNumarasi = "";
}

if($GelenKargoTakipNumarasi!=""){
    header("Location:https://www.yurticikargo.com/tr/online-servisler/gonderi-sorgula?code=".$GelenKargoTakipNumarasi);
}else{
    yonlendir("index.php?SK=14");
}

?>