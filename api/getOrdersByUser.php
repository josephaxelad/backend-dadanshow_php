<?php 
require 'commun_services.php';

if(!isset($_REQUEST['emailUser'])){
    produceErrorRequest();
    return;
}

if( empty($_REQUEST['emailUser']) ) {
    produceErrorRequest();
    return;
}

try {
    $orders = $db->getOrdersByUser($_REQUEST['emailUser']);
    if($orders){
        produceResult(clearDataArray($orders));
    }else {
        produceError($orders);
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}



?>