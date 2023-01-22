<?php
require 'commun_services.php';

if(!isset($_REQUEST["firstname"]) || !isset($_REQUEST["lastname"])
||  !isset($_REQUEST["email"]) ){
    produceErrorRequest();
    return;
}
if(empty($_REQUEST["firstname"]) || empty($_REQUEST["lastname"])
|| empty($_REQUEST["email"])){
    produceErrorRequest();
    return;
}

$user = new UserEntity();
$user->setFirstname($_REQUEST["firstname"]);
$user->setLastname($_REQUEST["lastname"]);
$user->setEmail($_REQUEST["email"]);

try {
    $data = $db->updateUsers($user);

    if($data){
        produceResult('modification réussie ;');
    }else {
        produceError("Echec de la mise à jour. Merci de réessayer !");
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}

?>