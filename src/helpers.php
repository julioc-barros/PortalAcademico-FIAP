<?php

/**
 * Renderiza uma view completa (Padronizando igual um framework faria). 
 *
 * Ex: view('aluno.list', ['alunos' => $alunos, 'csrfToken' => '...']);
 *
 */
if (!function_exists('view')) {
   function view(string $viewName, array $data = [])
   {
      // Torna as chaves do array $data em variáveis
      extract($data, EXTR_SKIP);

      // Define o caminho base para as views
      $baseViewPath = __DIR__ . '/View/';

      // Função interna para lidar com erros
      $render_error = function (string $message) {
         http_response_code(500);
         echo "Erro 500 (View Helper): " . htmlspecialchars($message);
         exit;
      };

      // Carrega o Conteúdo Principal
      // Converte 'aluno.list' em 'aluno/list.php'
      $contentPath = $baseViewPath . str_replace('.', '/', $viewName) . '.php';
      if (file_exists($contentPath)) {
         require $contentPath;
      } else {
         $render_error("View '{$viewName}' não encontrada em '{$contentPath}'.");
      }

   }
}

/**
 * Redireciona para uma rota do app usando a APP_URL.
 *
 * Ex: redirect('/login?error=1');
 *
 * @param string $path O caminho da rota (ex: '/alunos')
 */
if (!function_exists('redirect')) {
   function redirect(string $path)
   {
      // APP_URL é a constante global definida em public/index.php
      header('Location: ' . APP_URL . $path);
      exit;
   }
}