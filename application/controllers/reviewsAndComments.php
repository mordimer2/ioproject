<?php

//wystawiwanie ocen i komentarza => zapis do bazy danych
//+ sprawdzenie czy user moze wystaić ocenę
    class reviewsAndComments extends dbConnection{
        //Właściwości
       // public $id;
        public $pracodawca;
        public $pracownik;
        public $kat1;
        public $kat2;
        public $kat3;
        public $kat4;
        public $kat5;
        public $komentarz;
        // Konstruktor
        public function __construct($pracodawca, $pracownik, $kat1, $kat2, $kat3, $kat4, $kat5, $komentarz) {
          //$this->id = $id;
          $this->pracodawca = $pracodawca;
          $this->pracownik = $pracownik;
          $this->kat1 = $kat1;
          $this->kat2 = $kat2;
          $this->kat3 = $kat3;
          $this->kat4 = $kat4;
          $this->kat5 = $kat5;
          $this->komentarz = $komentarz;
        }
        // Metody
        public function pokazOcena(){   // podejrzenie wartości obiektu (do testów)
          //echo $this->id .'<br>';
          echo $this->pracodawca.'<br>';
          echo $this->pracownik.'<br>';
          echo 'Pierwsza kategoria: '. $this->kat1.'<br>';
          echo 'Druga kategoria: '.$this->kat2.'<br>';
          echo 'Trzecia kategoria: '.$this->kat3.'<br>';
          echo 'Czwarta kategoria: '.$this->kat4.'<br>';
          echo 'Czwarta kategoria: '.$this->kat5.'<br>';
          echo $this->komentarz.'<br>';
        }
        public function checkEmptyFields(){
          if(empty($this->pracodawca) || empty($this->pracownik) || 
            empty($this->kat1) || empty($this->kat2) ||
            empty($this->kat3) || empty($this->kat4) ||
            empty($this->kat5) || empty($this->komentarz) ||
            $this->kat1 > 5 || $this->kat2 > 5 ||
            $this->kat3 > 5 || $this->kat4 > 5 ||
            $this->kat5 > 5 || $this->kat1 < 0 ||
            $this->kat2 < 0 || $this->kat4 < 0 ||
            $this->kat5 < 0){
              return 1;
          }
        }
        public function zapisz($id){   
            $zapytanie = $this->connect()->prepare("INSERT oceny (Pracodawca, Pracownik, Kat1, Kat2, Kat3, Kat4,Kat5, Komentarz) VALUES (?,?,?,?,?,?,?,?)");
            $zapytanie->bind_param("ssiiiiis",$this->pracodawca,$this->pracownik,$this->kat1,$this->kat2,$this->kat3,$this->kat4,$this->kat5,$this->komentarz);
            $zapytanie->execute();
            $zapytanie->close();

              $el = 1;
            $zapytanie = $this->connect()->prepare("UPDATE historiazatrudnienia  SET czyWystawionaOcena=? WHERE PracodawcaID=?");
            $zapytanie->bind_param('ii',$el,$id);
            $zapytanie->execute();
            $zapytanie->close();
          
        }

    }
?>
