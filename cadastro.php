<?php
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);

    require_once 'vendor/autoload.php';
    
    use Fernet\Fernet;

    $servidor = "localhost";
    $usuario  = "root";
    $senha    = "";
    $banco    = "projeto1";


    $conexao = mysqli_connect($servidor,$usuario, $senha,$banco);


    $caminho_json = '/opt/lampp/htdocs/projeto/dados_criptografados.json';

    if (file_exists($caminho_json)){

        $caminho_key = '/opt/lampp/htdocs/projeto/chave.key';

        if (file_exists($caminho_key)){

            $key = file_get_contents($caminho_key);

            $json_criptografado = file_get_contents($caminho_json);

            try{
                $fernet = new Fernet(trim($key));
                $json = $fernet->decode($json_criptografado);

                if ($json != null){
                    echo"<h1>200</h1>
                         <h2>Servidor conseguiu processar</h2>
                         <p>O requerimento de descriptografizaçao funcionou.</p>
                        ";
                }else{
                    echo"<h1>404</h1>
                         <h2>Arquivo não encontrada</h2>
                         <p>O arquivo 'dados_criptografados.json' esta vazio.</p>
                        ";
                };
            }catch (Exception $e) {
                echo"<h1>500</h1>
                 <h2>Servidor não conseguiu processar</h2>
                 <p>O requerimento de descriptografizaçao nao funcionou.</p>
                ";
            };

        }else{
            echo"<h1>404</h1>
                 <h2>Arquivo não encontrada</h2>
                 <p>O arquivo 'chave.key' pode ter sido removida, teve seu nome alterado ou está temporariamente indisponível.</p>
                ";
        }

    } else{
        echo"<h1>404</h1>
             <h2>Arquivo não encontrada</h2>
             <p>O arquivo 'dados_criptografados.json' pode ter sido removida, teve seu nome alterado ou está temporariamente indisponível.</p>
            ";
    }
?>