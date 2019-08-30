<?php
global $veritabani;
    if(isset($_SESSION["Yonetici"])){
        ?>
        <div class="YoneticiSayfasiSayfalarKapsamaAlani">
            <div class="YoneticiSayfasiSayfalarBasligi">
                Site Ayarlari
                <a href="index.php?SKD=0&SKI=10" olay="BankaKartiEkle(this)" animasyon="evet" class="SiteAyarlariSagTarafYeniKrediKartiEkle">Yeni Banka Hesabi Ekle</a>
            </div>
            <div class="YoneticiSayfasiSayfaIcerikleri" olay="$(this).css('border','none')" animasyon="evet">
                <?php
                    $BankaHesaplariSorgusu = $veritabani->prepare("SELECT * FROM bankahesaplarimiz ORDER BY BankaAdi ASC");
                    $BankaHesaplariSorgusu->execute();
                    $BankaHesaplariSorgusuSayisi = $BankaHesaplariSorgusu->rowCount();
                    $BankaKayitlari = $BankaHesaplariSorgusu->fetchAll(PDO::FETCH_ASSOC);
                foreach($BankaKayitlari as $Kayitlar){
                    ?>
                <div class="BankaHesaplariKapsamaAlani">
                <div class="BankaHesaplariSinirlamaAlani">
                    <div class="BankaHesaplariKutuModeliAlani">


                        <div class="BankaHesaplariSolLogoAltMenulerAlanlariAlani">
                            <div class="BankaLogoAlani">
                                <img src="../Resimler/<?php echo $Kayitlar["BankaLogosu"]?>.png" alt="">
                            </div>
                            <div class="BankaAltMenuAlani">
                                <ul class="BankaMenuleri">
                                    <a href="index.php?SKD=0&SKI=14&ID=<?php echo $Kayitlar["id"]?>"><li class="BankaMenu"><img src="../Resimler/Guncelleme20x20.png" alt="">Güncelle</li></a>
                                    <a href="index.php?SKD=0&SKI=18&ID=<?php echo $Kayitlar["id"]?>"><li class="BankaMenu"><img src="../Resimler/Sil20x20.png" alt="">Sil</li></a>
                                </ul>
                            </div>
                        </div>

                        <div class="BankaHesaplariSagBilgilerAlani">
                            <ul class="BankaKartVeyaHesapBilgileri">
                                <li class="KartBilgileri">Banka Adi:&nbsp;&nbsp;<?php echo $Kayitlar["BankaAdi"]?></li>
                                <li class="KartBilgileri">Hesap Sahibi:&nbsp;&nbsp;<?php echo $Kayitlar["HesapSahibi"]?></li>
                                <li class="KartBilgileri">Şube ve Konum Bilgileri:&nbsp;&nbsp;<?php echo $Kayitlar["konumSehir"] . " -- " . $Kayitlar["SubeAdi"] . " - " . $Kayitlar["SubeKodu"]  ?></li>
                                <li class="KartBilgileri">Hesap Bilgileri:&nbsp;&nbsp;TL/<?php echo $Kayitlar["HesapNumarasi"]?> /  <?php echo $Kayitlar["IbanNumarasi"]?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!-- BankaHesaplariKapsamaAlani END -->

            <?php } ?>
            </div>
        </div>
        <?php }?>