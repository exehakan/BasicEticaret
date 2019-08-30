function borderTemizle(el) {
    $(el).css(VarsayilanDegerleriSifirla());
}

function AltBosluk(el) {
    $(el).css({marginBottom:"20px"})
}

function BankaKartiEkle(el){
    $(el).css({
        lineHeight:function(){
            return $(el).parent().height() + 'px'
        },

    });
}

function SelectAlanininGenisliginiDuzenle(el){
    var ElementinMevcutGenisligi = $(el).width();
    $(el).css({
        width:"61%"
    });
}


