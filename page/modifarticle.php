<?php
require_once("../DAO/functionUser.php");
require_once("../Fonction/functionCLIENT.php");
if(isset($_SESSION['token'])){
    $token=$_SESSION['token'];
} else {
    $token="Aucun Token";
}
if (isset($_POST['modifier']) && (!empty($_POST['modifier']))) {
    if (isset($_POST['titre']) && (!empty($_POST['titre'])) && isset($_POST['id']) && (!empty($_POST['id']))) {
        $id = htmlentities($_POST['id']);
        $titre = htmlentities($_POST['titre']);
        $contenu = htmlentities($_POST['contenu']);
        MODIFArticle($token,$contenu,$titre,$id);
        ?><script>window.location.href = "../index.php";</script><?php
    }
}
?>
<!DOCTYPE HTML>
<html>
	<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
	<title>Modifier Article</title>
    <style>
        input,select{
            padding:0.4em;
            margin:0.4em;
        }
    </style>
	</head>
	<body>
        <header></header>
        <main>
            <h2>Modification d'un article</h2>
            <form style='border:solid 2px;padding:0.8em;margin:0.4em;' action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <label>ID</label>
                <input type='text' name='id' style='width:80px;' value="<?php echo $_GET['id']; ?>" readonly></br>
                <label>Titre</label> 
                <input type='text' name='titre' style='width:500px;' value="<?php echo $_GET['titre']; ?>"></br>
                <label>Contenu</label> 
                <input type='text' name='contenu' style='width:500px;' value="<?php echo $_GET['contenu']; ?>"></br>
                <input type='submit' name='modifier' value='Modifier'></br>
            </form> 
            <a href="../index.php"  style='padding:0.2em;border:solid 2px;'>Retour</a>
        </main>
        <footer></footer>
    </body>
</html>