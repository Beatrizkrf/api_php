<?php

//CABEÇALHO
header("Content-Type: application/json"); // Define o tipo de resposta

$metodo= $_SERVER ['REQUEST_METHOD'];
// echo "Método da requisição: ". $metodo;



//recupera o arquivo json na pasta do projeto
$arquivo = 'usuarios.json';

//verifica se ele existe, se não aparece azio
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, json_encode([], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}

//le o conteúdo do arquivo json
$usuarios = json_decode(file_get_contents($arquivo), true);

// Converte para JSON e retorna
// echo json_encode($usuarios);

    switch ($metodo) {
        case 'GET':
            // converte para json 
             echo json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        break; 
       
       
       
        case 'POST':
            // le os dados 
            $dados= json_decode(file_get_contents('php://input'), true);

            //verifica se os campos obrigatorios foram preenchidos 
            if(!isset($dados["id"]) || !isset ($dados ["email"])){
                http_response_code (400);
                echo json_encode (["erro" => "Dados Incompletos."], JSON_UNESCAPED_UNICODE);
                exit;
            }

            $novoUsuario = [
                "id" => $dados ["id"],
                "nome" => $dados ["nome"],
                "email" => $dados ["email"]
            ];

            //array dos novos usuarios
            $usuarios[] = $novoUsuario;
            file_put_contents ($arquivo, json_encode($usuarios, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) );

            echo json_encode(["mensagem" => "Usuario inserido com sucesso!", "usuarios" => $usuarios], JSON_UNESCAPED_UNICODE);

            //adc o novo usuario ao array
            // array_push($usuarios, $novoUsuario);
            // echo json_encode ('Usuário inserido com sucesso!');
            // print_r($usuarios);
        break;
        
        default:
           http_response_code(405); 
           echo json_encode(["erro" => "Método não permitido!"], JSON_UNESCAPED_UNICODE);
            break;
    }

?>