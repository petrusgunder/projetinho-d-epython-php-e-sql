<?php
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);

    $servidor = "localhost";
    $usuario  = "root";
    $senha    = "";
    $banco    = "projeto1";


    try{

        $conexao = mysqli_connect($servidor,$usuario, $senha,$banco);

        $select = "SELECT `email` FROM `Usuario`;";

        $resultado = $conexao->query($select);

        $usuarios_ja_cadastrados = $resultado->fetch_all(MYSQLI_ASSOC);

        $email_no_bd = array_column($usuarios_ja_cadastrados, 'email');

        try{
            if (!file_exists("dados.json")) {
                throw new Exception("Arquivo não encontrado");
            }
            $texto = file_get_contents("dados.json");

            $usuario_adicionado = json_decode($texto,true);


            foreach ($usuario_adicionado as $usuario) {
                $nome  =$usuario["nome"];
                $email =$usuario["email"];
                $idade =$usuario["idade"];

                if (in_array($email,$email_no_bd)) {
                    echo "o email ". $email . " ja esta sendo usado por outro usuario!";
                } else {
                    $sql = "INSERT INTO Usuario (nome, email, idade) VALUES ('$nome', '$email', '$idade')";
                    mysqli_query($conexao,$sql);
                    echo "usuario cadastrado";
                }
            }
        } catch (Exception $e) {
            echo "arquivo json nao encontrado";
        }
        
    } catch (mysqli_sql_exception $e) {
        echo "porblema na hora de acessar o banco";
    }
?>