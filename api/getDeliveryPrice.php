<?php 
require 'commun_services.php';

if(!isset($_REQUEST['idDeliveryZone']) || !isset($_REQUEST['cartWeight']) ){
    produceErrorRequest();
    return;
}

if( empty($_REQUEST['idDeliveryZone']) || empty($_REQUEST['cartWeight'])) {
    produceErrorRequest();
    return;
}

try {
    $deliveryPrice = $db->getDeliveryPrice($_REQUEST['idDeliveryZone'],$_REQUEST['cartWeight']);
    if($deliveryPrice){
        produceResult(returnResult($deliveryPrice));
    }else {
        produceError("Problème de récupération du prix");
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}



?>