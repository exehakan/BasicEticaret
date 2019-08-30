
var elementListeleri = ["img","div","span","a","table","tr","td","textarea","select"];
$.each(elementListeleri,function(index,elementisimleri){

    var test = $(elementisimleri).each(function(indis,element){
        let OlayEventKontrolu = element.hasAttribute("olay");
        let animastonKontrolleri = element.hasAttribute("animasyon");
        let standartEventlar = element.hasAttribute("onmouseover");




        if(OlayEventKontrolu == true || standartEventlar == true || animastonKontrolleri == true && ScrollAnimasyonOzel == true){
            eval(element.getAttribute("olay"));
            if(animastonKontrolleri == true){
                let AnimasyonDegeri = element.getAttribute("animasyon");
                if ( AnimasyonDegeri== "evet"){
                    $(element).hide();
                    $(element).slideToggle(400);
                }else if(AnimasyonDegeri == "OpacityEffect"){
                    $(element).hide();
                    $(element).fadeTo("slow",1);
                }
            }

        }
    })
})


