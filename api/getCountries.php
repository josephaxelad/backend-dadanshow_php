<?php 
require 'commun_services.php';

try {
    $countries = $db->getCountries();
    if($countries){
        produceResult(clearDataArray($countries));
    }else {
        produceError("Problème de Récupération de la liste des pays");
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}



?>
