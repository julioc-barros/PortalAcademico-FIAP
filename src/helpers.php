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
 * Gera uma URL completa a partir de um nome de rota.
 *
 * Ex: route('alunos.edit', ['id' => 5])
 * Retorna: http://localhost/alunos/editar?id=5
 *
 * @param string $name O nome da rota (definido em config/named_routes.php)
 * @param array $params Parâmetros GET a serem adicionados à URL
 * @return string A URL absoluta completa
 */
if (!function_exists('route')) {
   function route(string $name, array $params = []): string
   {
      // 1. Carrega o mapa de rotas (apenas uma vez)
      static $routeMap = null;
      if ($routeMap === null) {
         // dirname(__DIR__) é a raiz do projeto (/PortalAcademicoFIAP)
         $routeMap = require_once dirname(__DIR__) . '/config/named_routes.php';
      }

      // 2. Verifica se o nome existe
      if (!isset($routeMap[$name])) {
         // Lança um erro se a rota nomeada não for encontrada
         throw new \Exception("Rota nomeada '{$name}' não definida em config/named_routes.php");
      }

      // 3. Pega o path (ex: /alunos/editar)
      $url = $routeMap[$name];

      // 4. Adiciona os parâmetros como query string (ex: ?id=5)
      if (!empty($params)) {
         $url .= '?' . http_build_query($params);
      }

      // 5. Retorna a URL absoluta (ex: http://localhost/alunos/editar?id=5)
      return APP_URL . $url;
   }
}

/**
 * Redireciona para uma URL.
 * Agora aceita um nome de rota ou um path.
 *
 * Ex 1: redirect(route('alunos.index'))
 * Ex 2: redirect('/caminho/manual')
 */
if (!function_exists('redirect')) {
   function redirect(string $url)
   {
      header('Location: ' . $url);
      exit;
   }
}