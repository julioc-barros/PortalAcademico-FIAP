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

$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
$host = $_SERVER['HTTP_HOST'];

// $_SERVER['SCRIPT_NAME'] será /public/index.php
// dirname(dirname()) nos dará a raiz real (/)
$basePath = dirname(dirname($_SERVER['SCRIPT_NAME']));

// Normaliza barras
$basePath = str_replace('\\', '/', $basePath);

// Se $basePath for '/', rtrim o remove, ficando só o host
$baseUrl = rtrim("$protocol://$host" . $basePath, '/');

// Define a constante global
define('APP_URL', $baseUrl); // Resultado: http://localhost

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