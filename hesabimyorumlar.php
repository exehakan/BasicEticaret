<?php
    if(isset($_SESSION["Kullanici"])){
        $SayfalamaIcinSolveSagButtonSayisi = 2;
        $SayfaBasinaGosterilecekKayitSayisi = 10;
        $ToplamKayitSorgusu = $veritabani->prepare("SELECT * FROM yorumlar WHERE UyeId=? ORDER BY YorumTarihi DESC");
        $ToplamKayitSorgusu->execute([$KullaniciID]);
        $ToplamKayitSorgusu = $ToplamKayitSorgusu->rowCount();
        $SayfalamayaBaslanacakKayitSayisi = ($Sayfalama * $SayfaBasinaGosterilecekKayitSayisi) - $SayfaBasinaGosterilecekKayitSayisi;
        $BulunanSayfaSayisi = ceil($ToplamKayitSorgusu/$SayfaBasinaGosterilecekKayitSayisi);

?>
<div  class="HesabimSayfasiUstMenu">
    <ul class="UstMenuKapsamaAlani">
        <a href="index.php?SK=50"><li class="UstMenuler">Üyelik Bilgilerim</li></a>
        <a href="index.php?SK=58"><li class="UstMenuler">Adresler</li></a>
        <a href="index.php?SK=59"><li class="UstMenuler">Favoriler</li></a>
        <a href="index.php?SK=60"><li class="UstMenuler">Yorumlar</li></a>
        <a href="index.php?SK=61"><li class="UstMenuler">Siparişler</li></a>
    </ul>
</div>
<div class="AnaSayfaSectionBaslik">Hesabim > Siparişler</div>
<div class="AnaSayfaIcerik">
    <table width="100%" cellspacing="2"  cellpadding="0" border="0" bgcolor="#0a3d62">
        <tr bgcolor="#218c74">
            <th class="TabloBaslikDuzenlemesi">Puan</th>
            <th class="TabloBaslikDuzenlemesi">Ürün Yorumlari</th>
        </tr>

    <?php
        $YorumlarSorgusu = $veritabani->prepare("SELECT * FROM yorumlar WHERE UyeId=? ORDER BY YorumTarihi DESC  LIMIT $SayfalamayaBaslanacakKayitSayisi,$SayfaBasinaGosterilecekKayitSayisi");
        $YorumlarSorgusu->execute([$KullaniciID]);
        $YorumlarSorgusuEtkilenen = $YorumlarSorgusu->rowCount();
        $YorumlarSorgusuKayitlar = $YorumlarSorgusu->fetchAll(PDO::FETCH_ASSOC);
        if($YorumlarSorgusuEtkilenen>0){
            foreach($YorumlarSorgusuKayitlar as $Kayitlar){
                $YorumPuani = $Kayitlar["Puan"];
                if($YorumPuani == 1){
                    $YorumPuaniResimi = "YildizBirDolu.png";
                }elseif($YorumPuani == 2){
                    $YorumPuaniResimi = "YildizIkiDolu.png";
                }elseif($YorumPuani == 3){
                    $YorumPuaniResimi = "YildizUcDolu.png";
                }elseif($YorumPuani == 4){
                    $YorumPuaniResimi = "YildizDortDolu.png";
                }elseif($YorumPuani == 5){
                    $YorumPuaniResimi = "YildizBesDolu.png";
                }else{
                    echo "Puan Değeri Bulunamadi";
                }

    ?>
        <tr>
            <td class="TabloIcerikDuzenlemesi"><img src="Resimler/<?php echo $YorumPuaniResimi?>" alt=""></td>
            <td class="TabloIcerikDuzenlemesi"><?php echo  DonusumleriGeriDondur($Kayitlar["YorumMetini"]) ?></td>
        </tr>
        <?php
            }
        }
        if($BulunanSayfaSayisi>1){
            ?>
    </table>
            <div class="SayfalamaKapsamaAlani">
                <ul class="SayfalamaSinirlamaAlani">
                    <?php
                    if($Sayfalama>1){
                        echo "<a href='index.php?SK=60&SYF=1'><li class=\"Sayfalama\">&lt;&lt;</li></a>";
                        $SayfalamaIcinSayfaDegeriniBirGeriAl = $Sayfalama-1;
                        echo "<a href='index.php?SK=60&SYF={$SayfalamaIcinSayfaDegeriniBirGeriAl}'><li class=\"Sayfalama\">&lt;</li></a>";
                    }


                    for ($SayfalamaIcinIndexDegeri = $Sayfalama-$SayfalamaIcinSolveSagButtonSayisi;$SayfalamaIcinIndexDegeri<=$Sayfalama+$SayfalamaIcinSolveSagButtonSayisi;$SayfalamaIcinIndexDegeri++){
                        if(($SayfalamaIcinIndexDegeri>0) and ($SayfalamaIcinIndexDegeri <= $BulunanSayfaSayisi)){
                            if($Sayfalama==$SayfalamaIcinIndexDegeri){
                                echo "<li class=\"Sayfalama SayfalamaPasif\">{$SayfalamaIcinIndexDegeri}</li>";
                            }else{
                                echo "<a href='index.php?SK=60&SYF={$SayfalamaIcinIndexDegeri}'><li class=\"Sayfalama\">{$SayfalamaIcinIndexDegeri}</li></a>";
                            }
                        }
                    }
                    if($Sayfalama != $BulunanSayfaSayisi){
                        $SayfalamaIcinSayfaDegeriniBirIleriAl = $Sayfalama+1;
                        echo "<a href='index.php?SK=60&SYF={$SayfalamaIcinSayfaDegeriniBirIleriAl}'><li class=\"Sayfalama\">&gt;</li></a>";
                        echo "<a href='index.php?SK=60&SYF={$BulunanSayfaSayisi}'><li class=\"Sayfalama\">&gt;&gt;</li></a>";
                    }
                    ?>
                </ul>
            </div>

            Toplam <?php echo $BulunanSayfaSayisi. " Sayfada " . $ToplamKayitSorgusu . " Kayit"?>


            <?php
        }
    ?>




<?php
    }else{
      yonlendir("index.php");
    }
?>
</div>









