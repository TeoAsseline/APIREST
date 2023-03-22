<?php
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
	/// Librairies éventuelles (pour la connexion à la BDD, etc.)
    require_once('../DAO/functionSERVER.php');
	require_once('../DAO/functionUser.php');
	require_once('../Fonction/jwt_utils.php');
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
			$bearer_token='';
			$matchingData=0;
		    $postedData = file_get_contents('php://input');
			$postedData = json_decode($postedData, true);
			$bearer_token=get_bearer_token();
		    /// Traitement
			if(is_jwt_valid($bearer_token,$secret = 'apiArticleTeoArthurREST') && isset($postedData['pseudo'])){
				$role=getRoleToken($bearer_token);
				$pseudo=$postedData['pseudo'];
				if($role==2){
					if(isset($postedData['id_art']) && isset($postedData['like'])){
						$id_art=$postedData['id_art'];
						$like=$postedData['like'];
						$matchingData=LikeArticlePublisher($pseudo,$id_art,$like);
						/// Envoi de la réponse au Client
						deliver_response(200, "La requête de like/dislike a bien été effectué", $matchingData);
					} else if(isset($postedData['contenu']) && isset($postedData['titre'])){
						$contenu=$postedData['contenu'];
						$titre=$postedData['titre'];
						$matchingData=insertArticlePublisher($pseudo,$contenu,$titre);
						/// Envoi de la réponse au Client
						deliver_response(200, "La requête d'insertion d'article a bien été effectué", $matchingData);
					} else {
						/// Envoi de la réponse au Client
						deliver_response(200, "ERREUR, aucune insertion ou like", $matchingData);
					}
				} else {
					/// Envoi de la réponse au Client
					deliver_response(200, "Vous n\'avez pas le rôle PUBLISHER", $matchingData);
				}
			} else {
				/// Envoi de la réponse au Client
				deliver_response(200, "Votre Token n\'est pas valide", $matchingData);
			}
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
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
?>
