<?php 
require 'commun_services.php'; 

if( !isset($_REQUEST["firstname"]) || !isset($_REQUEST["lastname"])
|| !isset($_REQUEST["password"])|| !isset($_REQUEST["email"]) || !isset($_REQUEST["type"]) ){
    produceErrorRequest();
    return;
}
if( empty($_REQUEST["email"]) || empty($_REQUEST["password"])
 || empty($_REQUEST["firstname"]) || empty($_REQUEST["lastname"]) || empty($_REQUEST["type"])  ){
    produceErrorRequest();
    return;
}

//normal 1
//google 2

$user = new UserEntity();
$user->setFirstname($_REQUEST["firstname"]);
$user->setLastname($_REQUEST["lastname"]);
$user->setEmail($_REQUEST["email"]);
$user->setPassword($_REQUEST["password"]);
$user->settype($_REQUEST["type"]);

try {
    $data = $db->createUser($user);

    if($data){
        // setLastInsertId($data);
        produceResult($data);
    }else{
        produceError("Problème rencontré lors de la création du compte");
    }
} catch (Exception $th) {
    produceError($th->getMessage());
}




?>