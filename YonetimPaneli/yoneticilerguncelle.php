<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }


    if($GelenID != ""){
        $Sorgu = $veritabani->prepare("SELECT * FROM yoneticiler WHERE id = ? LIMIT 1");
        $Sorgu->execute([$GelenID]);
        $SorguSayisi = $Sorgu->rowCount();
        $SorguKaydi = $Sorgu->fetch(PDO::FETCH_ASSOC);

        if($SorguSayisi>0){
            ?>
            <form action="index.php?SKD=0&SKI=76&ID=<?php echo $GelenID ?>" method="post">
                <div class="YoneticiSayfasiSayfalarKapsamaAlani">
                    <div class="YoneticiSayfasiSayfalarBasligi">Güncelle</div>
                    <div class="YoneticiSayfasiSayfaIcerikleri"  style="border:none;">

                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">Kullanici Adi&nbsp;:</div>
                            <input type="text"  name="KullaniciAdi" disabled value="<?php echo $SorguKaydi["KullaniciAdi"]?>"  class="YonetimPaneliStandartInput">
                        </div>
                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">Şifre&nbsp;:</div>
                            <input type="text"  name="Sifre" value=""  class="YonetimPaneliStandartInput">
                        </div>
                        <span style="margin-left: 5px;color: #FFA000">Yönetici Şifresini Eğer Güncellemek İstemiyorsaniz Lütfen Şifre Alaninini Boş Geçiniz.</span>
                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">İsim Soyisim&nbsp;:</div>
                            <input type="text"  name="isimSoyisim" value="<?php echo $SorguKaydi["isimSoyisim"]?>"  class="YonetimPaneliStandartInput">
                        </div>
                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">Email Adresi&nbsp;:</div>
                            <input type="text"  name="EmailAdresi" value="<?php echo $SorguKaydi["EmailAdresi"]?>"  class="YonetimPaneliStandartInput">
                        </div>
                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">Telefon Numarasi&nbsp;:</div>
                            <input type="text" id="TelefonNumarasijQuery" value="<?php echo $SorguKaydi["TelefonNumrasi"]?>" name="TelefonNumarasi"  class="YonetimPaneliStandartInput">
                        </div>

                        <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                            <input type="submit" value="Yeni Yöneticiyi Ekle" class="YonetimPaneliStandartInput">
                        </div>

                    </div>
                </div>
            </form>
            <?php

        }


    }




}
?>