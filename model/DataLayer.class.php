<?php

/**
 * DataLayer.class.php
 * @author Espero-Soft Informatique
 * Site Web : espero-soft.com
 */

class DataLayer{

    private $connexion;


    function __construct()
    {
        $var = "mysql:host=".HOST.";db_name=".DB_NAME;
        

        try {
            $this->connexion = new PDO($var,DB_USER,DB_PASSWORD);
            //echo "connexion réussie";
            $this->connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);


        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Méthode permettant d'authentifier un utilisateur 
     * @param UserEntity $user Objet métier décrivant un utilisateur 
     * @return UserEntity $user Objet métier décrivant l'utilisateur authentifié
     * @return FALSE En cas d'échec d'authentification
     * @return NULL Exception déclenchée 
    */
    function authentifier(UserEntity $user){
        $sql = "SELECT * FROM ".DB_NAME.".`customers` WHERE email = :email";

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ':email'=>$user->getEmail()
            ));

            $data = $result->fetch(PDO::FETCH_OBJ);

            if($data && ($data->password == sha1($user->getPassword()))){
                // authentification réussie
                $user->setIdUser($data->id);
                $user->setSexe($data->sexe);
                $user->setFirstname($data->firstname);
                $user->setLastname($data->lastname);
                $user->setPassword(NULL);
                $user->setAdresseFactutation($data->adresse_facturation);
                $user->setAdresseLivraison($data->adresse_livraison);
                $user->setTel($data->tel);
                $user->setDateBirth($data->dateBirth);

                return $user;

            }else{
                // authentification échouée
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }
    }

    
    /**
     * Methode permettant de créer un utilisateur en BD 
     * @param UserEntity $user Objet métier décrivant un un utilisateur
     * @return TRUE Persistance réussie
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */

    function createUser(UserEntity $user){
        $sql_ = "SELECT  COUNT(*) AS nb FROM ".DB_NAME.".`customers` WHERE email = :email";
        try{
            $result_ = $this->connexion->prepare($sql_);
            $var_ = $result_->execute(array(
                ':email'=>$user->getEmail()
            ));

            $data_ = $result_->fetch(PDO::FETCH_OBJ);

            if ((int)$data_->nb<1) {
                $sql = "INSERT INTO ".DB_NAME.".`customers` (email,password,firstname,lastname,type)
                VALUES (:email,:password,:firstname,:lastname,:type)";

                try {
                    $result = $this->connexion->prepare($sql);
                    $data = $result->execute(array(
                    ':email' => $user->getEmail(),
                    ':password' => sha1($user->getPassword()),
                    ':firstname' => $user->getFirstname(),
                    ':lastname' => $user->getLastname(),
                    ':type' => $user->getType(),
                    ));
                    //var_dump($sql);
                    if($data){
                        return "Compte utilisateur créé avec succès";
                        // return $this->connexion->lastInsertId();
                    }else {
                        return FALSE;
                    }
                } catch (PDOException $th) {
                    return $th->getMessage();
                }

            } else {
                // $dat =(object)$data_
                return "L'utilisateur exite déja";
            }
            
        }catch(PDOException $th){
            return $th->getMessage();
        }
    }

    /**
     * Methode permettant de créer une categorie en BD 
     * @param CategoryEntity $category Objet métier décrivant une categorie
     * @return TRUE Persistance réussie
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function createCategory(CategoryEntity $category){
        $sql = "INSERT INTO ".DB_NAME.".`category`(`category`,`icon`) VALUES (:name,:icon)";

        try {
            $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':name' => $category->getName(),
                ':icon' => $category->getIcon()
            ));
            if($data){
                return $this->connexion->lastInsertId();
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }
    }

    /**
     * Methode permettant de créer un produit en BD 
     * @param ProductEntity $product Objet métier décrivant un product
     * @return TRUE Persistance réussie
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function createProduct(ProductEntity $product){
        $sql ="INSERT INTO ".DB_NAME.".`product`(`name`, `description`, `price`, `stock`, `category`, `image`) 
        VALUES (:name,:description,:price,:stock,:category,:image)";
        try {
            $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':name'=> $product->getName(),
                ':description' => $product->getDescription(),
                ':price' => $product->getPrice(),
                ':stock' => $product->getStock(),
                ':category' => $product->getCategory(),
                ':image'=> $product->getImage()
            ));
            if($data){
                return $this->connexion->lastInsertId();
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }

    }
    /**
     * Methode permettant de créer une commande en BD 
     * @param OrdersEntity $order un objet metier décrivant une commande
     * @return TRUE Persistance réussie
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function createOrders(OrdersEntity $orders){
        $sql = "INSERT INTO ".DB_NAME.".`orders`(`email_user`, `price`, `createdat`, `cmd_line` ,`delivery_price`,`state`,`delivery`)
         VALUES (:email_user,:price,:createdat,:cmd_line,:delivery_price,:state,:delivery)";

        try {
            $result = $this->connexion->prepare($sql);
            $data = $result->execute(array(
                ':email_user'=>$orders->getEmailUser(),
                ':price'=>$orders->getPrice(),
                ':createdat' => $orders->getCreatedat(),
                ':cmd_line' => $orders->getCmdLine(),
                ':delivery_price' => $orders->getDeliveryPrice(),
                ':state' => $orders->getState(),
                ':delivery' => $orders->getDelivery()
            ));
            if($data){
                return $this->connexion->lastInsertId();
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            //return NULL;
            echo $th->getMessage();
        }
    }

    /**
     * Methode permettant de récupérer les utilisateur dans BD 
     * @param VOID ne prend pas de paramètre
     * @return ARRAY Tableau contenant les données utilisateurs
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function getUsers(){
        $sql = "SELECT * FROM ".DB_NAME.".`customers`";

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            $users = [];

            while($data = $result->fetch(PDO::FETCH_OBJ)){
                $user = new UserEntity();
                $user->setIdUser($data->id);
                $user->setEmail($data->email);
                $user->setSexe($data->sexe);
                $user->setFirstname($data->firstname);
                $user->setLastname($data->lastname);
                $users[] = $user;
            }

            if($users){
                return $users;
            }else{
                return FALSE;
            }


        } catch (PDOException $th) {
            return NULL;
        }
    }

    /**
     * Methode permettant de récupérer les catégories dans BD 
     * @param VOID ne prend pas de paramètre
     * @return ARRAY Tableau contenant les catégories
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function getCategory(){
        $sql = "SELECT * FROM ".DB_NAME.".`category`";

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            $categories = [];

            while($data = $result->fetch(PDO::FETCH_OBJ)){
                $category = new CategoryEntity();
                $category->setIdCategory($data->id);
                $category->setName($data->category);
                $category->setIcon($data->icon);

                $categories[] = $category;
            }

            if($categories){
                return $categories;
            }else{
                return FALSE;
            }


        } catch (PDOException $th) {
            return NULL;
        }
    }

     /**
     * Methode permettant de récupérer les produits dans BD 
     * @param VOID ne prend pas de paramètre
     * @return ARRAY Tableau contenant les produits
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function getProduct(){
        $sql = "SELECT * FROM ".DB_NAME.".`product`";
        //echo  $sql;exit();
        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            $products = [];

            while($data = $result->fetch(PDO::FETCH_OBJ)){
               $product = new ProductEntity();
               $product->setIdProduct($data->id);
               $product->setName($data->name);
               $product->setDescription($data->description);
               $product->setPrice($data->price);
               $product->setStock($data->stock);
               $product->setImage($data->image);
               $product->setCategory($data->category);
               $product->setCreatedAt($data->createdat);
               $product->setWeight($data->weight);

               $products[] = $product;
            }

            if($products){
                return $products;
            }else{
                return FALSE;
            }


        } catch (PDOException $th) {
            return NULL;
        }
    }

    function getProductById($id){
        $sql = "SELECT * FROM ".DB_NAME.".`product` WHERE id=:id";
        //echo  $sql;exit();
        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(":id",$id));
            
       
        if($var){
            $data = $result->fetch(PDO::FETCH_OBJ);
            $product = new ProductEntity();
            $product->setIdProduct($data->id);
            $product->setName($data->name);
            $product->setDescription($data->description);
            $product->setPrice($data->price);
            $product->setStock($data->stock);
            $product->setImage($data->image);
            $product->setCategory($data->category);
            $product->setCreatedAt($data->createdat);
        }
        if($product){
            return $product;
        }else{
            return FALSE;
        }

        } catch (PDOException $th) {
            return NULL;
        }
    }

     /**
     * Methode permettant de récupérer les commandes dans BD 
     * @param VOID ne prend pas de paramètre
     * @return ARRAY Tableau contenant les commande
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function getOrders(){
        $sql = "SELECT * FROM ".DB_NAME.".`orders`";

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            $orders = [];

            while($data = $result->fetch(PDO::FETCH_OBJ)){
                $order = new OrdersEntity();
                $order->setIdOrder($data->id);
                $order->setIdUser($data->id_customers);
                $order->setIdProduct($data->id_product);
                $order->setPrice($data->price);
                $order->setQuantity($data->quantity);
                $order->setCreatedAd($data->createdat);

                $orders[] = $order;
            }

            if($orders){
                return $orders;
            }else{
                return FALSE;
            }


        } catch (PDOException $th) {
            return NULL;
        }
    }

    function getOrdersByUser($userEmail){
    $sql = "SELECT * FROM ".DB_NAME.".`orders` WHERE email_user=:userEmail ORDER BY id DESC" ;

    try {
        $result = $this->connexion->prepare($sql);
        $var = $result->execute(array(":userEmail"=>$userEmail));
        $orders = [];

        while($data = $result->fetch(PDO::FETCH_OBJ)){
            $order = new OrdersEntity();
            $order->setIdOrder($data->id);
            $order->setEmailUser($data->email_user);
            $order->setDeliveryPrice($data->delivery_price);
            $order->setPrice($data->price);
            $order->setCmdLine(json_decode($data->cmd_line));
            $order->setState($data->state);
            $order->setCreatedat($data->createdat);
            $order->setDelivery(json_decode($data->delivery));

            $orders[] = $order;
            //array_push($orders, $order);
        }

        if($orders){
            return $orders;
        }else{
            return FALSE;
        }


    } catch (PDOException $th) {
        return NULL;
    }
    }
    

     /**
     * Methode permettant de mettre à jour des données d'un utilisateur dans BD 
     * @param UserEntity $user Objet métier décrivant un utilisateur
     * @return TRUE Mise à jour réussie
     * @return FALSE Echec de la mise à jour
     * @return NULL Exception déclenchée
     */
    function updateUsers(UserEntity $user){
         $sql = "UPDATE ".DB_NAME.".`customers` SET `firstname`=:firstname, `lastname`=:lastname WHERE email=:email";
         try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ':firstname' => $user->getFirstname(),
                ':lastname' => $user->getLastname(), 
                ':email'=> $user->getEmail(),              
            ));
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }


    }

    /**
     * Methode permettant de mettre à jour un produit dans BD 
     * @param ProductEntity $product Objet métier décrivant un produit
     * @return TRUE Mise à jour réussie
     * @return FALSE Echec de la mise à jour
     * @return NULL Exception déclenchée
     */
    function updateProduct(ProductEntity $product){
        $sql = "UPDATE ".DB_NAME.".`product` SET `name`=:name,`description`=:description,`price`=:price,
        `stock`=:stock,`category`=:category,`image`=:image WHERE id=:id";
         try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ':id' => $product->getIdproduct(),
                ':name' => $product->getName(),
                ':description' => $product->getDescription(),
                ':price' => $product->getPrice(),
                ':stock' => $product->getStock(),
                ':category' => $product->getCategory(),
                ':image'=>$product->getImage()
               
            ));
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        } 
    }

    /**
     * Methode permettant de mettre à jour une catégorie dans BD 
     * @param CategoryEntity $category Objet métier décrivant une categorie
     * @return TRUE Mise à jour réussie
     * @return FALSE Echec de la mise à jour
     * @return NULL Exception déclenchée
     */
    function updateCategory(CategoryEntity $category){
        $sql = "UPDATE ".DB_NAME.".`category` SET `category`=:name, `icon`=:icon WHERE id=:id";
        
        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ':name' => $category->getName(),
                ':icon' => $category->getIcon(),
                ':id' => $category->getIdcategory()
            ));
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }

        } catch (PDOException $th) {
            return NULL;
        }
    }

    /**
     * Methode permettant de mettre à jour une commande dans BD 
     * @param OrdersEntity $order Objet métier décrivant une commande
     * @return TRUE Mise à jour réussie
     * @return FALSE Echec de la mise à jour
     * @return NULL Exception déclenchée
     */
    function updateOrders(OrdersEntity $order){
        $sql = "UPDATE ".DB_NAME.".`orders` SET `id_customers`=:id_customers, `id_product`=:id_product, `quantity`=:quantity, `price`=:price
         WHERE id=:id";
        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ':id_customers' => $order->getIduser(),
                ':id_product' => $order->getIdproduct(),
                ':quantity' => $order->getQuantity(),
                ':price' => $order->getPrice(),
                ':id' => $order->getIdOrder()
            ));
            //var_dump($var);
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }
    }

       

    /**
     * Methode permettant de supprimer un utilisateur dans BD 
     * @param UserEntity $user Objet métier décrivant un utilisateur
     * @return TRUE Suppression réussie
     * @return FALSE Echec de la suppression
     * @return NULL Exception déclenchée
     */
    function deleteUsers(UserEntity $user){
        $sql = "DELETE FROM ".DB_NAME.".`customers` WHERE id=".$user->getIdUser();

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            //var_dump($sql); exit();
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }
    }

    /**
     * Methode permettant de supprimer un produit dans BD 
     * @param ProductEntity $product Objet métier décrivant un produit
     * @return TRUE Suppression réussie
     * @return FALSE Echec de la suppression
     * @return NULL Exception déclenchée
     */
    function deleteProduct(ProductEntity $product){
        $sql = "DELETE FROM ".DB_NAME.".`product` WHERE id=".$product->getIdProduct();

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            //var_dump($sql); exit();
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }
    }

    /**
     * Methode permettant de supprimer une categorie dans BD 
     * @param CategoryEntity $user Objet métier décrivant une categorie
     * @return TRUE Suppression réussie
     * @return FALSE Echec de la suppression
     * @return NULL Exception déclenchée
     */
    function deleteCategory(CategoryEntity $category){
        $sql = "DELETE FROM ".DB_NAME.".`category` WHERE id=".$category->getIdCategory();

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            //var_dump($sql); exit();
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }
    }

    /**
     * Methode permettant de supprimer une commande dans BD 
     * @param OrdersEntity $order Objet métier décrivant une commande
     * @return TRUE Suppression réussie
     * @return FALSE Echec de la suppression
     * @return NULL Exception déclenchée
     */
    function deleteOrders(OrdersEntity $order){
        $sql = "DELETE FROM ".DB_NAME.".`orders` WHERE id=".$order->getIdOrder();

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            //var_dump($sql); exit();
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        }
    }

    /**
     * Methode permettant de mettre à jour des données d'un utilisateur dans BD 
     * @param UserEntity $user Objet métier décrivant un utilisateur
     * @return TRUE Mise à jour réussie
     * @return FALSE Echec de la mise à jour
     * @return NULL Exception déclenchée
     */
    function updateUserDeliveriesAddress(UserEntity $user){

         $sql = "UPDATE ".DB_NAME.".`customers` SET `delivery_address`=:delivery_address WHERE email=:email";
         try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(
                ':email'=>$user->getEmail(),
                ':delivery_address' => $user->getDeliveryAddress(),           
            ));
            if($var){
                return TRUE;
            }else{
                return FALSE;
            }
        } catch (PDOException $th) {
            return NULL;
        } 

    }


    /**
     * Methode permettant de mettre à jour des données d'un utilisateur dans BD 
     * @param UserEntity $user Objet métier décrivant un utilisateur
     * @return TRUE Mise à jour réussie
     * @return FALSE Echec de la mise à jour
     * @return NULL Exception déclenchée
     */
    function getUserDeliveriesAddress($userEmail){
        
        //echo  $sql;exit();
        $sql = "SELECT * FROM ".DB_NAME.".`customers` WHERE email=:userEmail";
        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(":userEmail"=>$userEmail));
            // $users=[];

            if ($var) {
            $data = $result->fetch(PDO::FETCH_OBJ);
            // $user = new UserEntity();
            // $user->setDeliveryAddress(json_decode($data->delivery_address));

            $users= json_decode($data->delivery_address);
            }
            
            //array_push($orders, $order);
        

        if($users){
            return $users;
        }else{
            return FALSE;
        }

        } catch (PDOException $th) {
            return NULL;
        }

    }

    /**
     * Methode permettant de récupérer les commandes dans BD 
     * @param VOID ne prend pas de paramètre
     * @return ARRAY Tableau contenant les commande
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function getCountries(){
        $sql = "SELECT * FROM ".DB_NAME.".`country`";

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            $countries = [];

            while($data = $result->fetch(PDO::FETCH_OBJ)){
                $country = new CountryEntity();
                $country->setId($data->id);
                $country->setName($data->name);
                $country->setIdDeliveryZone($data->idDeliveryZone);
                $country->setCode($data->code);

                $countries[] = $country;
            }

            if($countries){
                return $countries;
            }else{
                return FALSE;
            }


        } catch (PDOException $th) {
            return NULL;
        }
    }

    /**
     * Methode permettant de récupérer les commandes dans BD 
     * @param VOID ne prend pas de paramètre
     * @return ARRAY Tableau contenant les commande
     * @return FALSE Echec de la persistance
     * @return NULL Exception déclenchée
     */
    function getDeliveriesZone(){
        $sql = "SELECT * FROM ".DB_NAME.".`delivery_zone`";

        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute();
            $deliveriesZone = [];

            while($data = $result->fetch(PDO::FETCH_OBJ)){
                $deliveryZone = new DeliveryZoneEntity();
                $deliveryZone->setId($data->id);
                $deliveryZone->setName($data->name);
                $deliveryZone->setDescription($data->description);

                $deliveriesZone[] = $deliveryZone;
            }

            if($deliveriesZone){
                return $deliveriesZone;
            }else{
                return FALSE;
            }


        } catch (PDOException $th) {
            return NULL;
        }
    }

    function getDeliveryPrice($idDeliveryZone,$cartWeight){
        switch ($idDeliveryZone) {
            case 1:
                if ($cartWeight>0 && $cartWeight<=3) {
                    return 10;
                }elseif ($cartWeight<=5) {
                    return 15;
                }elseif ($cartWeight<=7) {
                    return 25;
                }elseif ($cartWeight>7) {
                    return 30;
                }else{
                    return 0;
                }
                break;
            case 2:
                if ($cartWeight>0 && $cartWeight<=1) {
                    return 20;
                }elseif ($cartWeight<=2) {
                    return 33;
                }elseif ($cartWeight<=5) {
                    return 53;
                }elseif ($cartWeight<=7) {
                    return 60;
                }elseif ($cartWeight>7) {
                    return 65;
                }else{
                    return 0;
                }
                break;
            case 3:
                if ($cartWeight>0 && $cartWeight<=1) {
                    return 17;
                }elseif ($cartWeight<=2) {
                    return 20;
                }elseif ($cartWeight<=5) {
                    return 25;
                }elseif ($cartWeight<=7) {
                    return 30;
                }elseif ($cartWeight>7) {
                    return 35;
                }else{
                    return 0;
                }
                break;
            case 4:
                if ($cartWeight>0 && $cartWeight<=1) {
                    return 25;
                }elseif ($cartWeight<=2) {
                    return 27;
                }elseif ($cartWeight<=5) {
                    return 35;
                }elseif ($cartWeight<=7) {
                    return 40;
                }elseif ($cartWeight>7) {
                    return 50;
                }else{
                    return 0;
                }
                break;
            case 5:
                if ($cartWeight>0 && $cartWeight<=1) {
                    return 35;
                }elseif ($cartWeight<=2) {
                    return 45;
                }elseif ($cartWeight<=5) {
                    return 65;
                }elseif ($cartWeight<=7) {
                    return 70;
                }elseif ($cartWeight>7) {
                    return 80;
                }else{
                    return 0;
                }
                break;    
            default:
                
                break;
        }

    }

        /**
     * Methode permettant de mettre à jour des données d'un utilisateur dans BD 
     * @param UserEntity $user Objet métier décrivant un utilisateur
     * @return TRUE Mise à jour réussie
     * @return FALSE Echec de la mise à jour
     * @return NULL Exception déclenchée
     */
    function getUserByEmail($userEmail){
        
        //echo  $sql;exit();
        $sql = "SELECT * FROM ".DB_NAME.".`customers` WHERE email=:userEmail";
        try {
            $result = $this->connexion->prepare($sql);
            $var = $result->execute(array(":userEmail"=>$userEmail));
            // $users=[];

            if ($var) {
            $data = $result->fetch(PDO::FETCH_OBJ);
            $user = new UserEntity();
            $user->setFirstname($data->firstname);
            $user->setLastname($data->lastname);
            $user->setEmail($data->email);
            $user->setType($data->type);


            }
            
            //array_push($orders, $order);
        

        if($user){
            return $user;
        }else{
            return FALSE;
        }

        } catch (PDOException $th) {
            return NULL;
        }

    }

}



?>