 <?php
    class Generic{
        //muutujad, klassis nimetatakse neid omadusteks(properies)
        //privaat muutjuad, valjaspoolt klassi kutsuda ei saa
        private $mysecret;
        //avalikud muutujad, saab kusida vajaspoolt klassi
        public $yoursecret;

        //funktsioonid
        function __construct(){
            //laheb kaima siis kui objekt luuakse, klass toole laheb, voimalikult vahe asju, hadavajalikud, 
            $this->mysecret = mt_rand(0, 10);
            $this->yoursecret = mt_rand(0, 100);

        }

    }
