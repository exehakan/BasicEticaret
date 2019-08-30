<?php

class Kisaltmalar{
    public $foreachDonguDegeri;
    public function yazdir($parametre){
        echo $parametre;
    }

    public function setEdilmisse($parametre){
        return isset($parametre);
    }

    public function setEdilmisIseSession($parametre){
        return isset($_SESSION[$parametre]);
    }

    public function setEdilmisIseGET($Gelen){
        return isset($_GET[$Gelen]);
    }


    public function GetVeyaPOST($gelen){
        return $_REQUEST[$gelen];
    }


    public function Bosdegilise($deger){
        return $deger != "";
    }

    public function HTMLYazdir($deger){
       $this->yazdir($deger);
    }

    public function sayiBicimlendir($islemDegeri,$kacKarakter,$Ayrac,$Bos){
        return number_format($islemDegeri,$kacKarakter,$Ayrac,$Bos);
    }

    public function SayiyiYukariYuvarla($parametre){
        return ceil($parametre);
    }

    public function YukariYuvarla($parametre){
        $this->yazdir(ceil($parametre));
    }

    public function SetEdilmisIseGETvePOST($parametre){
        return $this->setEdilmisse($this->GetVeyaPOST($parametre));
    }


    public function BilgilendiriciKapat(){
        echo "</pre>";
    }

    public function KodlariEngelle(){
        return die();
    }

    public function Bilgilendirici($gelen){
        echo "<pre>";
        return print_r($gelen);
        $this->BilgilendiriciKapat();
    }





}






$e = new Kisaltmalar();