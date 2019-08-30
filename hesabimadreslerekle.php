<?php
    if(isset($_SESSION["Kullanici"])){
?>

        <div class="AnaSayfaSectionBaslik">Yeni Adres Ekle</div>
        <div class="AnaSayfaIcerik">
            <div class="SolHavaleBildirimFormukapsama">
                <div class="BaslikAltiAciklamaSatisi">Yeni bir adres eklemek için lütfen formu doldurunuz.</div>
                <div class="HavaleFormAlani">
                    <form action="index.php?SK=71" method="POST">
                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">İsim Soyisim</div>
                            <input type="text" name="isimSoyisim"  class="InputAlanlari">
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Adres</div>
                            <textarea type="text" name="Adres" class="TextAreaAlanlari" ></textarea>
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">İlçe</div>
                            <input type="text" name="Ilce"   class="InputAlanlari">
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Şehir</div>
                            <input type="text" name="Sehir"   class="InputAlanlari">
                        </div>

                        <div class="FormSatirInputlari">
                            <div class="FormMetinBasligi">Telefon Numarasi</div>
                            <input type="text" name="TelefonNumarasi"  maxlength="11" class="InputAlanlari" id="TelefonNumarasijQuery">
                        </div>


                        <div class="FormSatirInputlari">
                            <input type="submit" value="Adresi Kaydet" class="StandartGonderbuttonu">
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
        </div>



<?php
    }else{
        yonlendir("index.php");
    }
?>