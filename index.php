<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Slim\Exception\HttpNotFoundException;
use GabrielSilva\Tarefas\Service\TarefaService;

require __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
// middleware é um evento que ocorre antes da requisição chegar na rota.
$errorMiddleware = $app->addErrorMiddleware(true, true, true); 
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "Recurso não foi encontrado"}');
    return $response->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
});


$app->get('/tarefas', function (Request $request, Response $response, array $args){
    $tarefa_service = new TarefaService();
    $tarefas = $tarefa_service->getAllTarefas();
    $response->getBody()->write(json_encode($tarefas));
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/tarefas', function(Request $request, Response $response, array $args){
    $parametros = (array) $request->getParsedBody();
    if(!array_key_exists('titulo', $parametros) ||  empty($parametros['titulo'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "título é obrigatório"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    $tarefa = array_merge(['titulo' => '', 'concluido' => false], $parametros);
    $tarefa_service = new TarefaService();
    $tarefa_service->createTarefa($tarefa);

   return $response->withStatus(201);
});

$app->delete('/tarefas/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
    $tarefa_services = new TarefaService();
    $tarefa_services->deleteTarefa($id);
   return $response->withStatus(204);
});

$app->put('/tarefas/{id}', function(Request $request, Response $response, array $args){
    $id = $args['id'];
    $dados_para_atualizar = json_decode($request->getBody()->getContents(), true);
    if(array_key_exists('titulo', $dados_para_atualizar) && empty($dados_para_atualizar['titulo'])){
        $response->getBody()->write(json_encode([
            "mensagem" => "título é obrigatório"
        ]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
    }
    $tarefa_service = new TarefaService();
    $tarefa_service->updateTarefa($id,$dados_para_atualizar);
    
    return $response->withStatus(201);
 });

$app->run();






/*
$errorMiddleware = $app->addErrorMiddleware(true, true, true);
$errorMiddleware->setErrorHandler(HttpNotFoundException::class, function (
    Request $request,
    Throwable $exception,
    bool $displayErrorDetails,
    bool $logErrors,
    bool $logErrorDetails
) use ($app) {
    $response = $app->getResponseFactory()->createResponse();
    $response->getBody()->write('{"error": "Resource not found"}');
    return $response->withHeader('Content-Type', 'application/json')
                    ->withStatus(404);
});

$app->post('/items', function (Request $request, Response $response, $args) {
    $data = $request->getParsedBody();

    // Verificando campos obrigatórios
    if (empty($data['name'])) {
        $error = [
            'error' => 'Campos obrigatórios não informados: name são necessários'
        ];
        $response->getBody()->write(json_encode($error));
        return $response->withHeader('Content-Type', 'application/json')
                        ->withStatus(400); // Retorna status 400 (Bad Request)
    }

    $newItem = [
        'id' => $data['id'],
        'name' => $data['name'],
    ];
    $response->getBody()->write(json_encode($newItem));
    return $response->withHeader('Content-Type', 'application/json')
                    ->withStatus(201); // Retorna status 201 (Created)
});

*/