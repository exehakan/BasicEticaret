<?php
if($e->setEdilmisIseGET("MenuID")){
    $GelenMenuID = $e->GetVeyaPOST("MenuID");
    $MenuKosulu = " AND MenuId = '" .$GelenMenuID. "' ";
    $SayfalamaKosulu = "&MenuID=".$GelenMenuID;
}else{
    $GelenMenuID = "";
    $MenuKosulu = "";
    $SayfalamaKosulu = "";
}

if(isset($_REQUEST["AramaIcerigi"])){
    $GelenAramaIcerigi   =  $_REQUEST["AramaIcerigi"];
    $AramaKosulu         =  " AND UrunAdi LIKE '%" . $GelenAramaIcerigi ."%' ";
    $SayfalamaKosulu    .=  "&AramaIcerigi=".$GelenAramaIcerigi;

}else{
    $AramaKosulu = "";
    $SayfalamaKosulu .= "";
}

$SayfalamaIcinSagveSolButonSayisi = 2;
$SayfaBasinaGosterilecekKayitSayisi = 8;
$ToplamKayitSayisiSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE UrunTuru = 'Cocuk Ayakkabısı' AND Durumu = '1' $MenuKosulu $AramaKosulu ORDER BY id DESC");
$ToplamKayitSayisiSorgusu->execute();
$ToplamKayitSayisi = $ToplamKayitSayisiSorgusu->rowCount();
$SayfalamayaBaslanacakKayitSayisi = ($Sayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
$BulunanSayfaSayisi = ceil($ToplamKayitSayisi / $SayfaBasinaGosterilecekKayitSayisi);

$AnaMenununTumUrunSayisiSorgusu = $veritabani->prepare("SELECT SUM(UrunSayisi) AS MenununToplamUrunu FROM menuler WHERE UrunTuru = 'Cocuk Ayakkabısı'");
$AnaMenununTumUrunSayisiSorgusu->execute();
$AnaMenununTumUrunSayisiSorgusuSayisi = $AnaMenununTumUrunSayisiSorgusu->rowCount();
$AnaMenununTumUrunSayisiSorgusuKayitlari = $AnaMenununTumUrunSayisiSorgusu->fetch(PDO::FETCH_ASSOC);

?>

<div class="AnaSayfaIcerik GirisSayfasi">
    <div class="KompleSolAlan">
        <div class="AnaSayfaSolMenulerAlani">
            <div class="AnaSayfaSolMenuBaslikAlani">Menüler</div>
            <ul class="AnaSayfaSolMenulerSinirlamaAlani">
                <a href="index.php?SK=85"><li class="AnaSayfaSolMenuler">Tüm Ürünler(<?php echo $AnaMenununTumUrunSayisiSorgusuKayitlari["MenununToplamUrunu"]; ?>)</li></a>
                <?php
                $MenulerSorgusu = $veritabani->prepare("SELECT * FROM menuler WHERE UrunTuru='Cocuk Ayakkabısı' ORDER BY MenuAdi ASC");
                $MenulerSorgusu->execute();
                $MenulerKayitSayisi = $MenulerSorgusu->rowCount();
                $MenulerSorgusuKayitlari = $MenulerSorgusu->fetchAll(PDO::FETCH_ASSOC);

                foreach($MenulerSorgusuKayitlari as $Menu){

                    ?><a style="<?php if($GelenMenuID == $Menu["id"]){ ?> color: tomato;  <?php } ?>"
                         href="index.php?SK=85&MenuID=<?php echo $Menu["id"] ?>">
                    <li class="AnaSayfaSolMenuler">
                        <?php echo $Menu["MenuAdi"] ?>(<?php $e->yazdir($Menu["UrunSayisi"])?>)
                    </li>
                    </a><?php
                }

                ?>

            </ul>
        </div>

        <div class="ReklamlarSolKapsamaAlani">
            <?php
            $BannerSorgusu = $veritabani->prepare("SELECT * FROM bannerlar WHERE BannerAlani = 'Menu Altı' ORDER BY GosterimSayisi ASC LIMIT 1");
            $BannerSorgusu->execute();
            $BannerSayisi = $BannerSorgusu->rowCount();
            $BannerKayitlari = $BannerSorgusu->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="ReklamBasligi">REKLAMLAR</div>
            <div class="ReklamResimYoluVeBilgileri">
                <img src="Resimler/Banner/<?php $e->yazdir($BannerKayitlari["BannerResmi"])?>" alt="">
            </div>

            <?php
            $BannerlariGuncelle = $veritabani->prepare("UPDATE bannerlar SET GosterimSayisi=GosterimSayisi+1 WHERE id=? limit 1");
            $BannerlariGuncelle->execute([$BannerKayitlari["id"]]);
            ?>

        </div>

    </div><!-- KompleSolAlan END>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>-->

    <div class="AnaSayfaUrunlerAlani">
        <div class="UrunAramaAlani">
            <form action="index.php?SK=85" method="post">

                <?php
                if($e->Bosdegilise($GelenMenuID)){
                    $e->HTMLYazdir("<input name='MenuID'  type='hidden' value='{$GelenMenuID}'>");
                }else{
                    $GelenMenuID = "";
                }
                ?>

                <div class="FormInputAramaAlani">
                    <input type="text" class="AramaAlaniInputu" name="AramaIcerigi">
                </div>
                <div class="FormGonderButtonu">
                    <input type="submit" value="" class="AramaAlaniButtonu">
                </div>

            </form>
        </div>


        <ul class="AnaSayfaUrunlerAlaniSinirlama">


            <?php
            $urunlerSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE UrunTuru = 'Cocuk Ayakkabısı' AND Durumu = '1' $MenuKosulu $AramaKosulu ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi,$SayfaBasinaGosterilecekKayitSayisi");
            $urunlerSorgusu->execute();
            $urunSayisi = $urunlerSorgusu->rowCount();
            $urunKayitlari = $urunlerSorgusu->fetchAll(PDO::FETCH_ASSOC);
            foreach ($urunKayitlari as $Urunler){
                $urununFiyati = $Urunler["UrunFiyati"];
                $urununParaBirimi = $Urunler["ParaBirimi"];
                if($urununParaBirimi == "USD"){
                    $urunFiyatiHesapla = $urununFiyati*$DolarKuru;
                }elseif($urununParaBirimi == "Euro"){
                    $urunFiyatiHesapla = $urununFiyati*$EuroKuru;
                }else{
                    $urunFiyatiHesapla = $urununFiyati;
                }

                $urununToplamYorumSayisi = DonusumleriGeriDondur($Urunler["YorumSayisi"]);
                $urununToplamYorumPuani  = DonusumleriGeriDondur($Urunler["ToplamYorumPuani"]);


                if($urununToplamYorumSayisi>0){
                    $PuanHesapla = $e->sayiBicimlendir($urununToplamYorumPuani/$urununToplamYorumSayisi,2,".","");
                }else{
                    $PuanHesapla = 0;
                }

                if($PuanHesapla == 0){
                    $PuanResmi = "YildizCizgiliBos.png";
                }elseif($PuanHesapla > 0 and $PuanHesapla <=1){
                    $PuanResmi = "YildizCizgiliBirDolu.png";
                }elseif($PuanHesapla >1 and $PuanHesapla <=2){
                    $PuanResmi = "YildizCizgiliIkiDolu.png";
                }elseif($PuanHesapla > 2 and $PuanHesapla <=3){
                    $PuanResmi = "YildizCizgiliUcDolu.png";
                }elseif($PuanHesapla > 3 and $PuanHesapla <=4){
                    $PuanResmi = "YildizCizgiliDortDolu.png";
                }elseif($PuanHesapla > 4 and $PuanHesapla <=5){
                    $PuanResmi = "YildizCizgiliBesDolu.png";
                }

                ?>

                <!-- ÜRÜN ALANİ START >>>>>>>>>>>>>>>-->
                <li class="AnaSayfaUrunlerAlaniUrunKutulari">
                    <div class="UrunResimi">
                        <a href="index.php?SK=82&ID=<?php $e->yazdir($Urunler["id"]); ?>">
                            <img src="Resimler/UrunResimleri/Erkek/<?php $e->yazdir(DonusumleriGeriDondur($Urunler["UrunResmiBir"]))?>">
                        </a>
                    </div>
                    <a href="index.php?SK=82&ID=<?php $e->yazdir($Urunler["id"]); ?>">
                        <span class="UrunBaslik"><?php $e->yazdir($Urunler["UrunAdi"])?></span>
                    </a>
                    <a href="index.php?SK=82&ID=<?php $e->yazdir($Urunler["id"]); ?>">
                        <span class="UrunMetini"><?php $e->yazdir($Urunler["UrunAciklamasi"])?></span>
                    </a>
                    <a href="index.php?SK=82&ID=<?php $e->yazdir($Urunler["id"]); ?>"><div class="UrunPuanlamasi">
                            <img src="Resimler/<?php $e->yazdir($PuanResmi)?>" alt="">
                        </div></a>
                    <a href="index.php?SK=82&ID=<?php $e->yazdir($Urunler["id"]); ?>"><div class="UrunFiyati"><?php $e->YukariYuvarla($urunFiyatiHesapla); ?>&nbsp;TL</div></a>
                </li>
                <!-- ÜRÜN ALANİ END<<<<<<<<<<<<<<<<<<<<<<-->
            <?php } ?>
        </ul>
        <?php
        if($BulunanSayfaSayisi>1){
            ?>
            <div class="SayfalamaKapsamaAlani">
                <div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
                    <ul class="SayfalamaSinirlamaAlani">
                        <?php

                        if($Sayfalama>1){
                            $e->HTMLYazdir("<a href='index.php?SK=85{$SayfalamaKosulu}&SYF=1'><li class=\"Sayfalama\">&lt;&lt;</li></a>");
                            $SayfalamaIcinSayfaDegeriniBirGeriAl = $Sayfalama-1;
                            $e->HTMLYazdir("<a href='index.php?SK=85&{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaDegeriniBirGeriAl}'><li class=\"Sayfalama\">&lt;</li></a>");
                        }

                        for($SayfalamaIcinSayfaIndexDegeri=$Sayfalama-$SayfalamaIcinSagveSolButonSayisi;$SayfalamaIcinSayfaIndexDegeri<=$Sayfalama+$SayfalamaIcinSagveSolButonSayisi;$SayfalamaIcinSayfaIndexDegeri++){
                            if($SayfalamaIcinSayfaIndexDegeri>0 and $SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi){
                                if($Sayfalama==$SayfalamaIcinSayfaIndexDegeri){
                                    $e->HTMLYazdir("<li class='Sayfalama SayfalamaPasif'>$SayfalamaIcinSayfaIndexDegeri</li>");
                                }else{
                                    $e->HTMLYazdir("<a href='index.php?SK=85{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaIndexDegeri}'><li class=\"Sayfalama \">{$SayfalamaIcinSayfaIndexDegeri}</li></a>");
                                }
                            }
                        }


                        if($Sayfalama!=$BulunanSayfaSayisi){

                            $SayfalamaIcinSayfaDegeriniBirIleriAl = $Sayfalama+1;

                            $e->HTMLYazdir("<a href='index.php?SK=85&{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaDegeriniBirIleriAl}'><li class=\"Sayfalama\">&gt;</li></a>");


                            $e->HTMLYazdir("<a href='index.php?SK=85{$SayfalamaKosulu}&SYF={$BulunanSayfaSayisi}'><li class=\"Sayfalama\">&gt;&gt;</li></a>");

                        }

                        ?>
                    </ul>
                </div>
            </div>

            <?php
        }else{
            $e->yazdir("Bu sayfada bulunan kayit sayisi {$ToplamKayitSayisi}");
        }
        ?>
    </div>
</div>