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
	$bearer_token="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJsb2dpbiI6InBhc2RldG9rZW4iLCJleHAiOjE2Nzk1NTk4MzR9.s8li3QV62KJR7WKkujofVAM771NdiKRFwWb_mIludRE";

    switch ($http_method){
    	/// Cas de la méthode GET
    	case "GET" :
		    /// Récupération des données envoyées par le Client
			$matchingData=0;
			if(get_bearer_token()!=null){
				$bearer_token=get_bearer_token();
			}
		    /// Traitement token
			if(is_jwt_valid($bearer_token,$secret = 'apiArticleTeoArthurREST')){
				$role=getRoleToken($bearer_token);
				//role Admin
				if($role==1){
					if(isset($_GET["id"])){
						$id=$_GET["id"];
						$matchingData=getArticleAdmin($id);
						/// Envoi de la réponse au Client
						deliver_response(200, "récupération de l\'article en Admin...", $matchingData);
					} else {
						$matchingData=getArticleAdmin();
						/// Envoi de la réponse au Client
						deliver_response(200, "récupération des articles en Admin...", $matchingData);
					}
					//role Publisher
				} else if($role==2){
					if(isset($_GET["pseudo"])){
						$pseudo=$_GET["pseudo"];
						if(getPseudoToken($bearer_token)==$pseudo){
							$matchingData=getMyArticlePublisher($pseudo);
							/// Envoi de la réponse au Client
							deliver_response(200, "récupération de vos articles", $matchingData);
						} else {
							/// Envoi de la réponse au Client
							deliver_response(403,"Ce ne sont pas vos articles ", $matchingData);
						}
					} else if(isset($_GET["id"])){
						$id=$_GET["id"];
						$matchingData=getArticlePublisher($id);
						/// Envoi de la réponse au Client
						deliver_response(200, "récupération de l\'article du publisher", $matchingData);
					} else {
						$matchingData=getArticlePublisher();
						/// Envoi de la réponse au Client
						deliver_response(200, "récupération des articles des publisher", $matchingData);
					}
				} else{
					/// Envoi de la réponse au Client
					deliver_response(403, "Vous n\'avez pas le rôle nécéssaire à votre demande", $matchingData);
				}
			} else {
				if(isset($_GET["id"])){
					$id=$_GET["id"];
					$matchingData=getArticleNAuth($id);
					/// Envoi de la réponse au Client
					deliver_response(200, "récupération de l\'article effectués", $matchingData);
				} else {
					$matchingData=getArticleNAuth();
					/// Envoi de la réponse au Client
					deliver_response(200, "récupération des articles effectués", $matchingData);
				}
			}
	    break;
    	/// Cas de la méthode POST
	    case "POST" :
		    /// Récupération des données envoyées par le Client
			$matchingData=0;
		    $postedData = file_get_contents('php://input');
			$postedData = json_decode($postedData,true);
			if(get_bearer_token()!=null){
				$bearer_token=get_bearer_token();
			}
		    /// Traitement token
			if(is_jwt_valid($bearer_token,$secret = 'apiArticleTeoArthurREST')){
				$role=getRoleToken($bearer_token);
				$pseudo=getPseudoToken($bearer_token);
				//role Publisher
				if($role==2){
					if(isset($postedData['id_art']) && isset($postedData['like'])){
						$id_art=$postedData['id_art'];
						$like=$postedData['like'];
						$matchingData=LikeArticlePublisher($pseudo,$id_art,$like);
						/// Envoi de la réponse au Client
						deliver_response(200, "La requête de like/dislike a bien été effectué", $matchingData);
					} else if(isset($postedData['contenu']) && isset($postedData['titre'])){
						$contenu=htmlspecialchars($postedData['contenu']);
						$titre=htmlspecialchars($postedData['titre']);
						$matchingData=insertArticlePublisher($pseudo,$contenu,$titre);
						/// Envoi de la réponse au Client
						deliver_response(200, "La requête d\'insertion d\'article a bien été effectué", $matchingData);
					} else {
						/// Envoi de la réponse au Client
						deliver_response(400, "ERREUR, aucune insertion ou like", $matchingData);
					}
				} else {
					/// Envoi de la réponse au Client
					deliver_response(403, "Vous n\'avez pas le rôle PUBLISHER", $matchingData);
				}
			} else {
				/// Envoi de la réponse au Client
				deliver_response(401, "Votre Token n\'est pas valide", $matchingData);
			}
	    break;
    	/// Cas de la méthode PATCH
	    case "PUT" :
		    /// Récupération des données envoyées par le Client
		    ///Mise en place fonction
			$matchingData=0;
		    $postedData = file_get_contents('php://input');
			$postedData = json_decode($postedData, true);
			if(get_bearer_token()!=null){
				$bearer_token=get_bearer_token();
			}
		    /// Traitement token
			if(is_jwt_valid($bearer_token,$secret = 'apiArticleTeoArthurREST')){
				$role=getRoleToken($bearer_token);
				$pseudo=getPseudoToken($bearer_token);
				//role Publisher
				if($role==2){
					if(isset($postedData['contenu']) && isset($postedData['titre']) && isset($postedData['id_art'])){
						$contenu=htmlspecialchars($postedData['contenu']);
						$titre=htmlspecialchars($postedData['titre']);
						$id=$postedData['id_art'];
						$matchingData=updateArticlePublisher($id,$contenu,$titre,$pseudo);
						/// Envoi de la réponse au Client
						deliver_response(200, "La requête de modification d\'article a bien été effectué", $matchingData);
					} else {
						/// Envoi de la réponse au Client
						deliver_response(400, "ERREUR, aucun titre, id article ou contenu", $matchingData);
					}
				} else {
					/// Envoi de la réponse au Client
					deliver_response(403, "Vous n\'avez pas le rôle PUBLISHER", $matchingData);
				}
			} else {
				/// Envoi de la réponse au Client
				deliver_response(401, "Votre Token n\'est pas valide", $matchingData);
			}
	    break;
    	/// Cas de la méthode DELETE
	    case "DELETE" :
		    /// Récupération de l'identifiant de la ressource envoyé par le Client
		    /// Récupération des données envoyées par le Client
			$matchingData=0;
			if(get_bearer_token()!=null){
				$bearer_token=get_bearer_token();
			}
		    /// Traitement token
			if(is_jwt_valid($bearer_token,$secret = 'apiArticleTeoArthurREST') && isset($_GET['id'])){
				$role=getRoleToken($bearer_token);
				$id=$_GET['id'];
				//role Admin
				if($role==1){
					$matchingData=deleteArticleAdmin($id);
					/// Envoi de la réponse au Client
					deliver_response(200,"La requête de suppression d\'article a bien été effectué", $matchingData);
					//role Publisher
				} else if($role==2){
					$pseudo=getPseudoToken($bearer_token);
					$matchingData=deleteArticlePublisher($id,$pseudo);
					/// Envoi de la réponse au Client
					deliver_response(200,"La requête de suppression de votre article a bien été effectué",$matchingData);
				} else{
					/// Envoi de la réponse au Client
					deliver_response(403, "Vous n\'avez pas le rôle nécéssaire à votre demande", $matchingData);
				}
			} else {
				/// Envoi de la réponse au Client
				deliver_response(401, "Votre Token n\'est pas valide ou aucun id", $matchingData);
			}
	    break;
		default:
			/// Envoi de la réponse au Client
			deliver_response(404, "La ressource ciblée n\'existe pas", $matchingData);
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
