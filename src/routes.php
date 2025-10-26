<?php

use PortalAcademicoFIAP\Controller\AdminController;
use PortalAcademicoFIAP\Controller\AuthController;
use PortalAcademicoFIAP\Controller\AlunoController;
use PortalAcademicoFIAP\Controller\TurmaController;
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

   // CRUD Alunos 
   '/alunos' => [
      'GET' => [AlunoController::class, 'index'] // Listagem 
   ],
   '/alunos/novo' => [
      'GET' => [AlunoController::class, 'create'] // Formulário de cadastro 
   ],
   '/alunos/salvar' => [
      'POST' => [AlunoController::class, 'store'] // Salvar novo 
   ],
   '/alunos/editar' => [
      'GET' => [AlunoController::class, 'edit'] // Formulário de edição 
   ],
   '/alunos/atualizar' => [
      'POST' => [AlunoController::class, 'update'] // Atualizar existente 
   ],
   '/alunos/excluir' => [
      'POST' => [AlunoController::class, 'delete'] // Excluir (Soft-delete) 
   ],
   '/alunos/matriculas' => [
      'GET' => [AlunoController::class, 'manipularMatriculas'] // Exibir tela
   ],
   '/alunos/matricular' => [
      'POST' => [AlunoController::class, 'matriculaAluno'] // Processar matrícula
   ],
   '/alunos/desmatricular' => [
      'POST' => [AlunoController::class, 'desmatriculaAluno'] // Processar desmatrícula
   ],

   // CRUD Turmas
   '/turmas' => [
      'GET' => [TurmaController::class, 'index'] // Listagem
   ],
   '/turmas/novo' => [
      'GET' => [TurmaController::class, 'create'] // Formulário de cadastro 
   ],
   '/turmas/salvar' => [
      'POST' => [TurmaController::class, 'store'] // Salvar nova 
   ],
   '/turmas/editar' => [
      'GET' => [TurmaController::class, 'edit'] // Formulário de edição 
   ],
   '/turmas/atualizar' => [
      'POST' => [TurmaController::class, 'update'] // Atualizar existente 
   ],
   '/turmas/excluir' => [
      'POST' => [TurmaController::class, 'delete'] // Excluir (Soft-delete) 
   ],
   '/turmas/visualizar' => [
      'GET' => [TurmaController::class, 'show'] // Ver alunos da turma 
   ],

   // CRUD Usuarios (Apenas para SUPER ADMIN)
   '/admin/usuarios' => [
      'GET' => [AdminController::class, 'indexUsers'] // Listagem
   ],
   '/admin/usuarios/novo' => [
      'GET' => [AdminController::class, 'createUser'] // Formulário de cadastro
   ],
   '/admin/usuarios/salvar' => [
      'POST' => [AdminController::class, 'storeUser'] // Salvar novo
   ],
   '/admin/usuarios/editar' => [
      'GET' => [AdminController::class, 'editUser'] // Formulário de edição
   ],
   '/admin/usuarios/atualizar' => [
      'POST' => [AdminController::class, 'updateUser'] // Atualizar existente
   ],
   '/admin/usuarios/excluir' => [
      'POST' => [AdminController::class, 'deleteUser'] // Excluir (Soft-delete)
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
            http_response_code(500); // Internal Server Error
            $errorMessage = "Método '{$methodName}' não encontrado no controller '{$controllerName}'.";
            view('errors.500', ['errorMessage' => $errorMessage]); // Chama a view 500
         }
      } else {
         http_response_code(500); // Internal Server Error
         $errorMessage = "Controller '{$controllerName}' não encontrado.";
         view('errors.500', ['errorMessage' => $errorMessage]); // Chama a view 500
      }

   } else {
      http_response_code(405); // Method Not Allowed
      view('errors.404'); // Simplesmente mostra 404 para método não permitido
   }

} else {
   http_response_code(404); // Not Found
   view('errors.404'); // Chama a view 404
}