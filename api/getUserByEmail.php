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
    $user = $db->getUserByEmail($_REQUEST["emailUser"]);

    if($user){
        // produceResult(clearDataArray($categories));
        // produceResult(returnResult($user));
        produceResult(clearData($user));
       
    }else {
        produceError("");
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}



?>