    <?php
    if(isset($_GET["AktivasyonKodu"])){
        $GelenAktivasyonKodu = Guvenlik($_GET["AktivasyonKodu"]);
    }else{
        $GelenAktivasyonKodu = "";
    }

    if(isset($_GET["Email"])){
        $GelenMailAdresi = Guvenlik($_GET["Email"]);
    }else{
        $GelenMailAdresi = "";
    }

    if(($GelenAktivasyonKodu != "") && ($GelenMailAdresi != "")){
        $KontrolSorgusu = $veritabani->prepare("SELECT * FROM uyeler WHERE EmailAdresi = ? AND AktivasyonKodu = ?");
        $KontrolSorgusu->execute([$GelenMailAdresi,$GelenAktivasyonKodu]);
        $KayitSayisi = $KontrolSorgusu->rowCount();
        $Kayitlar = $KontrolSorgusu->fetch(PDO::FETCH_ASSOC);
        if($KayitSayisi>0){

    ?>
        <div class="AnaSayfaSectionBaslik">Şifre Sifirlama</div>
        <div class="AnaSayfaIcerik">
            <div class="SolHavaleBildirimFormukapsama">
                <div class="BaslikAltiAciklamaSatisi">Aşadağidan Şifrenizi Sifirlayabilirsiniz</div>
                <div class="HavaleFormAlani">
                    <form action="index.php?SK=44&AktivasyonKodu=<?php echo $GelenAktivasyonKodu ?>&EmailAdresi=<?php echo $GelenMailAdresi?>" method="POST">
                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Yeni Şifre</div>
                            <input type="password" name="Sifre"  class="InputAlanlari" id="EmailAdresiKontrol" required="required">
                        </div>
                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Yeni Şifre Tekrar</div>
                            <input type="password" name="SifreTekrar"  class="InputAlanlari" required="required">
                        </div>
                        <div class="FormSatirInputlari">
                            <input type="submit" value="Şifreyi Güncelle"  class="StandartGonderbuttonu UyeGirisButtonHizalama">
                        </div>
                    </form>
                </div>
            </div>

            <div class="SagHavaleBildirimFormukapsama">
                <div class="BaslikAltiAciklamaSatisiIsleyis">Şifre Sifirlama Adimlari.</div>
                <div class="HavaleIsleyisAlani">

                    <div class="KontrolSatirAlani">
                        <div class="KontrolResimveBaslikAlani">
                            <img src="Resimler/Banka20x20.png" alt="">
                            <span class="KontrolBaslikMetini">Üyelik İşlemleri</span>
                            <p class="SatirMetini"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aut commodi culpa cum debitis deleniti dicta dolore earum eius eligendi facilis, inventore ipsa omnis quod sequi soluta veniam, vitae voluptas?</p>
                        </div>
                    </div>
                    <div class="KontrolSatirAlani">
                        <div class="KontrolResimveBaslikAlani">
                            <img src="Resimler/DokumanKirmiziKalemli20x20.png" alt="">
                            <span class="KontrolBaslikMetini">Bildirim İşlemleri</span>
                            <p class="SatirMetini"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aut commodi culpa cum debitis deleniti dicta dolore earum eius eligendi facilis, inventore ipsa omnis quod sequi soluta veniam, vitae voluptas?</p>
                        </div>
                    </div>
                    <div class="KontrolSatirAlani">
                        <div class="KontrolResimveBaslikAlani">
                            <img src="Resimler/CarklarSiyah20x20.png" alt="">
                            <span class="KontrolBaslikMetini">Kontroller</span>
                            <p class="SatirMetini"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aut commodi culpa cum debitis deleniti dicta dolore earum eius eligendi facilis, inventore ipsa omnis quod sequi soluta veniam, vitae voluptas?</p>
                        </div>
                    </div>

                    <div class="KontrolSatirAlani">
                        <div class="KontrolResimveBaslikAlani">
                            <img src="Resimler/InsanlarSiyah20x20.png" alt="">
                            <span class="KontrolBaslikMetini">Onay ve Red</span>
                            <p class="SatirMetini"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aut commodi culpa cum debitis deleniti dicta dolore earum eius eligendi facilis, inventore ipsa omnis quod sequi soluta veniam, vitae voluptas?</p>
                        </div>
                    </div>

                    <div class="KontrolSatirAlani">
                        <div class="KontrolResimveBaslikAlani">
                            <img src="Resimler/SaatEsnetikGri20x20.png" alt="">
                            <span class="KontrolBaslikMetini">Sipariş Hazirlama & Teslimat</span>
                            <p class="SatirMetini"> Lorem ipsum dolor sit amet, consectetur adipisicing elit. Animi aut commodi culpa cum debitis deleniti dicta dolore earum eius eligendi facilis, inventore ipsa omnis quod sequi soluta veniam, vitae voluptas?</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    <?php
        }else{
            echo "ÜZGÜNÜM DAHA ÖNCE BU AKTİVASYON LİNKİ KULLANILDI VE SUANDA KULLANILAMAZ.";
        }
    }else{
        yonlendir("index.php?SK=0");
    }
    ?>


