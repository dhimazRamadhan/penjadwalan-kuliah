<?php 
    class mobil{ //class
        function roda(){
            //isi
        }
        function mesin(){
            //isi
        }
    }
    $laptop_saya = new mobil(); //objek = #laptop saya akan memiliki semua properti & method daari class laptop

    // buat class laptop
    class laptop {
    
    // buat property untuk class laptop
    var $pemilik;
    var $merk;
    
    // buat method untuk class laptop
    function hidupkan_laptop() {
        return "Hidupkan Laptop";
        }
    function matikan_laptop() {
        return "Matikan Laptop";
    }
    }
    
    // buat objek dari class laptop (instansiasi)
    $laptop_anto = new laptop();
    
    // set property
    $laptop_anto->pemilik="Anto";
    $laptop_anto->merk="Asus";
    
    // tampilkan property
    echo $laptop_anto->pemilik;
    echo "<br />";
    echo $laptop_anto->merk;
    echo "<br />";
    
    // tampilkan method
    echo $laptop_anto->hidupkan_laptop();
    echo "<br />";
    echo $laptop_anto->matikan_laptop();

?>