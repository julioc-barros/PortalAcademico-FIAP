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
define('APP_URL', $config['app_url']);

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
   echo "Erro na aplicação: " . $e->getMessage();
}