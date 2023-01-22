<?php 
require 'commun_services.php';

if(!isset($_REQUEST['emailUser']) || !isset($_REQUEST['price']) 
|| !isset($_REQUEST['createDate']) || !isset($_REQUEST['cmdLine'])
 || !isset($_REQUEST['deliveryPrice']) || !isset($_REQUEST['state']) || !isset($_REQUEST['delivery'])){
    produceErrorRequest();
    return;
}

if( empty($_REQUEST['emailUser']) || empty($_REQUEST['price']) || empty($_REQUEST['createDate']) 
    || empty($_REQUEST['cmdLine']) || empty($_REQUEST['deliveryPrice']) || empty($_REQUEST['state']) || empty($_REQUEST['delivery']) ) {
    produceErrorRequest();
    return;
}

 try {
    $order = new OrdersEntity();
    $order->setEmailUser($_REQUEST['emailUser']);
    $order->setPrice($_REQUEST['price']);
    $order->setCreatedat($_REQUEST['createDate']);
    $order->setCmdLine($_REQUEST['cmdLine']);
    $order->setDeliveryPrice($_REQUEST['deliveryPrice']);
    $order->setState($_REQUEST['state']);
    $order->setDelivery($_REQUEST['delivery']);

    $result = $db->createOrders($order);

    if($result){
        setLastInsertId($result);
        produceResult("Commande créée avec succès");
    }else {
        produceError("Erreur lors de la création de la commande. Merci de réessayer !");
    }

 } catch (Exception $th) {
     produceError($th->getMessage());
 }


?>