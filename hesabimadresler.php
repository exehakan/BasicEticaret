<?php
global $KullaniciID;
if(isset($_SESSION["Kullanici"])){
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

    <div class="AnaSayfaSectionBaslik">Hesabim > Adresler</div>
    <div class="AnaSayfaIcerik AdreslerSayfasi">
        <div  class="StandartBaslikAlani">Tüm Adres Bilgilerini Görüntüleyebilir Güncelleyebilirsin</div>
        <?php
        $AdreslerSorgusu = $veritabani->prepare("SELECT * FROM adresler WHERE UyeId = ?");
        $AdreslerSorgusu->execute([$KullaniciID]);
        $AdresKayitlari = $AdreslerSorgusu->fetchAll(PDO::FETCH_ASSOC);
        $EtkilenenKayit = $AdreslerSorgusu->rowCount();
?>

      <div class="AdreslerKapsama">
       <div class="AdreslerSolAlan">
           <div class="AdreslerSolAlanBaslik">Adresler</div>
           <ul class="AdreslerListeleme">
               <?php
               if($EtkilenenKayit>0){
               foreach($AdresKayitlari as $Kayitlar){
                   ?>
                   <li class="AdresDegeleri">
                       <?php echo $Kayitlar["AdiSoyadi"] ?>&nbsp;
                       <?php echo $Kayitlar["Adres"]?>&nbsp;
                       <?php echo $Kayitlar["Ilce"]?> &nbsp; <?php echo $Kayitlar["Sehir"] ?>
                   </li>
               <?php } ?>
           </ul>
       </div>
       <div class="AdreslerSagAlan">
           <div class="AdreslerSagAlanBaslik"><a href="index.php?SK=70">+ Yeni Adres Ekle</a></div>
           <ul class="AdreslerListeleme">
               <?php
                foreach ($AdresKayitlari as $GuncelleKayitlari) {
               ?>
                   <li  class="AdresButtonSecenekleriKolon">

                       <!--<a href="index.php?SK=62&ID=<?php echo $GuncelleKayitlari["id"]?>">
                   <li class="AdresDegeleri AdresSayfasiSagButtonlar">
                       <img src="Resimler/Guncelleme20x20.png" alt="">
                       Güncelle
                   </li>
               </a>-->
                   <a href="index.php?SK=62&ID=<?php echo $GuncelleKayitlari["id"]?>">
                       <img src="Resimler/Guncelleme20x20.png" alt="">
                       <span class="GuncelleSpan">Güncelle</span>
                   </a>

                    <a href="index.php?SK=67&ID=<?php echo $GuncelleKayitlari["id"]?>">
                        <img src="Resimler/Sil20x20.png" alt="">
                        <span class="SilSpan">Sil</span>
                    </a>
                   </li>
               <?php } ?>
               <?php }else{
                 echo "<span style='font-size: 15px'>Üzgünüm Herhangi Bir Adres Kaydi Bulunamadi</span>";
                 echo "<h3><a class='AdresYoksaYeniAdresEkle' href='index.php?SK=70'>Lütfen Adres Eklemek İçin Tıklayiniz.</a></h3>";
               } ?>
           </ul>
       </div>
    </div>
    </div>
<?php

}else{
    yonlendir("index.php");
}
?>