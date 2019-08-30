<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){ ?>
    <div class="YoneticiSayfasiSayfalarKapsamaAlani">
        <div class="YoneticiSayfasiSayfalarBasligi">
            Destek İçerikleri
            <a href="index.php?SKD=0&SKI=46" olay="BankaKartiEkle(this)" animasyon="evet" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Yeni Destek İçeriği Ekle</a>
        </div>
        <div class="YoneticiSayfasiSayfaIcerikleri">
        <?php
            $DestekSorgusu = $veritabani->prepare("SELECT * FROM sorular ORDER BY soru ASC");
            $DestekSorgusu->execute();
            $DestekSorgusuSayisi = $DestekSorgusu->rowCount();
            $DestekSorgusuKaydi = $DestekSorgusu->fetchAll(PDO::FETCH_ASSOC);

            if($DestekSorgusuSayisi>0){
               foreach($DestekSorgusuKaydi as $Kayitlar){
                   ?>
                   <div class="DestekIcerikleriAlani" animasyon="OpacityEffect">
                       <div class="DestekIcerikleriMetinAlanlari">
                           <div class="DestekIcerikleriSoruBasligi"><?php echo $Kayitlar["soru"]?></div>
                           <div class="DestekIcerikleriSoruCevabi"><?php echo $Kayitlar["cevap"]?></div>
                           <div class="DestekSagGuncelleveSilAlani">
                               <div class="SagSilAlaniDestek"><a href="index.php?SKD=0&SKI=50&ID=<?php echo $Kayitlar["id"]?>"><img src="../Resimler/Guncelleme20x20.png" alt="">Güncelle</a></div>
                               <div class="SagGuncelleAlaniDestek"><a href="index.php?SKD=0&SKI=54&ID=<?php echo $Kayitlar["id"] ?>"><img src="../Resimler/Sil20x20.png" alt="">Sil</a></div>
                           </div>
                       </div>
                   </div>
                   <?php
               }

            } ?>
    </div>

    </div>


<?php } ?>