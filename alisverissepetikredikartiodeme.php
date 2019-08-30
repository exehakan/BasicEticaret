<?php
global $veritabani;
global $KullaniciID;
global $DolarKuru;
global $EuroKuru;
global $ClientID;
global $StoreKey;
global $ApiKullanicisi;
global $ApiSifresi;
global $UcretsizKargoBaraji;
global $KullanicininBakiyesi;


if(isset($_SESSION["Kullanici"])){
    //Sepetteki ürünlerin kontrolleri
    $SepettekiUrunSorgusu = $veritabani->prepare("select * from sepetim where UyeId = ? ORDER BY id DESC");
    $SepettekiUrunSorgusu->execute([$KullaniciID]);
    $SepettekiUrunSorgusuSayisi = $SepettekiUrunSorgusu->rowCount();
    $SepettekiUrunKayitlari = $SepettekiUrunSorgusu->fetchAll(PDO::FETCH_ASSOC);

    if($SepettekiUrunSorgusuSayisi>0){
        $SepettekiToplamUrunSayisi          =   0;
        $SepettekiToplamFiyat               =   0;
        $SepettekiToplamKargoFiyati         =   0;
        $SepettekiToplamKargoFiyatiHesapla  =   0;
        $OdenecekToplamTutariHesapla        =   0;
        $ForeacdanGelenUrunDizileri         =   [];
        foreach($SepettekiUrunKayitlari as $SepetSatirlari){
            $SepettekiID                    =   $SepetSatirlari["id"];
            $SepettekiSepetNumarasi         =   $SepetSatirlari["SepetNumarasi"];
            $SepettekiUrununUrunIDsi        =   $SepetSatirlari["UrunId"];
            $SepettekiUrununVaryantIDsi     =   $SepetSatirlari["VaryantId"];
            $SepettekiUrununAdedi           =   $SepetSatirlari["UrunAdedi"];

            $ForeacdanGelenUrunDizileri[] = $SepettekiUrununUrunIDsi;

            $UrunBilgileriSorgusu = $veritabani->prepare("SELECT * FROM urunler WHERE id = ? LIMIT 1");
            $UrunBilgileriSorgusu->execute([$SepettekiUrununUrunIDsi]);
            $UrunBilgileriKaydi = $UrunBilgileriSorgusu->fetch(PDO::FETCH_ASSOC);

                $UrununFiyati       = $UrunBilgileriKaydi["UrunFiyati"];
                $UrununParaBirimi   = $UrunBilgileriKaydi["ParaBirimi"];
                $UrununKargoUcreti  = $UrunBilgileriKaydi["KargoUcreti"];

                if($UrununParaBirimi == "USD"){
                    $UrununFiyatiniHesapla = $UrununFiyati * $DolarKuru;
                    $UrununFiyatiniBicimlendir = FiyatBicimlendir($UrununFiyatiniHesapla);
                }elseif($UrununParaBirimi == "EUR"){
                    $UrununFiyatiniHesapla = $UrununFiyati * $EuroKuru;
                    $UrununFiyatiniBicimlendir = FiyatBicimlendir($UrununFiyatiniHesapla);
                }else{
                    $UrununFiyatiniHesapla = $UrununFiyati;
                    $UrununFiyatiniBicimlendir = FiyatBicimlendir($UrununFiyatiniHesapla);
                }

                $UrununToplamFiyatiniHesapla        =   ($UrununFiyatiniHesapla*$SepettekiUrununAdedi);
                $UrununToplamFiyatiniBicimlendir    =   FiyatBicimlendir($UrununToplamFiyatiniHesapla);
                $SepettekiToplamUrunSayisi         +=   $SepettekiUrununAdedi;
                $SepettekiToplamFiyat              +=   ($UrununFiyatiniHesapla*$SepettekiUrununAdedi);
                $SepettekiToplamKargoFiyatiHesapla +=   ($UrununKargoUcreti*$SepettekiUrununAdedi);
                $UrununToplamKargoFiyatiHesapla     =   FiyatBicimlendir($SepettekiToplamKargoFiyatiHesapla);

        }//Foreach End<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<


        /*if($SepettekiToplamFiyat>=$UcretsizKargoBaraji){
            $SepettekiToplamKargoFiyatiHesapla          = 0;
            $SepettekiToplamKargoFiyatiniBicimlendir    = FiyatBicimlendir($SepettekiToplamKargoFiyatiHesapla);
            $OdenecekToplamTutariBicimlendir            = FiyatBicimlendir($SepettekiToplamFiyat);
        }else{
            $OdenecekToplamTutariHesapla        = ($SepettekiToplamFiyat+$SepettekiToplamKargoFiyatiHesapla);
            $OdenecekToplamTutariBicimlendir    = FiyatBicimlendir($OdenecekToplamTutariHesapla);
        }*/

        //
        if($SepettekiToplamFiyat >= $UcretsizKargoBaraji ){
            $SepettekiToplamKargoFiyatiniHesapla        = 0;
            $SepettekiToplamKargoFiyatiniBicimlendir    =  FiyatBicimlendir($SepettekiToplamKargoFiyatiniHesapla);
            $OdenecekToplamTutariBicimlendir            =  FiyatBicimlendir($SepettekiToplamFiyat);
        }elseif($SepettekiToplamFiyat <= $UcretsizKargoBaraji) {
            $SepettekiToplamKargoFiyatiniHesapla        = 0;
            $OdenecekToplamTutariHesapla                =   ($SepettekiToplamFiyat + $SepettekiToplamKargoFiyatiniHesapla);
            $OdenecekToplamTutariBicimlendir            =   FiyatBicimlendir($OdenecekToplamTutariHesapla);
            $SepettekiToplamKargoFiyatiniHesapla        =   $OdenecekToplamTutariHesapla;
            $SepettekiToplamKargoFiyatiniBicimlendir    =   FiyatBicimlendir($SepettekiToplamKargoFiyatiniHesapla);
        }




        $KullaniciKrediKartiBilgileriniAl = $veritabani->prepare("SELECT * FROM kullanicininkredikartibilgileri WHERE UyeID = ?");
        $KullaniciKrediKartiBilgileriniAl->execute([$KullaniciID]);
        $KullaniciKrediKartiBilgileriniAlSayisi = $KullaniciKrediKartiBilgileriniAl->rowCount();
        $KullaniciKrediKartiKaydi = $KullaniciKrediKartiBilgileriniAl->fetch(PDO::FETCH_ASSOC);


        $parcala = implode(",",$ForeacdanGelenUrunDizileri);

        ?>
<div class="AlisverisSepetiSolUrunlerAlani" style="background-color: #fff !important;">
<div class="AlisverisSepetiBaslik">Alışveriş Sepeti</div>
<div class="AlisverisSepetiBaslikAciklamasi">Adres ve kargo seçiminizi aşağıdan belirtebilirsiniz.</div>
<div class="AlisverisSepetiUrunlerListesiSinirlamaAlani">

    <div class="KrediKartiOdemeKapasamaAlani">
        <a href="index.php?SK=104" class="YeniKrediKartiEkle">Yeni Kredi Karti Ekle</a>
        <form action="index.php?SK=103" method="post">
            <input type="hidden" name="SepettekiUrununUrunIDsi" value="<?php echo $parcala ?>">
            <input type="hidden" name="KullanicininHesapBakiyesi" value="<?php echo $KullanicininBakiyesi ?>">
            <input type="hidden" name="KullanicicininOdeyecegiTutar" value="<?php echo SayiliIcerikleriFilitrele(ceil($UrununToplamFiyatiniHesapla)) ?>">
            <div class="KrediKartiInputAlanlari">
                <div class="KrediKartiInputBilgilendirmeleri">Kredi Karti Numarasi</div>
                <input type="text" name="KrediKartiNumarasi" value="<?php echo $KullaniciKrediKartiKaydi["KrediKartiNumarasi"] ?>" class="KrediKartiOdemeInputAlanlari">
            </div>
            <div class="KrediKartiInputAlanlari">
                <div class="KrediKartiInputBilgilendirmeleri">Son Kullanma Tarihi</div>
                <select name="SonKullanmaTarihiAY" class="KrediKartiSelectAlanlari">
                    <option value="<?php echo $KullaniciKrediKartiKaydi["SonKullanmaTarihiAY"]?>"><?php echo $KullaniciKrediKartiKaydi["SonKullanmaTarihiAY"]?></option>
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
                    <option value="<?php echo $KullaniciKrediKartiKaydi["SonKullanmaTarihiYil"] ?>"><?php echo $KullaniciKrediKartiKaydi["SonKullanmaTarihiYil"] ?></option>
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
                <input type="radio" name="KrediKartiTuru" class="KrediKartiTuruBicimlendir" value="Visa" <?php if($KullaniciKrediKartiKaydi["KartTuru"] == "Visa"){ ?> checked <?php }else{} ?>>
                <span class="KrediKartiTuruAciklamasiVisa">Visa</span><br/>
                <input type="radio" name="KrediKartiTuru" class="KrediKartiTuruBicimlendir" value="MasterCard" <?php if($KullaniciKrediKartiKaydi["KartTuru"] == "masterCard"){ ?> checked <?php }else{} ?>>
                <span class="KrediKartiTuruAciklamasimasterCard">masterCard</span>
            </div>
            <div class="KrediKartiInputAlanlari">
                <div class="KrediKartiInputBilgilendirmeleri"><span style="color: #5e2c2f">Güvenlik Kodu</span></div>
                <input type="text" name="KrediKartiGuvenlikKodu" class="KrediKartiGuvenlikButtonu" value="<?php echo $KullaniciKrediKartiKaydi["GuvenlikKodu"] ?>">
            </div>
            <div class="KrediKartiInputAlanlari">
                <input type="submit" value="Ödemeyi Tamamla" class="KrediKartiOdemeIsleminiTamamla">
            </div>
        </form>

    </div>



    <?php
        // Odeme İşlemlerinin alinacaği Alan
    ?>
</div></div>
        <div class="AlisverisSepetiSagTutarveBilgiAlani" style="background-color: #fff !important;">
            <div class="AlisverisSepetiSagTutarSinirlamaAlani">
                <div class="AlisverisSepetiSagBaslikAlani">Sipariş Özeti</div>
                <div class="AlisverisSepetiSagTutarDetaylari">Toplam <span><?php $e->yazdir($SepettekiToplamUrunSayisi)?></span> Adet Ürün</div>

                <div class="AlisverisSepetiSagOdenecekTutarBilgilendirmesi">
                    Ödenecek Tutar (KDV Dahil)
                </div>
                <div class="AlisverisSepetiSagOdenecekTutarDegeri"><?php echo $OdenecekToplamTutariBicimlendir; ?></div>

                <div class="AlisverisSepetiSagOdenecekTutarBilgilendirmesi">
                    Ürünün Toplam Fiyati (KDV Dahil)
                </div>
                <div class="AlisverisSepetiSagOdenecekTutarDegeri"><?php echo FiyatBicimlendir($SepettekiToplamFiyat); ?></div>

                <div class="AlisverisSepetiSagOdenecekTutarBilgilendirmesi">
                    Kargo Tutari (KDV Dahil)
                </div>
                <div class="AlisverisSepetiSagOdenecekTutarDegeri"><?php echo $SepettekiToplamKargoFiyatiniBicimlendir; ?></div>

            </div>
        </div>
<?php

    }else{
        echo "Üzgünüm Sepetinizde Ürün Yok";
    }

}else{
    header("Location:index.php");
}




























