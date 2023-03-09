<?php
	/// Librairies éventuelles (pour la connexion à la BDD, etc.)
    require_once('../Fonction/functionSERVER.php');
    /// Paramétrage de l'entête HTTP (pour la réponse au Client)
    header("Content-Type:application/json");
    /// Identification du type de méthode HTTP envoyée par le client
    $http_method = $_SERVER['REQUEST_METHOD'];

    switch ($http_method){
    	/// Cas de la méthode GET
    	case "GET" :
		    /// Récupération des critères de recherche envoyés par le Client
			///Mise en place fonction
			///gestion erreur
    		/// Envoi de la réponse au Client
			deliver_response(200, "", $matchingData);
	    break;
    	/// Cas de la méthode POST
	    case "POST" :
		    /// Récupération des données envoyées par le Client
		    ///Mise en place fonction
			///gestion erreur
		    /// Envoi de la réponse au Client
		    deliver_response(200, "", $matchingData);
	    break;
    	/// Cas de la méthode PATCH
	    case "PATCH" :
		    /// Récupération des données envoyées par le Client
		    ///Mise en place fonction
			///gestion erreur
		    /// Envoi de la réponse au Client
		    deliver_response(200, "", $matchingData);
	    break;
    	/// Cas de la méthode DELETE
	    case "DELETE" :
		    /// Récupération de l'identifiant de la ressource envoyé par le Client
		    ///Mise en place fonction
			///gestion erreur
		    /// Envoi de la réponse au Client
		    deliver_response(200, "", $matchingData);
	    break;
		default:
			/// Récupération des critères de recherche envoyés par le Client
			///Mise en place fonction
			///gestion erreur
			/// Envoi de la réponse au Client
			deliver_response(200, "", $matchingData);
		break;
	}
	
	/// Envoi de la réponse au Client
	function deliver_response($status, $status_message, $data){
	    /// Paramétrage de l'entête HTTP, suite
		header("HTTP/1.1 $status $status_message");
		/// Paramétrage de la réponse retournée
		$response['status'] = $status;
		$response['status_message'] = $status_message;
		$response['data'] = $data;
		/// Mapping de la réponse au format JSON
		$json_response = json_encode($response);
		echo $json_response;
	}
?>
