<?php
$IPAdresi       = $_SERVER["REMOTE_ADDR"];
$ZamanDamgasi   = time();
$TarihSaat      = date("d.m.Y H:i:s",$ZamanDamgasi);
$HataTamamEksikResimleri = array(
    "tamam"=>"Tamam.png",
    "dikkat"=>"Dikkat.png",
    "hata"=>"Hata.png"
);

function RakamlarHaricTumKarakterleriSil($deger){
    $Desen = preg_replace("/[^0-9]/","",$deger);
    $Sonuc = $Desen;
    return $Sonuc;
}
function TumBosluklariSil($Deger){
    $Desen = preg_replace("/\s|&nbsp;/","",$Deger);
    return $Desen;
}
function Guvenlik($deger){
    $boslukTemizle  = trim($deger);
    $tagTemizle     = strip_tags($boslukTemizle);
    $EtkisizYap     = htmlspecialchars($tagTemizle,ENT_QUOTES);
    return $EtkisizYap;
}
function SayiliIcerikleriFilitrele($deger){
    $BoslukTemizle = trim($deger);
    $TagTemizle = strip_tags($BoslukTemizle);
    $OzelKarakterTemizle = htmlspecialchars($TagTemizle,ENT_QUOTES);
    $RakamlarIcinOzelFilitre = RakamlarHaricTumKarakterleriSil($OzelKarakterTemizle);
    return $RakamlarIcinOzelFilitre;
}
function DonusumleriGeriDondur($deger){
    $islem = htmlspecialchars_decode($deger,ENT_QUOTES);
    return $islem;
}
function IBANBicimlendir($Deger){
    $BoslukTemizle  = trim($Deger);
    $GelismisTemizleme = TumBosluklariSil($BoslukTemizle);
    $Blok1 = substr($GelismisTemizleme,0,4);
    $Blok2 = substr($GelismisTemizleme,4,4);
    $Blok3 = substr($GelismisTemizleme,8,4);
    $Blok4 = substr($GelismisTemizleme,12,4);
    $Blok5 = substr($GelismisTemizleme,16,4);
    $Blok6 = substr($GelismisTemizleme,20,4);
    $Blok7 = substr($GelismisTemizleme,22,2);
    $BicimlendirilmisDuzenliHali = $Blok1 . " " . $Blok2 . " " .$Blok3. " " .$Blok4. " " .$Blok5. " " .$Blok6. " " .$Blok7;
    return $BicimlendirilmisDuzenliHali;
}
function yonlendir($URL){
    header("Location:".$URL);
    exit();
}
?>

<?php function ileriDuzeySonucSayfalari($BaslikDegeri,$HataResimDegeri){
    if(isset($_SERVER["HTTP_REFERER"])){
        $OncekiSayfayaGeriDon = $_SERVER["HTTP_REFERER"];
    }else{
        yonlendir("index.php");
    }
    ?>
    <?php
        if(true){ ?>
            <div class="AnaSayfaIcerik">
                <div class="SolGeriDonButton"><a href="<?php echo $OncekiSayfayaGeriDon ?>">Önceki Sayfaya Geri Dön</a></div>
                <div class="BildirimSayfasiKapsamaAlani">
                    <img src="Resimler/<?php echo $HataResimDegeri ?>" alt="" class="BildirimResim">
                    <div class="BildirimMesajAlanlari">
                        <div class="BildirimBaslikAlani"><?php echo $BaslikDegeri ?></div>
                        <!-- <div class="BildirimAciklamaAlani"><a href=''>">Tıklayiniz</a></div>-->
                        <span></span>
                    </div>
                </div>
            </div>
        <?php }else{
            echo "<h4>Bir hata meydana geldi</h4>";
        } ?>
<?php } ?>
<?php

function AktivasyonKoduUret(){
    $birinci    = rand(1000,9999);
    $ikinci     = rand(1000,9999);
    $ucuncu     = rand(1000,9999);
    $dorduncu   = rand(1000,9999);
    $aktSonuc = $birinci ."-". $ikinci ."-". $ucuncu ."-".$dorduncu;
    return $aktSonuc;
}


function FiyatBicimlendir($Parametre){
    $Islem = number_format($Parametre,"2",",",".");
    return $Islem;
}

function UcGunIleriTarihiBul(){
    global $ZamanDamgasi;
    $BirGun = 86400;
    $Hesapla = $ZamanDamgasi + (3*$BirGun);
    $TarihBiciminiDonustur = date("d.m.Y",$Hesapla);
    return $TarihBiciminiDonustur;
}

function VerotIcinResimKlasorYolu(){
    $SiteKokDizini = $_SERVER["DOCUMENT_ROOT"];
    $SiteKokDizini = $SiteKokDizini."/php/Resimler/";
    return $SiteKokDizini;
}

function VerotIcinResimKlasorYoluBanner(){
    $SiteKokDizini = $_SERVER["DOCUMENT_ROOT"];
    $SiteKokDizini = $SiteKokDizini."/php/Resimler/Banner/";
    return $SiteKokDizini;
}

function ResimIcinDosyaAdiOlustur(){
    $Islem = md5(uniqid(time(), true));
    return $Islem;
}















?>


























