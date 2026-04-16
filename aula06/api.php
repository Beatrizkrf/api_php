<?php

//CABEÇALHO
header("Content-Type: application/json"); // Define o tipo de resposta

$metodo= $_SERVER ['REQUEST_METHOD'];
// echo "Método da requisição: ". $metodo;

//CONTEÚDO - ta no arquivo usuario.json
// $usuarios = [
//     ["id" => 1, "nome" => "Adriano", "email" => "adriano@email.com"], 
//     ["id" => 2, "nome" => "Beatriz", "email" => "beatriz@email.com"]
// ];


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
            // echo " ações do Método Get";
             echo json_encode($usuarios);
        break; 
       
       
       
        case 'POST':
            // echo " ações do Método POST";
            $dados= json_decode(file_get_contents('php://input'), true);
            print_r($dados);

            $novoUsuario = [
                "id" => $dados ["id"],
                "nome" => $dados ["nome"],
                "email" => $dados ["email"]
            ];

            //adc o novo usuario ao array
            array_push($usuarios, $novoUsuario);
            echo json_encode ('Usuário inserido com sucesso!');
            print_r($usuarios);
        break;
        
        default:
            echo " Metodo não enconrtado";
            break;
    }

?>