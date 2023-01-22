<?php 
	require 'commun_services.php';

	if(!isset($_REQUEST["deliveryAddress"]) || !isset($_REQUEST["email"])){
    produceErrorRequest();
    return;
}
if(empty($_REQUEST["deliveryAddress"]) || empty($_REQUEST["email"])){
    produceErrorRequest();
    return;
}

$user = new UserEntity();
$user->setDeliveryAddress($_REQUEST["deliveryAddress"]);
$user->setEmail($_REQUEST["email"]);


try {
    $data = $db->updateUserDeliveriesAddress($user);

    if($data){
        produceResult('modification réussie ;');
        // produceResult($data);
    }else {
        produceError("Echec de la mise à jour. Merci de réessayer !");
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}

?>