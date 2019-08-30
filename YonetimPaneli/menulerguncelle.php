<?php
global $veritabani;
if(isset($_SESSION["Yonetici"])){
    if(isset($_GET["ID"])){
        $GelenID = Guvenlik(SayiliIcerikleriFilitrele($_GET["ID"]));
    }else{
        $GelenID = "";
    }


    if($GelenID != ""){

        $MenuEklemeSorgusu = $veritabani->prepare("SELECT * FROM menuler WHERE id = ? LIMIT 1");
        $MenuEklemeSorgusu->execute([$GelenID]);
        $MenuEklemeSorgusuSayisi = $MenuEklemeSorgusu->rowCount();
        $MenuEklemeSorgusuKaydi = $MenuEklemeSorgusu->fetch(PDO::FETCH_ASSOC);



        ?>
        <div class="YoneticiSayfasiSayfalarKapsamaAlani">
            <div class="YoneticiSayfasiSayfalarBasligi">
                Menu'yü Güncelle
            </div>
            <div class="YoneticiSayfasiSayfaIcerikleri">
                <form action="index.php?SKD=0&SKI=63&ID=<?php echo $GelenID ?>" method="post">
                    <div class="YoneticiSayfasiSayfaIcerikleri sifirla">
                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">Menü İçin Ürün Türü&nbsp;:</div>
                            <select name="UrunTuru" class="YonetimPaneliStandartInput">
                                <option value="<?php echo $MenuEklemeSorgusuKaydi["UrunTuru"] ?>"><?php echo $MenuEklemeSorgusuKaydi["UrunTuru"] ?></option>
                            </select>
                        </div>
                        <div class="InputAciklamaMetinleriKapsamaAlani">
                            <div class="InputAciklamaMetini">Menü Adi&nbsp;:</div>
                            <input type="text" name="MenuAdi" value="<?php echo $MenuEklemeSorgusuKaydi["MenuAdi"] ?>" class="YonetimPaneliStandartInput">
                        </div>

                        <div class="FormdakiVerileriGondermekIcinSubmitAlani">
                            <input type="submit" value="Menuyu Guncelle" class="YonetimPaneliStandartInput">
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <?php













    }

}
?>