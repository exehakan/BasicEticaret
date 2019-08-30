<?php
if(isset($_SESSION["Kullanici"])){
?>
    <div class="KrediKartiEklemeAlani">
        <div class="KrediKartiOdemeKapasamaAlani">
            <form action="index.php?SK=105" method="post">
                <div class="KrediKartiInputAlanlari">
                    <div class="KrediKartiInputBilgilendirmeleri">Kart Sahibinin Adi Soyadi</div>
                    <input type="text" name="KrediKartiSahibininBilgileri" class="KrediKartiOdemeInputAlanlari">
                </div>
                <div class="KrediKartiInputAlanlari">
                    <div class="KrediKartiInputBilgilendirmeleri">Kredi Karti Numarasi</div>
                    <input type="text" name="KrediKartiNumarasi" class="KrediKartiOdemeInputAlanlari">
                </div>
                <div class="KrediKartiInputAlanlari">
                    <div class="KrediKartiInputBilgilendirmeleri">Son Kullanma Tarihi</div>
                    <select name="SonKullanmaTarihiAY" class="KrediKartiSelectAlanlari">
                        <option value="01">01</option>
                        <option value="02">02</option>
                        <option value="03">03</option>
                        <option value="04">04</option>
                        <option value="05">05</option>
                        <option value="06">06</option>
                        <option value="07">07</option>
                        <option value="08">08</option>
                        <option value="09">09</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>&nbsp;
                    <select name="SonKullanmaTarihiYil" class="KrediKartiSelectAlanlari">
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                        <option value="2017">2017</option>
                        <option value="2018">2018</option>
                        <option value="2019">2019</option>
                        <option value="2020">2020</option>
                        <option value="2021">2021</option>
                        <option value="2022">2022</option>
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                    </select>
                </div>
                <div class="KrediKartiInputAlanlari KrediKartiTuruOdemeSecimi">
                    <div class="KrediKartiInputBilgilendirmeleri">Kredi Karti Türü Seçiniz</div>
                    <input type="radio" name="KrediKartiTuru" class="KrediKartiTuruBicimlendir" value="Visa">
                    <span class="KrediKartiTuruAciklamasiVisa">Visa</span><br/>
                    <input type="radio" name="KrediKartiTuru" class="KrediKartiTuruBicimlendir" value="MasterCard">
                    <span class="KrediKartiTuruAciklamasimasterCard">masterCard</span>
                </div>
                <div class="KrediKartiInputAlanlari">
                    <div class="KrediKartiInputBilgilendirmeleri"><span style="color: #5e2c2f">Güvenlik Kodu</span></div>
                    <input type="text" name="KrediKartiGuvenlikKodu" class="KrediKartiGuvenlikButtonu">
                </div>
                <div class="KrediKartiInputAlanlari">
                    <input type="submit" value="Yeni Kredi Kartini Kaydet" class="KrediKartiOdemeIsleminiTamamla">
                </div>
            </form>

        </div>

    </div>

<?php
}else{
    echo "<h2 style='text-decoration: underline'>Giriş Yapılmadan Yeni Kart Eklenemez.</h2>";
}

?>










