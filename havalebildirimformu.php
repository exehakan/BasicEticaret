<div class="AnaSayfaSectionBaslik">Havale Bildirim Formu</div>
<div class="AnaSayfaIcerik">
    <div class="SolHavaleBildirimFormukapsama">
        <div class="BaslikAltiAciklamaSatisi">Tamamlanmış Oldugunuz Ödeme İşleminizi Aşağidaki Formdan İletiniz.</div>
        <div class="HavaleFormAlani">
            <form action="index.php?SK=10" method="POST">
                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">İsim Soyisim</div>
                    <input type="text" name="isimSoyisim" class="InputAlanlari">
                </div>

                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Email Adresiniz</div>
                    <input type="email" name="EmailAdresi"  class="InputAlanlari" id="EmailAdresiKontrol">
                </div>

                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Telefon Numarasi</div>
                    <input type="text" name="TelefonNumarasi" maxlength="11" class="InputAlanlari" id="TelefonNumarasijQuery">
                </div>
                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Ödeme Yapılan Banka</div>
                    <select name="BankaSecimi" class="SelectAlanlari" required="required">
                        <option selected value="0">Lütfen Banka Seciniz</option>
                        <?php
                            $BankalarSorgusu = $veritabani->prepare("SELECT * FROM bankahesaplarimiz ORDER BY BankaAdi ASC");
                            $BankalarSorgusu->execute();
                            $BankalarKayitSayisi = $BankalarSorgusu->rowCount();
                            $BankaAdiKayitlari = $BankalarSorgusu->fetchAll(PDO::FETCH_ASSOC);
                            foreach($BankaAdiKayitlari as $BankaIsimleri){?>
                                <option value="<?php echo $BankaIsimleri["id"]?>"><?php echo DonusumleriGeriDondur($BankaIsimleri["BankaAdi"])?></option>
                            <?php } ?>
                    </select>
                </div>
                <div class="FormSatirInputlari">
                    <div class="FormMetinBasligi">Açıklama</div>
                    <textarea name="Aciklama" class="TextAreaAlanlari"></textarea>
                </div>

                <div class="FormSatirInputlari">
                    <input type="submit" value="Bildirimi Gönder" class="StandartGonderbuttonu">
                </div>
            </form>
        </div>
    </div>

    <div class="SagHavaleBildirimFormukapsama">
        <div class="BaslikAltiAciklamaSatisiIsleyis">İşleyiş.</div>
        <div class="HavaleIsleyisAlani">

            <div class="KontrolSatirAlani">
                <div class="KontrolResimveBaslikAlani">
                    <img src="Resimler/Banka20x20.png" alt="">
                    <span class="KontrolBaslikMetini">Havale / EFT İşlemleri</span>
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