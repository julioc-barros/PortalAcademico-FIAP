<?php

// Define o fuso horário padrão (importante para datas e logs)
date_default_timezone_set('America/Sao_Paulo');

/**
 * ---------------------------------------------------------------
 * CONFIGURAÇÃO DO AMBIENTE
 * ---------------------------------------------------------------
 * Defina o ambiente da sua aplicação.
 * 'development': Mostra todos os erros.
 * 'production': Esconde os erros.
 */
define('APP_ENV', 'development'); // Mude para 'production' no servidor real


/**
 * ---------------------------------------------------------------
 * CONFIGURAÇÃO DE RELATÓRIO DE ERROS
 * ---------------------------------------------------------------
 * Com base no APP_ENV, decidimos como os erros são tratados.
 */
if (APP_ENV === 'development') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
}

/**
 * ---------------------------------------------------------------
 * CONFIGURAÇÕES DA APLICAÇÃO
 * ---------------------------------------------------------------
 */
$config = [
    /**
     * Configuração do Banco de Dados
     */
    'database' => [
        'host' => '127.0.0.1',             // ou 'localhost'
        'port' => 3306,                    // Porta do banco de dados
        'name' => 'portal_academico_fiap', // O nome que definimos no dump.sql
        'user' => 'root',                  // Usuário padrão do MySQL
        'pass' => '',                      // Senha do seu MySQL
        'charset' => 'utf8mb4'
    ],

    /**
     * URL Base da Aplicação
     * (Não coloque a barra "/" no final)
     */
    'app_url' => (APP_ENV === 'development')
        ? 'http://localhost'
        : 'https://localhost'
];

/**
 * ---------------------------------------------------------------
 * CONFIGURAÇÕES DE BANCO DE DADOS PARA PRODUÇÃO
 * ---------------------------------------------------------------
 * Se estiver em produção, sobrescreve a configuração de 'database'.
 */
if (APP_ENV === 'production') {
    $config['database'] = [
        'host' => 'servidor_de_producao.com',
        'port' => 3306,
        'name' => 'portal_prod_fiap',
        'user' => 'usuario_prod',
        'pass' => 'senha_forte_de_producao',
        'charset' => 'utf8mb4'
    ];
}

// Retorna a configuração final
return $config;