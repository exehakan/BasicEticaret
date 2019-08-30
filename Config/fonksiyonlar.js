//Javascript / Jquery Script Document Kodlari;
//Pencere yüklendiğinde yapılacak işlemler
window.addEventListener("load",function(){
   /*-- $("body").fadeOut(0); // Window açılmadan hemen önce Body etiketinin opacity değerini 0 yapar.
    $("body").fadeTo("slow",1); //window(pencere) yüklendiğinden DOM hazir hale gelir gelmez opacity 0'dan arttirilarak 1 olucak yani tam görüntülenecek seviyeye getirilir.*/
    $(".YonetimPaneliYoneticiGirisSayfasiKapsamaAlani").fadeOut(0);
    $(".YonetimPaneliYoneticiGirisSayfasiKapsamaAlani").fadeTo("slow",1);

});

//Dökümantasyon hazir bir sekilde yüklendiğinde calisacak kod bloklari
$(document).ready(function(){

    var kayitSayisi = $(".BankaHesapBilgileri").length;
    var Sayi = 0;
    function MetodIslemleri(){
    var rastgeleRenkler = ["#e55039","#60a3bc","#1e3799","#b71540","#0c2461","#0a3d62","#079992","#38ada9","#e58e26"];
    var rastgeleRenkSayisalIslemleri = rastgeleRenkler.length;
    var rastgeleAlgoritma = Math.trunc(Math.random() * rastgeleRenkSayisalIslemleri);
    var AlgoSonuc = rastgeleRenkler[rastgeleAlgoritma];
        $(".BankaHesapBilgileri").eq(Sayi).show(function () {
            $(this).fadeTo("slow",1000,function(){
                //tamamlandiğinda
                $(this).css({
                    transition:"500ms linear all",
                    //Algo Sonuca sadece rastgele renk vermemesi için bir renk kodu atadık eğer renk kodunu kaldirip sadece AlgoSonuc'u yazarsak rastgele algoritmaya göre renklendirme işlemi yapacaktir
                    borderRadius:"5px",
                })
            })
        });


        if(Sayi == kayitSayisi){
            clearInterval(zamanlama);
        }
        Sayi++;
    }
   var zamanlama =  setInterval(MetodIslemleri,400);


    //İnput max karakter engelleme
    var dizi = [];
    $("#TelefonNumarasijQuery").on("keypress",function(event){

        var depo = $(this).val();
        if(depo.length!=11){
            dizi.unshift($(this).val());
        }else{
            $("#TelefonNumarasijQuery").val(dizi[0]);
        }
    });


    //SIK SORULAN SORULAR SAYFASİ İCİN (DESTEK);

    $.SoruIceriginiGoster = function(deger){
        $SoruId = deger;
        $SoruHazirlama = "#" + $SoruId;
        $CevapIslemleri = "#A" + $SoruId;
        $(".cevap").slideUp();
        $($SoruHazirlama).parent().find($CevapIslemleri).slideToggle("slow");
    };

    $("#BicimsizSifatsizAETiketi").hover(function(){
        $(this).css({
            textDecoration:"underline",
            transition: "500ms ease all"
        })
    },function(){
        $(this).css({
            textDecoration:"none"
        })
    });


    $.ResimOnizlemeFonksiyonu = function(KlasorYolu,ResimDosyasiAdi){
        $("#DEVResim").hide();
        $("#DEVResim").attr("src","Resimler/UrunResimleri/"+KlasorYolu+"/"+ResimDosyasiAdi).fadeIn(300);
    }


    $.KrediKartiSecildiAlani = function(){
        $(".BHAlanlari").css({display:"none"});
        $(".KKAlanlari").css({display:"block"});
    }

    $.BankaHavalesiSecildi = function(){
        $(".BHAlanlari").css({display:"block"});
        $(".KKAlanlari").css({display:"none"});
    }

    var sayi = 0;
    if(window.location.href == "http://localhost/php/" || window.location.href == "http://localhost/php/index.php"){
        setInterval(()=>{
            sayi++;
            $(".AnaSayfaBannerAlani").hide().fadeIn("1000");
            $(".AnaSayfaBannerAlani").attr("src" ,"Resimler/Banner/"+ sayi +".jpg");
            if(sayi == 2){
                sayi =0;
            }
        },1000)
    }

    $(".YonetimPaneliSolMenuElemanlari").hover(function(){
        $(".YonetimPaneliSolMenuListeAlani").css({
            transition:"500ms linear all",
            backgroundColor:"rgba(21,18,42,0.2)",
        });

    },function(){
        $(".YonetimPaneliSolMenuListeAlani").css({
            transition:"500ms linear all",
            backgroundColor:"#201d5633",
        })
    })

    $("form .InputAciklamaMetinleriKapsamaAlani :input").each(function(event,veri){
        var inputlar = $(this);
        inputlar.attr("spellcheck",false);

    })




































}); // jQuery Document END



























