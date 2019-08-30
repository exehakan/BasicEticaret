<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    $SayfalamaKosulu = "";
    $SayfalamaIcinSagveSolButonSayisi = 2;
    $SayfaBasinaGosterilecekKayitSayisi = 10;
    $ToplamKayitSayisiSorgusu = $veritabani->prepare("SELECT * FROM yorumlar order by id DESC ");
    $ToplamKayitSayisiSorgusu->execute();
    $ToplamKayitSayisi = $ToplamKayitSayisiSorgusu->rowCount();
    $SayfalamayaBaslanacakKayitSayisi = ($Sayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
    $BulunanSayfaSayisi = ceil($ToplamKayitSayisi / $SayfaBasinaGosterilecekKayitSayisi);



    ?>

        <div class="YoneticiSayfasiSayfalarKapsamaAlani" >
            <div class="YoneticiSayfasiSayfalarBasligi">Yorumlar</div>
            <div class="YoneticiSayfasiSayfaIcerikleri" style="border: none">
                <div class="YorumSayfasiKapsamaAlani">
                <?php
                    $Yorumlarsorgusu = $veritabani->prepare("SELECT * FROM yorumlar ORDER BY id DESC LIMIT $SayfalamayaBaslanacakKayitSayisi,$SayfaBasinaGosterilecekKayitSayisi");
                    $Yorumlarsorgusu->execute([0]);
                    $YorumlarsorgusuSayisi = $Yorumlarsorgusu->rowCount();
                    $YorumlarsorgusuKaydi = $Yorumlarsorgusu->fetchAll(PDO::FETCH_ASSOC);

                    if($YorumlarsorgusuSayisi>0) {
                        foreach($YorumlarsorgusuKaydi as $Kayitlar){
                            if(DonusumleriGeriDondur($Kayitlar["Puan"]) == 1){
                                $PuanResmi = "YildizBirDolu.png";
                            }elseif(DonusumleriGeriDondur($Kayitlar["Puan"]) == 2){
                                $PuanResmi = "YildizIkiDolu.png";
                            }elseif(DonusumleriGeriDondur($Kayitlar["Puan"]) == 3){
                                $PuanResmi = "YildizUcDolu.png";
                            }elseif(DonusumleriGeriDondur($Kayitlar["Puan"]) == 4){
                                $PuanResmi = "YildizDortDolu.png";
                            }elseif(DonusumleriGeriDondur($Kayitlar["Puan"]) == 5){
                                $PuanResmi = "YildizBesDolu.png";
                            }


                            ?>
                            <div class="YorumlarAlani">
                                <div class="YorumMetinAlani area" data-simplebar ><?php echo $Kayitlar["YorumMetini"]?></div>
                                <div class="YorumMetniniSilAlani"><a href="index.php?SKD=0&SKI=91&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Sil20x20.png" alt="">Sil</a></div>
                               <div class="YorumPuanlamaAlani">
                                   <img src="../Resimler/<?php echo $PuanResmi ?>" alt="">
                               </div>
                           </div>
                    <?php } } ?>
                        </div>

            </div>
            <?php
            if($BulunanSayfaSayisi>1){
                ?>
                <div class="SayfalamaKapsamaAlani">
                    <div class="SayfalamaAlaniIciNumaraAlaniKapsayicisi">
                        <ul class="SayfalamaSinirlamaAlani">
                            <?php

                            if($Sayfalama>1){
                                $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=90{$SayfalamaKosulu}&SYF=1'><li class=\"Sayfalama\">&lt;&lt;</li></a>");
                                $SayfalamaIcinSayfaDegeriniBirGeriAl = $Sayfalama-1;
                                $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=90&{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaDegeriniBirGeriAl}'><li class=\"Sayfalama\">&lt;</li></a>");
                            }

                            for($SayfalamaIcinSayfaIndexDegeri=$Sayfalama-$SayfalamaIcinSagveSolButonSayisi;$SayfalamaIcinSayfaIndexDegeri<=$Sayfalama+$SayfalamaIcinSagveSolButonSayisi;$SayfalamaIcinSayfaIndexDegeri++){
                                if($SayfalamaIcinSayfaIndexDegeri>0 and $SayfalamaIcinSayfaIndexDegeri<=$BulunanSayfaSayisi){
                                    if($Sayfalama==$SayfalamaIcinSayfaIndexDegeri){
                                        $e->HTMLYazdir("<li class='Sayfalama SayfalamaPasif'>$SayfalamaIcinSayfaIndexDegeri</li>");
                                    }else{
                                        $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=90{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaIndexDegeri}'><li class=\"Sayfalama \">{$SayfalamaIcinSayfaIndexDegeri}</li></a>");
                                    }
                                }
                            }


                            if($Sayfalama!=$BulunanSayfaSayisi){
                                $SayfalamaIcinSayfaDegeriniBirIleriAl = $Sayfalama+1;
                                $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=90&{$SayfalamaKosulu}&SYF={$SayfalamaIcinSayfaDegeriniBirIleriAl}'><li class=\"Sayfalama\">&gt;</li></a>");

                                $e->HTMLYazdir("<a href='index.php?SKD=0&SKI=90{$SayfalamaKosulu}&SYF={$BulunanSayfaSayisi}'><li class=\"Sayfalama\">&gt;&gt;</li></a>");
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

    <?php
}else{
    yonlendir("index.php?SKD=0");
}
?>