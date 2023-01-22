<?php

/**
 * userEntity.php
 * @author Espero-Soft Informatique
 * Site Web : espero-soft.com
 */

class UserEntity{

    protected $idUser;

    protected   $pseudo;

    protected   $email;

    protected   $sexe;

    protected   $password;

    protected   $firstname;

    protected   $lastname;

    protected   $description;

    protected   $deliveryAddress;

    protected   $adresseFactutation;

    protected   $tel;

    protected   $dateBirth;
    
    protected   $createdAt;

    protected   $type;

    function getIdUser() { 
        return $this->idUser; 
   } 

   function setIdUser($idUser) {  
       $this->idUser = $idUser; 
   } 

   function getPseudo() { 
        return $this->pseudo; 
   } 

   function setPseudo($pseudo) {  
       $this->pseudo = $pseudo; 
   } 

   function getEmail() { 
        return $this->email; 
   } 

   function setEmail($email) {  
       $this->email = $email; 
   } 

   function getSexe() { 
        return $this->sexe; 
   } 

   function setSexe($sexe) {  
       $this->sexe = $sexe; 
   } 

   function getPassword() { 
        return $this->password; 
   } 

   function setPassword($password) {  
       $this->password = $password; 
   } 

   function getFirstname() { 
        return $this->firstname; 
   } 

   function setFirstname($firstname) {  
       $this->firstname = $firstname; 
   } 

   function getLastname() { 
        return $this->lastname; 
   } 

   function setLastname($lastname) {  
       $this->lastname = $lastname; 
   } 

   function getDescription() { 
        return $this->description; 
   } 

   function setDescription($description) {  
       $this->description = $description; 
   } 

   function getDeliveryAddress() { 
    return $this->deliveryAddress; 
    } 

    function setDeliveryAddress($deliveryAddress) {  
    $this->deliveryAddress = $deliveryAddress; 
    } 

    function getAdresseFactutation() { 
        return $this->adresseFactutation; 
    } 

    function setAdresseFactutation($adresseFactutation) {  
    $this->adresseFactutation = $adresseFactutation; 
    } 

   function getTel() { 
        return $this->tel; 
   } 

   function setTel($tel) {  
       $this->tel = $tel; 
   } 

   function getDateBirth() { 
        return $this->dateBirth; 
   } 

   function setDateBirth($dateBirth) {  
       $this->dateBirth = $dateBirth; 
   } 

   function getCreatedAt() { 
        return $this->createdAt; 
   } 

   function setCreatedAt($createdAt) {  
       $this->createdAt = $createdAt; 
   } 

    function getType() { 
        return $this->type; 
   } 

   function setType($type) {  
       $this->type = $type; 
   } 

}



	

	
?>