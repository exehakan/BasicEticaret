<?php
    if(isset($_SESSION["Kullanici"])){
?>
        <div class="HesabimSayfasiUstMenu">
            <ul class="UstMenuKapsamaAlani">
                <a href="index.php?SK=50"><li class="UstMenuler">Üyelik Bilgilerim</li></a>
                <a href="index.php?SK=58"><li class="UstMenuler">Adresler</li></a>
                <a href="index.php?SK=59"><li class="UstMenuler">Favoriler</li></a>
                <a href="index.php?SK=60"><li class="UstMenuler">Yorumlar</li></a>
                <a href="index.php?SK=61"><li class="UstMenuler">Siparişler</li></a>
            </ul>
        </div>
        <div class="AnaSayfaSectionBaslik">Hesabim > Üyelik Bilgilerim</div>
        <div class="AnaSayfaIcerik">
            <div class="SolHavaleBildirimFormukapsama">
                <div class="BaslikAltiAciklamaSatisi">Kişisel Bilgileriniz Aşadağida Yer Almaktadir.</div>
                <div class="HavaleFormAlani">
                        <div class="FormSatirInputlari">
                            <div style="font-size: 14px;" class="FormMetinBasligi">Email Adresi</div>
                            <div><?php echo $KullaniciEmailAdresi?></div>
                        </div>
                        <!-- $KullaniciSifre Kaldirildi Burdan -->

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">İsim Soyisim</div>
                            <div><?php echo $KullaniciIsimSoyisim?></div>
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Telefon Numarasi</div>
                            <div><?php echo $KullaniciTelefonNumarasi?></div>
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Cinsiyet</div>
                            <div><?php echo $KullaniciCinsiyet?></div>
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Üyelik Aktivasyon Durumu</div>
                            <?php echo UyelikAktivasyonDurumKontrolu($KullaniciDurumu)?>
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Kayit Tarihi</div>
                            <div><?php echo $KullaniciKayitTarihi ?></div>
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Kayitli IP Adresiniz.</div>
                            <div><?php echo $KullaniciKayitIpAdresi ?></div>
                        </div>
                        <div class="HesabimBilgilerimiGuncelle">
                            <a href="index.php?SK=51">Bilgilerimi Güncelle</a>
                        </div>
                </div>
            </div>

            <div class="SagHavaleBildirimFormukapsama">
                <div class="BaslikAltiAciklamaSatisiIsleyis">Reklam Ve Öneri Alanlari.</div>
                <div class="HavaleIsleyisAlani">
                    <img class="reklamResimHesabim" src="./Resimler/resimtanitim.png" alt="">
                </div>
            </div>
        </div>
<?php
    }else{
        yonlendir("index.php");
    }
?>