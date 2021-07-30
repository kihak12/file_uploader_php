<?php 

    if(isset($_POST["text"])){

        try
        {
            $bdd = new PDO('mysql:host=localhost;dbname=upload_move;charset=utf8', 'root', 'root');
        }
        catch(Exception $e)
        {
            die('Erreur : '.$e->getMessage());
        }

        $text_enter = htmlspecialchars($_POST["text"]);

        $req = $bdd->prepare('INSERT INTO text_uploaded(text_up) VALUES(:text_enter)');
        $req->execute(array(
          'text_enter' => $text_enter
        ));
        header("location: index.php?success");

    }elseif (!empty($_FILES['file'])){///Upload de fichiers

        $path = "files_uploaded/" . $_POST["emplacement"] . "/";
        echo(checkDir($path));
        $path = $path . basename( $_FILES['file']['name']);


        if(move_uploaded_file($_FILES['file']['tmp_name'], $path)) {
            header("location: index.php?success");
        } else{
            header("location: index.php?failed");
        }
    }else{
        header("location: index.php?failed");
    }

    function checkDir($dir){
        if(file_exists($dir))
            $result = 1;
        else
            createDir($dir);
    }

    function createDir($dir){
        $dir = "./" . $dir;
        echo($dir);
        mkdir($dir, 0777, true);
    }
?>
