<?php if($_SESSION["Kullanici"]){?>
    <div  class="HesabimSayfasiUstMenu">
        <ul class="UstMenuKapsamaAlani">
            <a href="index.php?SK=50"><li class="UstMenuler">Üyelik Bilgilerim</li></a>
            <a href="index.php?SK=58"><li class="UstMenuler">Adresler</li></a>
            <a href="index.php?SK=59"><li class="UstMenuler">Favoriler</li></a>
            <a href="index.php?SK=60"><li class="UstMenuler">Yorumlar</li></a>
            <a href="index.php?SK=61"><li class="UstMenuler">Siparişler</li></a>
        </ul>
    </div>
    <div class="AnaSayfaSectionBaslik">Üyelik İşlemleri > Bilgileri Güncelle</div>
    <div class="AnaSayfaIcerik">
    <div class="SolHavaleBildirimFormukapsama">
        <div class="BaslikAltiAciklamaSatisi">Güncel Bilgileriniz Aşağida Yer Almaktadir.</div>
        <div class="HavaleFormAlani">
            <form action="index.php?SK=52" method="POST">
                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">İsim Soyisim</div>
                    <input type="text" name="isimSoyisim" class="InputAlanlari" value="<?php echo $KullaniciIsimSoyisim?>">
                </div>

                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Email Adresiniz</div>
                    <input type="email" name="EmailAdresi"  class="InputAlanlari" id="EmailAdresiKontrol" value="<?php echo  $KullaniciEmailAdresi?>">
                </div>


                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Sifre</div>
                    <input v-bind:type="type"  v-on:focus="InputDurumunuDegistir()" v-on:blur="InputDurumunuGeriDonustur()" name="Sifre" class="InputAlanlari SifreGosterGizle" value="KullaniciSifresi">
                </div>

                </template>
                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Sifre Tekrar</div>
                    <input type="password" v-bind:type="type"  v-on:focus="InputDurumunuDegistir()" v-on:blur="InputDurumunuGeriDonustur()"  name="SifreTekrar" class="InputAlanlari" value="KullaniciSifresi">
                </div>


                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Telefon Numarasi</div>
                    <input type="text" name="TelefonNumarasi" maxlength="11" class="InputAlanlari" id="TelefonNumarasijQuery" value="<?php echo $KullaniciTelefonNumarasi?>">
                </div>

                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Cinsiyet</div>
                    <select name="Cinsiyet" class="SelectAlanlari">
                        <option value="Erkek" <?php if($KullaniciCinsiyet == "Erkek"){?>selected="selected"<?php } ?>>Erkek</option>
                        <option value="Kadin" <?php if($KullaniciCinsiyet == "Kadin"){?>selected="selected"<?php } ?>>Kadın</option>
                    </select>
                </div>

                <div class="FormSatirInputlari">
                    <input type="submit" value="Bildirimi Gönder" class="StandartGonderbuttonu">
                </div>
            </form>
        </div>
    </div>

    <div class="SagHavaleBildirimFormukapsama">
        <div class="BaslikAltiAciklamaSatisiIsleyis">Reklam Ve Öneri Alanlari.</div>
        <div class="HavaleIsleyisAlani">
            <img class="reklamResimHesabim" src="./Resimler/resimtanitim.png" alt="">
        </div>
    </div>
    </div><?php }else{
    yonlendir("index.php");
} ?>