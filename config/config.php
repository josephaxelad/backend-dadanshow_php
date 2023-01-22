  <?php
    /**
     * config.php
     * @author Espero-Soft Informatique
     * Site Web : espero-soft.com
     */

    define("DB_USER","root");
    define("DB_PASSWORD","");
    define("HOST", "localhost");
    define("DB_NAME", "ecommerce");

    // define("DB_USER","u933189471_josephaxelad");
    // define("DB_PASSWORD","n4141O154");
    // define("HOST", "localhost");
    // define("DB_NAME", "u933189471_ecommerce");

    // define("DB_USER","fbvmsxcm_josephaxelad");
    // define("DB_PASSWORD","josephaxeladn4141O154");
    // define("HOST", "localhost");
    // define("DB_NAME", "fbvmsxcm_ecommerce");

    $METHODES = [
      "get"=>["description"=>"Lire les données","prefixe"=>"get" ],
      "post"=>["description"=>"Créer une donnée","prefixe"=>"create" ],
      "put"=>["description"=>"Mettre à jour une donnée","prefixe"=>"update" ],
      "delete"=>["description"=>"Supprimer une donnée", "prefixe"=>"delete"],
       
    ];

    $_ROUTES = ["products", "category", "orders","users"];

?>

