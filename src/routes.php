<?php

use PortalAcademicoFIAP\Controller\AdminController;
use PortalAcademicoFIAP\Controller\AuthController;
use PortalAcademicoFIAP\Controller\AlunoController;
use PortalAcademicoFIAP\Service\Auth;

$fullUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Remove a query string (ex: ?id=1)
$requestUri = parse_url($fullUri, PHP_URL_PATH);

// Garante que a URI "raiz" (vazia ou /) seja tratada como "/"
if (empty($requestUri) || $requestUri === '/') {
   $requestUri = '/';
}

// DEFINIÇÃO DE TODAS AS ROTAS DO PROJETO
$routes = [

   // Pagina Principal
   '/' => [
      'GET' => [AdminController::class, 'dashboard']
   ],

   // Rotas login 
   '/login' => [
      'GET' => [AuthController::class, 'index']
   ],
   '/login/auth' => [
      'POST' => [AuthController::class, 'auth']
   ],
   '/logout' => [
      'GET' => [AuthController::class, 'logout']
   ],


];

// Rotas públicas que NÃO exigem login
$publicRoutes = [
   '/login',
   '/login/auth'
];

if (array_key_exists($requestUri, $routes)) {
   if (array_key_exists($requestMethod, $routes[$requestUri])) {

      // Caso nao esteja logado e nao seja uma rota pública
      if (!in_array($requestUri, $publicRoutes) && !Auth::check()) {
         header('Location: ' . APP_URL . '/login');
         exit;
      }

      // Redireciona quando for acessar uma rota publica e está logado para "/"
      if (in_array($requestUri, $publicRoutes) && $requestUri !== '/login/auth' && Auth::check()) {
         header('Location: ' . APP_URL . '/');
         exit;
      }

      $handler = $routes[$requestUri][$requestMethod];
      $controllerName = $handler[0];
      $methodName = $handler[1];

      if (class_exists($controllerName)) {
         $controller = new $controllerName();

         if (method_exists($controller, $methodName)) {
            $controller->$methodName();
         } else {
            http_response_code(500);
            echo "Erro 500: Método '{$methodName}' não encontrado no controller '{$controllerName}'.";
         }

      } else {
         http_response_code(500);
         echo "Erro 500: Controller '{$controllerName}' não encontrado.";
      }

   } else {
      http_response_code(405);
      echo "<h1>405 - Método Não Permitido</h1>";
   }

} else {
   http_response_code(404);
   echo "<h1>404 - Página Não Encontrada</h1>";
   echo "A rota '{$requestUri}' não foi definida.";

}