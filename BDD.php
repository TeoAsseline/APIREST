<?php
    function ConnexionBDD(){
        ///Connexion au serveur MySQL avec PDO
        $server = '145.14.156.192';
        $login = 'u563109936_teoarthur';
        $mdp = '$B5zN1gN52r';
        $db = 'u563109936_APIREST_articl';
        try {
            $linkpdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8mb4", $login, $mdp);
            $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        ///Capture des erreurs éventuelles
        catch (Exception $e) {
            die('Erreur : ' . $e->getMessage());
        }
        return $linkpdo;
    }
?>