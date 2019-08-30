<?php
if(isset($_SESSION["Kullanici"])){
    if(isset($_GET["UrunID"])){
        $GelenUrunID = Guvenlik($_GET["UrunID"]);
    }else{
        $GelenUrunID = "";
    }

    if($GelenUrunID != ""){
    ?>
        <div class="HesabimSayfasiUstMenu">
            <ul class="UstMenuKapsamaAlani">
                <a href="index.php?SK=50"><li class="UstMenuler">Üyelik Bilgilerim</li></a>
                <a href="index.php?SK=58"><li class="UstMenuler">Adresler</li></a>
                <a href="index.php?SK=59"><li class="UstMenuler">Favoriler</li></a>
                <a href="index.php?SK=60"><li class="UstMenuler">Yorumlar</li></a>
                <a href="index.php?SK=61"><li class="UstMenuler">Siparişler</li></a>
            </ul>
        </div>
        <div class="AnaSayfaSectionBaslik">Hesabim > Yorum Yap</div>
        <div class="AnaSayfaIcerik">
            <div class="SolHavaleBildirimFormukapsama">
                <form action="index.php?SK=76&UrunID=<?php echo $GelenUrunID ?>" method="post">
                    <div class="BaslikAltiAciklamaSatisi">Almiş oldugunuz ürün ile alakali ürün aşağidan yorumunu belirtebilirsin.</div>
                    <div class="PuanlamaBaslik">Puanlama</div>
                    <ul class="PuanlamaListeleri">


                        <li class="Puanlamalar">
                            <a href="#">
                                <img src="Resimler/YildizBirDolu.png" alt=""><br/>
                                <input type="radio" class="InputRadioButton" name="Puan" value="1">
                            </a>
                        </li>

                        <li class="Puanlamalar">
                            <a href="#">
                                <img src="Resimler/YildizIkiDolu.png" alt=""><br/>
                                <input type="radio" class="InputRadioButton" name="Puan" value="2">
                            </a>
                        </li>

                        <li class="Puanlamalar">
                            <a href="#">
                                <img src="Resimler/YildizUcDolu.png" alt=""><br/>
                                <input class="InputRadioButton" type="radio" name="Puan" value="3">
                            </a>
                        </li>

                        <li class="Puanlamalar">
                            <a href="#">
                                <img src="Resimler/YildizDortDolu.png" alt=""><br/>
                                <input type="radio" class="InputRadioButton" name="Puan" value="4">
                            </a>
                        </li>

                        <li class="Puanlamalar">
                            <a href="#">
                                <img src="Resimler/YildizBesDolu.png" alt=""><br/>
                                <input type="radio" class="InputRadioButton" name="Puan" value="5">
                            </a>
                        </li>

                    </ul>
                    <div class="FormSatirInputlari">
                        <div class="FormMetinBasligi">Yorum Metini.</div>
                        <textarea name="Yorum" class="TextAreaAlanlari" style="height: 220px;">

                        </textarea>
                    </div>
                    <li class="FormSatirInputlari">
                        <input type="submit" value="Yorumunu Gönder" class="StandartGonderbuttonu">
                    </li>

                </form>



















            </div>

            <div class="SagHavaleBildirimFormukapsama">
                <div class="BaslikAltiAciklamaSatisiIsleyis">Reklam Ve Öneri Alanlari.</div>
                <div class="HavaleIsleyisAlani">
                    <img class="reklamResimHesabim" src="./Resimler/resimtanitim.png" alt="">
                </div>
            </div>
        </div>


    <?php
    }


}else{
    yonlendir("index.php");
}
?>

