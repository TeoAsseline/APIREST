<?php
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
	/// Librairies éventuelles (pour la connexion à la BDD, etc.)
	require_once("../Fonction/jwt_utils.php");
    require_once("../DAO/fonctionUser.php");
    /// Paramétrage de l'entête HTTP (pour la réponse au Client)
    header("Content-Type:application/json");
    
    /// Identification du type de méthode HTTP envoyée par le client
    $http_method = $_SERVER['REQUEST_METHOD'];
    switch ($http_method){
    	/// Cas de la méthode POST
	    case "POST" :
		    /// Récupération des données envoyées par le Client
		    $postedData = file_get_contents('php://input');
		    /// Traitement
			$postedData = json_decode($postedData, true);
			if(ifMDPUser($postedData["login"],$postedData["mdp"])==TRUE){
				$user=$postedData["login"];
				$role=getRole($user);
				$headers=array('alg'=>'HS256','typ'=>'JWT');
				$payload=array('login'=>$user,'role'=>$role,'exp'=>(time()+3600));
				$jwt = generate_jwt($headers, $payload, $secret = 'apiArticleTeoArthurREST');
                /// Envoi de la réponse au Client
		        deliver_response(200,"Connexion Réussi",$jwt);
			} else {
				$jwt = "Mauvais Login ou Mdp";
                /// Envoi de la réponse au Client
		        deliver_response(200, "Problème Connexion", $jwt);
			}
	    break;
        // Cas par défaut, erreur
		default:
			/// Envoi de la réponse au Client
			deliver_response(200, "Veuillez vous authentifié et envoyé au serveur les données",NULL);
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
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
?>
