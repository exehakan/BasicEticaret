<?php
if(isset($_SESSION["Kullanici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik($_GET["ID"]);
    }else{
        $GelenID = "";
    }

    if($GelenID != ""){
        $AdresSorgusu = $veritabani->prepare("SELECT * FROM adresler WHERE id=? AND UyeId=? LIMIT 1");
        $AdresSorgusu->execute([$GelenID,$KullaniciID]);
        $Etkilenen = $AdresSorgusu->rowCount();
        $KayitBilgisi = $AdresSorgusu->fetch(PDO::FETCH_ASSOC);
        if($Etkilenen>0){
            ?>
            <div class="AnaSayfaSectionBaslik">Adres Bilgilerini Güncelle</div>
            <div class="AnaSayfaIcerik">
                <div class="SolHavaleBildirimFormukapsama">
                    <div class="BaslikAltiAciklamaSatisi">Tüm Adres Bilgilerini Görüntüleyebilir Güncelleyebilirsiniz.</div>
                    <div class="HavaleFormAlani">
                        <form action="index.php?SK=63&ID=<?php echo $GelenID ?>" method="POST">
                            <div class="FormSatirInputlari">
                                <div class="FormMetinBasligi">İsim Soyisim</div>
                                <input type="text" name="isimSoyisim" value="<?php echo $KayitBilgisi["AdiSoyadi"]?>" class="InputAlanlari">
                            </div>

                            <div class="FormSatirInputlari">
                                <div class="FormMetinBasligi">Adres</div>
                                <textarea type="text" name="Adres" class="TextAreaAlanlari" ><?php echo $KayitBilgisi["Adres"]?></textarea>
                            </div>

                            <div class="FormSatirInputlari">
                                <div class="FormMetinBasligi">İlçe</div>
                                <input type="text" name="Ilce" value="<?php echo $KayitBilgisi["Sehir"]?>"  class="InputAlanlari">
                            </div>

                            <div class="FormSatirInputlari">
                                <div class="FormMetinBasligi">Şehir</div>
                                <input type="text" name="Sehir" value="<?php echo $KayitBilgisi["Ilce"]?>"  class="InputAlanlari">
                            </div>

                            <div class="FormSatirInputlari">
                                <div class="FormMetinBasligi">Telefon Numarasi</div>
                                <input type="text" name="TelefonNumarasi" value="<?php echo $KayitBilgisi["TelefonNumarasi"]?>" maxlength="11" class="InputAlanlari" id="TelefonNumarasijQuery">
                            </div>


                            <div class="FormSatirInputlari">
                                <input type="submit" value="Adresi Güncelle" class="StandartGonderbuttonu">
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
            yonlendir("index.php?SK=65");
        }
    }else{
        yonlendir("index.php?SK=65");
    }



}else{
    yonlendir("index.php");
}


?>