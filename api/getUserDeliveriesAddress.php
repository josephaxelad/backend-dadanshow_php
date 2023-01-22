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
    $users = $db->getUserDeliveriesAddress($_REQUEST["emailUser"]);

    if($users){
        produceResult(returnResult($users));
         // produceResult(clearDataArray($users));
       
    }else {
        produceError("");
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}



?>