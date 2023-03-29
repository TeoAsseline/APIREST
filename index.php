<?php
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
session_start();
require_once("./DAO/functionUser.php");
require_once("./Fonction/functionCLIENT.php");
require_once("./Fonction/jwt_utils.php");
// echo "</br>-----------------------<br/>";
// echo insertUser("Teo","\$iutinfo","1");
// echo insertUser("Arthur","\$iutinfo","1");
// echo insertUser("Nicolas","jadoreleschats","2");
// echo insertUser("Elena","jadoreleschevaux","2");
// echo insertUser("Fantin","jadorelesjeux","2");
// echo "</br>-----------------------</br>";
if(isset($_SESSION['token'])){
    $token=$_SESSION['token'];
} else {
    $token="";
}
if (isset($_POST['connexion'])) {
    if (isset($_POST['login']) && isset($_POST['mdp'])) {
        $user = htmlentities($_POST['login']);
        $mdp= htmlentities($_POST['mdp']);
        CONNEXION($user,$mdp);
    }
} 
// print_r(GETArticleTOKEN($token['data']));
// echo "</br>-----------------------</br>";
// print_r(GETArticle());
// echo "</br>-----------------------</br>";
// print_r(GETMyArticle("Nicolas",$token));
// echo "</br>-----------------------</br>";
// print_r(INSERTLikeDislike($token,6,1));
// echo "</br>-----------------------</br>";
// print_r(INSERTArticle($token,"La vie, la vie c\'est le theâtre","LIFE"));
// echo "</br>-----------------------</br>";
// print_r(MODIFArticle($token,"La vie, la vie c\'est le theâtre et moi","LIFE",13));
// echo "</br>-----------------------</br>";
// print_r(DELETEArticle(13,$token));
// echo "</br>-----------------------</br>";
//----------------------------------------------------------------------//
//**********************************************************************//
//----------------------------------------------------------------------//
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=""/>
    <link rel="icon" href=""/>
    <title>API REST</title>
</head>
<body>
<main>
    <form style='padding:0.8em;margin:0.4em;border:solid 2px;' method="post">
        <label>Login</label>
        <input type='text' id='login' name='login' required/>
        <label>Mdp</label>
        <input type='password' id='mdp' name='mdp' required/>
        <input type='submit' name="connexion" value='Connexion'/>
        <span><?php echo "Token : ".$token;?></span>
    </form>
    <form style='padding:0.8em;margin:0.4em;border:solid 2px;'>
    <label>ID</label>
    <input type='number' id='id' name='id'/>
    <input type='submit' value='Rechercher'/>
    </form>
    <table style='border:solid 2px;width:99%;padding:0.8em;margin:0.4em;'>
    <thead style='padding:0.8em;margin:0.4em;'>
        <tr>
            <th>ID</th>
            <th>Contenu</th>
            <th>Titre</th>
            <th>Date</th>
            <th>Auteur</th>
            <th>Like</th>
            <th>Dislike</th>
            <th>Liste Like</th>
            <th>Liste Dislike</th>
            <th>Modifier</th>
            <th>Supprimer</th>
        </tr>
    </thead>
    <tbody style='padding:0.8em;margin:0.4em;text-align:center;'>
    <?php
        if(isset($_GET['id'])){
            $id=$_GET['id'];
        } else {
            $id=null;
        }
        if($token!=""){
            $articles = GETArticleTOKEN($token,$id);
        } else {
            $articles = GETArticle($id);
        }
        foreach($articles['data'] as $article):?>
            <tr style='padding:0.8em;'>
                <td><?php echo$article['id_art']; ?></td>
                <td><?php echo$article['contenu']; ?></td>
                <td><?php echo$article['nom_publication']; ?></td>
                <td><?php echo$article['date_publication']; ?></td>
                <td><?php echo getPseudoByID($article['auteur']);?></td>
                <?php if($token!=""):?>
                <td><?php echo$article['nbLike']; ?></td>
                <td><?php echo$article['nbDislike']; ?></td>
                <?php else: ?>
                <td></td>
                <td></td>
                <?php endif; ?>
                <?php if($token!=""):?>
                <?php if( getRoleToken($token)==1):?>
                <td><?php if($article['ListLike']==0){
                    echo "Aucun";
                } else {
                foreach($article['ListLike'] as $auteur){
                    echo $auteur["pseudo"]." | ";
                }} ?></td>
                <td><?php if($article['ListDislike']==0){
                    echo "Aucun";
                } else {foreach($article['ListDislike'] as $auteur){
                    echo $auteur["pseudo"]." | ";
                }} ?></td>
                <?php else: ?>
                <td></td>
                <td></td>
                <?php endif; ?>
                <?php else: ?>
                <td></td>
                <td></td>
                <?php endif; ?>
                <td><a href=''>Modifier</a></td>
                <td><a href=''>Supprimer</a></td>
            </tr>
        <?php endforeach;?>
    </tbody>
    </table>
</main>
</body>
</html>