<?php

/**
 * ordersEntity.php
 * @author Espero-Soft Informatique
 * site Web : espero-soft.com
 */
class OrdersEntity{

    protected  $idOrder;

    protected  $idUser;

    protected  $emailUser;

    protected  $idProduct;

    protected  $quantity;

    protected  $price;
    
    protected  $createDat;

    protected  $cmdLine;

    protected  $deliveryPrice;

    protected  $state;

    protected  $delivery;

    function getIdOrder() { 
        return $this->idOrder; 
   } 

   function setIdOrder($idOrder) {  
       $this->idOrder = $idOrder; 
   } 

   function getIdUser() { 
        return $this->idUser; 
   } 

   function setIdUser($idUser) {  
       $this->idUser = $idUser; 
   } 

   function getIdProduct() { 
        return $this->idProduct; 
   } 

   function setIdProduct($idProduct) {  
       $this->idProduct = $idProduct; 
   } 

   function getQuantity() { 
        return $this->quantity; 
   } 

   function setQuantity($quantity) {  
       $this->quantity = $quantity; 
   } 

   function getPrice() { 
        return $this->price; 
   } 

   function setPrice($price) {  
       $this->price = $price; 
   } 

   function getCreatedat() { 
        return $this->createDat; 
   } 

   function setCreatedat($createDat) {   
       $this->createDat =$createDat; 
   } 

   function getCmdLine()
   {
     return $this->cmdLine;
   }

   function setCmdLine($cmdLine)
   {
     $this->cmdLine = $cmdLine;
   }

   function getDeliveryPrice()
   {
     return $this->deliveryPrice;
   }

   function setDeliveryPrice($deliveryPrice)
   {
     $this->deliveryPrice = $deliveryPrice ;
   }

   function getState()
   {
     return $this->state;
   }

   function setState($state)
   {
     $this->state = $state ;
   }

   function getEmailUser()
   {
     return $this->emailUser;
   }

   function setEmailUser($emailUser)
   {
     $this->emailUser = $emailUser ;
   }

   function getDelivery()
   {
     return $this->delivery;
   }

   function setDelivery($delivery)
   {
     $this->delivery = $delivery ;
   }

}



	
?>