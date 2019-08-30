<?php
    if(!isset($_SESSION["Kullanici"])){
      ?>
        <div class="AnaSayfaSectionBaslik">Kullanici Girişi</div>
        <div class="AnaSayfaIcerik">
            <div class="SolHavaleBildirimFormukapsama">
                <div class="BaslikAltiAciklamaSatisi">Lütfen Aşağidaki Bilgileri Eksiksiz Doldurunuz</div>
                <div class="HavaleFormAlani">
                    <form action="index.php?SK=32" method="POST">
                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Email Adresiniz</div>
                            <input tabindex="1" type="email" name="EmailAdresi"  class="InputAlanlari" id="EmailAdresiKontrol" required="required">
                        </div>
                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Şifre<span class="SifremiUnuttum"><a href="index.php?SK=37">Şifremi Unuttum</a></span></div>
                            <input type="password" tabindex="2" name="Sifre"  class="InputAlanlari" required="required">
                        </div>
                        <div class="FormSatirInputlari">
                            <input type="submit" value="Bildirimi Gönder"  class="StandartGonderbuttonu UyeGirisButtonHizalama">
                        </div>
                    </form>
                </div>
            </div>

            <div class="SagHavaleBildirimFormukapsama">
                <div class="BaslikAltiAciklamaSatisiIsleyis">Üyelik Adimlari.</div>
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
        yonlendir("index.php?SK=50");
    } ?>





