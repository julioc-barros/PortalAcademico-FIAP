<?php
namespace PortalAcademicoFIAP;

// Inicia a sessão em todas as requisições
if (session_status() === PHP_SESSION_NONE) {
   session_start();
}

/**
 * ---------------------------------------------------------------
 * CARREGAR O AUTOLOAD DO COMPOSER
 * ---------------------------------------------------------------
 * Isso carrega automaticamente todas as nossas classes (Controllers,
 * Models, Repositories, Services) usando o padrão PSR-4.
 */
require_once __DIR__ . '/../vendor/autoload.php';

/**
 * ---------------------------------------------------------------
 * CARREGAR CONFIGURAÇÕES
 * ---------------------------------------------------------------
 * Carrega as configurações de banco de dados e URL.
 */
$config = require_once __DIR__ . '/../config/config.php';

/**
 * ---------------------------------------------------------------
 * DEFINIR CONSTANTES GLOBAIS
 * ---------------------------------------------------------------
 */

// 1. Detecta o protocolo (HTTPS via proxy OU conexão direta)
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
   || (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')
   ? "https" : "http";

// 2. Define o host (pode usar X_FORWARDED_HOST se Nginx estiver configurado)
$host = $_SERVER['HTTP_X_FORWARDED_HOST'] ?? $_SERVER['HTTP_HOST'] ?? 'localhost';

// 3. Define o caminho base (para raiz do servidor)
$basePath = dirname(dirname($_SERVER['SCRIPT_NAME']));
$basePath = str_replace('\\', '/', $basePath);
// Remove a barra final se não for a raiz absoluta
$baseUrlPath = ($basePath === '/' || $basePath === '') ? '' : rtrim($basePath, '/');

// 4. Monta a URL Base completa
$baseUrl = "$protocol://$host" . $baseUrlPath;

// Define a constante global
define('APP_URL', $baseUrl); // Resultado: https://portalfiap.juliocbarros.tech

/**
 * ---------------------------------------------------------------
 * CARREGAR AS ROTAS
 * ---------------------------------------------------------------
 * Inclui o arquivo que vai analisar a URL e decidir
 * qual Controller e método executar.
 */
try {
   require_once __DIR__ . '/../src/routes.php';
} catch (\Exception $e) {
   http_response_code(500);
   if (function_exists('view')) {
      view('errors.500', ['errorMessage' => $e->getMessage()]);
   } else {
      echo "<h1>Erro 500 - Erro Interno do Servidor</h1>";
      if (defined('APP_ENV') && APP_ENV === 'development') {
         echo "<pre>" . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
      }
   }
}