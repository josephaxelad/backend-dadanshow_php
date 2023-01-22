<?php 
require 'commun_services.php';

try {
    $deliveriesZone = $db->getDeliveriesZone();
    if($deliveriesZone){
        produceResult(clearDataArray($deliveriesZone));
    }else {
        produceError("Problème de Récupération des zones de livraison");
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}



?>