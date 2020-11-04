 <?php
    class Generic{
        //muutujad, klassis nimetatakse neid omadusteks(properies)
        //privaat muutjuad, valjaspoolt klassi kutsuda ei saa
        private $mysecret;
        //avalikud muutujad, saab kusida vajaspoolt klassi
        public $yoursecret;

        //funktsioonid
        function __construct($secretlimit){
            //laheb kaima siis kui objekt luuakse, klass toole laheb, voimalikult vahe asju, hadavajalikud, 
            $this->mysecret = mt_rand(0, $secretlimit);
            $this->yoursecret = mt_rand(0, 100);
            echo "Loositud arvude korrutis on: " .$this->mysecret * $this->yoursecret;
            $this->tellSecret();
        }


        //meetodid
        private function tellSecret(){
            echo "Naidisklass on mottetu.";
        }

        public function showValue(){
            echo "Salajane arv on " .$this->mysecret;
        }

        function __destruct(){
            // kaivitub kui objekt suletakse
            echo "Selleks korraks koik";
        }
    }
