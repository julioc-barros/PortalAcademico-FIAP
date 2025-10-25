<?php

use PortalAcademicoFIAP\Controller\AdminController;
use PortalAcademicoFIAP\Controller\AuthController;
use PortalAcademicoFIAP\Service\Auth;

// 1. Obter a URI da requisição e o Método HTTP
$fullUri = $_SERVER['REQUEST_URI'];
$requestMethod = $_SERVER['REQUEST_METHOD'];

$requestUri = parse_url($fullUri, PHP_URL_PATH);

// Garante que a URI "raiz" (vazia ou /) seja tratada como "/"
if (empty($requestUri) || $requestUri === '/') {
   $requestUri = '/';
}

// 2. DEFINIÇÃO DAS ROTAS
$routes = [
   // Rota da Home (Dashboard)
   '/' => [
      'GET' => [AdminController::class, 'dashboard']
   ],
   // --- Autenticação (Bônus) ---
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

// 3. LÓGICA DO ROTEADOR (Atualizada com Proteção)

// Rotas públicas que NÃO exigem login
$publicRoutes = [
   '/login',
   '/login/auth'
];

// 1. Verificar se a URI existe
if (array_key_exists($requestUri, $routes)) {

   // 2. Verificar se o método HTTP é permitido
   if (array_key_exists($requestMethod, $routes[$requestUri])) {

      // Verifica se a rota NÃO é pública E se o usuário NÃO está logado
      if (!in_array($requestUri, $publicRoutes) && !Auth::check()) {
         // Não está logado e tenta acessar rota protegida.
         // Redireciona para o login.
         header('Location: /login');
         exit;
      }

      // Se está logado e tenta acessar /login, redireciona para o dashboard
      if (in_array($requestUri, $publicRoutes) && $requestUri !== '/login/auth' && Auth::check()) {
         header('Location: /');
         exit;
      }
      
      $handler = $routes[$requestUri][$requestMethod];
      $controllerName = $handler[0];
      $methodName = $handler[1];

      // 3. Verificar se a classe do controller existe
      if (class_exists($controllerName)) {
         $controller = new $controllerName();

         // 4. Verificar se o método existe
         if (method_exists($controller, $methodName)) {

            // 5. Chama o método do controller
            $controller->$methodName();

         } else {
            http_response_code(500); // Internal Server Error
            echo "Erro 500: Método '{$methodName}' não encontrado no controller '{$controllerName}'.";
         }
      } else {
         http_response_code(500); // Internal Server Error
         echo "Erro 500: Controller '{$controllerName}' não encontrado.";
      }

   } else {
      http_response_code(405); // Method Not Allowed
      echo "<h1>405 - Método Não Permitido</h1>";
      echo "O método {$requestMethod} não é suportado para esta rota.";
   }

} else {
   http_response_code(404); // Not Found
   echo "<h1>404 - Página Não Encontrada</h1>";
   echo "A rota '{$requestUri}' não foi definida.";
}