<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Uploade de mes fichiers perso.">
  <title>Upload Move</title>

  <link rel="stylesheet" href="css/styles.css">
  <link rel="shortcut icon" href="#">

</head>

<body>
  <nav class="nav-bar">
    <a class="nav-icon" href="../index.php"><img src="pictures/log-out.png" alt="Retourer à l'acceuil"></img></a></img>
    <a class="nav-icon" href="index.php"><img src="pictures/upload.png" alt="Téléversement de fichier"></img></a></img>
    <a class="nav-icon" href="http://localhost/phpMyAdmin/index.php"><img src="pictures/security.png" alt="Upload Sécurisé"></img></a></img>
  </nav>

  <h1>Utilitaire de transfert de fichier et de texte sécurisé.</h1>

  <?php 
    if(isset($_GET["success"])){
      echo('  
      <div class="box-send success">
        <h2>Envoie effectué avec succès.<h2>
      </div>');
    }elseif(isset($_GET["failed"])){
      echo('  
      <div class="box-send failed">
        <h2>Une erreur est survenue lors de l\'envoi.<h2>
      </div>');
    }
  ?>

  <div class="wrapper">
    <div class="one">
      <h2>Transfert de texte/lien :</h2>
      <form action="/upload/upload.php" method="POST" id="text">
        <div>
          <textarea class="text-form" name="text" form="text" maxlength="1300" required></textarea>
        </div>
          <input class="btn-send" type="submit" value="Envoyer ce texte">
      </form>
    </div>

    <div class="two">
      <div class="content-box">
        <div class="file-form">
          <h2>Upload de fichier :</h2>
          <h3>Type de fichier :</h3>
          <form action="/upload/upload.php" enctype="multipart/form-data" method="POST">
            <input type="checkbox" id="zip" name="zip" value="zip">
            <label for="zip">.zip</label>
            <input type="checkbox" id="audio" name="audio" value="audio">
            <label for="audio">Audio</label>
            <input type="checkbox" id="video" name="video" value="video">
            <label for="video">Vidéo</label>
            <input type="checkbox" id="dossier" name="image" value="image">
            <label for="image">Image</label>
            
            <h3 class="no-marge">Emplacement de sauvegarde :</h3>
            <p class="sub-p">"upload\files_uploaded\votre chemin"</p>
            <input class="input-emplacement-design" type="text" id="emplacement" placeholder="par défaut dans \files_uploaded" name="emplacement"><br>

            <h3>Sélectionner le fichier :</h3>
            <input type="file" name="file" required>

        </div>
      </div>
          <input class="btn-send" enctype="multipart/form-data"type="submit" value="Envoyer le fichier">
        </form>
    </div>
  </div>

  <h2>Texte Transférer :</h2>
  <div class="text-box">
    <?php initTextBdd();?> 
  </div>
</body>
</html>

<?php
  function initTextBdd(){
    try
    {
      $bdd = new PDO('mysql:host=localhost;dbname=upload_move;charset=utf8', 'root', 'root');
    }
    catch(Exception $e)
    {
      die('Erreur : '.$e->getMessage());
    }

    $text_bdd = $bdd->query('SELECT * FROM text_uploaded ORDER BY id DESC LIMIT 16');

    while ($main_text = $text_bdd->fetch()){

      if(filter_var($main_text["text_up"], FILTER_VALIDATE_URL))
      {
        echo '<ul class="format-text">'. $main_text["date"] .' | <a href="' . $main_text["text_up"] .'" target="_blank">' . $main_text["text_up"] . "</a></ul>";
      }else{
        echo'<ul class="format-text">'. $main_text["date"] . " | " . $main_text["text_up"] . "</ul>";
      }
    }
  }
?>