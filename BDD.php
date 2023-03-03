<?php
        function ConnexionBDD(){
            ///Connexion au serveur MySQL avec PDO
            $server = 'localhost';
            $login  = 'root';
            $mdp    = '';
            $db     = 'chucknfacts';
            try {
                $linkpdo = new PDO("mysql:host=$server;dbname=$db;charset=UTF8", $login, $mdp);
                $linkpdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            ///Capture des erreurs éventuelles
            catch (Exception $e) {
                die('Erreur : ' . $e->getMessage());
            }
            return $linkpdo;
        }
?>