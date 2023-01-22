<?php

/**
 * CountryEntity.php
 * @author Espero-Soft Informatique
 * site Web : espero-soft.com
 */
class CountryEntity{

    /**
     * Identifiant de la categorie
     */
    protected $id;

    /**
     * Le nom de la categorie
     */
    protected $name;

    /**
     * Le nom de la categorie
     */
    protected $idDeliveryZone;

    /**
     * Le nom de la categorie
     */
    protected $code;

    /**
     *  Getter et Setter
     */
    function getId() { 
        return $this->id; 
    } 

    function setId($id) {  
        $this->id = $id; 
    } 

    function getName() { 
        return $this->icon; 
    } 

    function setName($name) {  
        $this->name = $name; 
    } 

    function getIdDeliveryZone() { 
            return $this->idDeliveryZone; 
    } 

    function setIdDeliveryZone($idDeliveryZone) {  
        $this->idDeliveryZone = $idDeliveryZone; 
    } 

    function getCode() { 
        return $this->code; 
    } 

    function setCode($code) {  
        $this->code = $code; 
    } 

 


}



	
?>