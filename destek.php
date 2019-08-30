<div class="AnaSayfaSectionBaslik">Sık Sorulan Sorular</div>
<div class="AnaSayfaIcerik">
    <div class="SorularKapsamaAlani"> </div>
    <?php
    $SorularSorgusu = $veritabani->prepare("SELECT * FROM sorular");
    $SorularSorgusu->execute();
    $SorularKayitSayisi = $SorularSorgusu->rowCount();
    $SorularKayitDegerleri = $SorularSorgusu->fetchAll(PDO::FETCH_ASSOC);

    foreach($SorularKayitDegerleri as $SoruKayitlari){?>

    <div class="soru" id="<?php echo $SoruKayitlari["id"]?>" onclick="$.SoruIceriginiGoster(<?php echo $SoruKayitlari["id"]?>)">
        <?php echo $SoruKayitlari["soru"]?>
    </div>

    <div id="A<?php echo $SoruKayitlari["id"]?>" class="cevap">
        <?php echo $SoruKayitlari["cevap"];?>
    </div>

    <?php } ?>


</div>