<?php

/**
 * DeliveryZoneEntity.php
 * @author Espero-Soft Informatique
 * site Web : espero-soft.com
 */
class DeliveryZoneEntity{

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
    protected $description;


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

    function getDescription() { 
            return $this->description; 
    } 

    function setDescription($description) {  
        $this->description = $description; 
    } 
}