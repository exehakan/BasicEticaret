<div class="AnaSayfaSectionBaslik">Banka Hesaplarimiz</div>
<div class="AnaSayfaIcerik">
    <div class="BankaHesapBilgileriKapsamaAlani">
        <div class="BankaHesapBilgileriSinirlamaAlani">
            <h3 style="">Ödemeleriniz için çalışmakta olduduğumuz tüm bankalar aşağıdadır.</h3>
            <?php
                $BankaSorgusu = $veritabani->prepare("SELECT * FROM bankahesaplarimiz");
                $BankaSorgusu->execute(["Deniz Bank"]);
                $BankaSorgusuKayitSayisi = $BankaSorgusu->rowCount();
                $BankaKayitlari = $BankaSorgusu->fetchAll(PDO::FETCH_ASSOC);
                $DonguSayisi = 1;
                $BlokAdetSayisi = 8;
            foreach($BankaKayitlari as $kayitDegerleri){?>

                <div class="BankaHesapBilgileri">
                    <div class="BankaResimLogosuKapsamaAlani">
                        <img src="Resimler/<?php echo $kayitDegerleri["BankaLogosu"]?>.png" alt="">
                    </div>

                    <div class="BankaHesapIcinSiraliBilgiler">
                        <div class="BankaIleIlgiliBilgiAlani">Banka Adi</div>
                        <div class="BankaIleIlgiliBilgiDegeri"><?php echo DonusumleriGeriDondur($kayitDegerleri["BankaAdi"]?? "Değer Yok")?></div>
                    </div>
                    <div class="BankaHesapIcinSiraliBilgiler">
                        <div class="BankaIleIlgiliBilgiAlani">Konum</div>
                        <div class="BankaIleIlgiliBilgiDegeri"><?php echo DonusumleriGeriDondur($kayitDegerleri["konumSehir"]?? "Değer Yok")?></div>
                    </div>
                    <div class="BankaHesapIcinSiraliBilgiler">
                        <div class="BankaIleIlgiliBilgiAlani">Konum Ülke</div>
                        <div class="BankaIleIlgiliBilgiDegeri"><?php echo DonusumleriGeriDondur($kayitDegerleri["KonumUlke"]?? "Değer Yok")?></div>
                    </div>
                    <div class="BankaHesapIcinSiraliBilgiler">
                        <div class="BankaIleIlgiliBilgiAlani">Şube</div>
                        <div class="BankaIleIlgiliBilgiDegeri"><?php echo DonusumleriGeriDondur($kayitDegerleri["SubeAdi1"]?? "Değer Yok")?></div>
                    </div>
                    <div class="BankaHesapIcinSiraliBilgiler">
                        <div class="BankaIleIlgiliBilgiAlani">Şube Kodu</div>
                        <div class="BankaIleIlgiliBilgiDegeri"><?php echo DonusumleriGeriDondur($kayitDegerleri["SubeKodu"] ?? "Değer Yok")?></div>
                    </div>
                    <div class="BankaHesapIcinSiraliBilgiler">
                        <div class="BankaIleIlgiliBilgiAlani">Hesap Sahibi</div>
                        <div class="BankaIleIlgiliBilgiDegeri"><?php echo DonusumleriGeriDondur($kayitDegerleri["HesapSahibi"]?? "Değer Yok")?></div>
                    </div>
                    <div class="BankaHesapIcinSiraliBilgiler">
                        <div class="BankaIleIlgiliBilgiAlani">Hesap No</div>
                        <div class="BankaIleIlgiliBilgiDegeri"><?php echo DonusumleriGeriDondur($kayitDegerleri["HesapNumarasi"]?? "Değer Yok")?></div>
                    </div>
                    <div class="BankaHesapIcinSiraliBilgiler">
                        <div class="BankaIleIlgiliBilgiAlani">IBAN NO</div>
                        <div class="BankaIleIlgiliBilgiDegeri"><?php echo IBANBicimlendir(DonusumleriGeriDondur($kayitDegerleri["IbanNumarasi"]?? "Değer Yok"))?></div>
                    </div>
                </div>
            <?php } ?>
        </div>

    </div>
</div>