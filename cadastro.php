<?php
    ini_set("display_errors", 1);
    ini_set("display_startup_errors", 1);
    error_reporting(E_ALL);

    require_once 'vendor/autoload.php';
    
    use Fernet\Fernet;

    try {

        $servidor = "localhost";
        $usuario  = "root";
        $senha    = "";
        $banco    = "projeto1";

        $dns = "mysql:host=$servidor;dbname=$banco;charset=utf8mb4";

        $opcoes = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        $pdo = new PDO($dns, $usuario, $senha, $opcoes);

        $sql = "INSERT INTO Usuario (nome, email, idade) VALUES (:nome, :email, :idade)";
        $stmt = $pdo->prepare($sql);

        $caminho_json = '/opt/lampp/htdocs/projeto/dados_criptografados.json';

        if (file_exists($caminho_json)){

            $caminho_key = '/opt/lampp/htdocs/projeto/chave.key';

            if (file_exists($caminho_key)){

                $key = file_get_contents($caminho_key);
                $json_criptografado = file_get_contents($caminho_json);

                try {
                    
                    $fernet = new Fernet(trim($key));
                    $json = $fernet->decode($json_criptografado);

                    if (!empty($json)){
                        
                        $dados = json_decode($json, true);

                        if (is_array($dados)) {
                            
                            $pdo->beginTransaction();

                            foreach ($dados as $u) {
                                if (isset($u['nome'], $u['email'], $u['idade'])) {
                                    $stmt->execute([
                                        ':nome'  => $u['nome'],
                                        ':email' => $u['email'],
                                        ':idade' => (int)$u['idade']
                                    ]);
                                }
                            }

                            $pdo->commit();

                            echo "<h1>200</h1>
                                  <h2>Servidor conseguiu processar</h2>
                                  <p>O requerimento de descriptografização funcionou e os dados foram salvos.</p>";

                        } else {
                            echo "<h1>400</h1>
                                  <h2>Requisição Inválida</h2>
                                  <p>A estrutura do JSON não pôde ser convertida em uma lista válida.</p>";
                        }

                    } else {
                        echo "<h1>404</h1>
                              <h2>Arquivo não encontrado</h2>
                              <p>O arquivo 'dados_criptografados.json' está vazio ou a chave é inválida.</p>";
                    }

                } catch (Exception $e) {
                    echo "<h1>500</h1>
                          <h2>Servidor não conseguiu processar</h2>
                          <p>O requerimento de descriptografização não funcionou.</p>";
                }

            } else {
                echo "<h1>404</h1>
                      <h2>Arquivo não encontrado</h2>
                      <p>O arquivo 'chave.key' pode ter sido removido, teve seu nome alterado ou está temporariamente indisponível.</p>";
            }

        } else {
            echo "<h1>404</h1>
                  <h2>Arquivo não encontrado</h2>
                  <p>O arquivo 'dados_criptografados.json' pode ter sido removido, teve seu nome alterado ou está temporariamente indisponível.</p>";
        }

    } catch(PDOException $e){
        if (isset($pdo) && $pdo->inTransaction()) {
            $pdo->rollBack();
        }
        echo "Erro no banco de dados: " . $e->getMessage();
    }
?>