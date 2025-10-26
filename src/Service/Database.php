<?php
namespace PortalAcademicoFIAP\Service;

use PDO;
use PDOException;

class Database
{
   /**
    * @var PDO|null A única instância da conexão PDO
    */
   private static ?PDO $instance = null;

   /**
    * O construtor é privado para impedir a criação de instâncias com 'new Database()'.
    */
   private function __construct()
   {
   }

   /**
    * O método clone é privado para impedir a clonagem da instância.
    */
   private function __clone()
   {
   }

   /**
    * Método estático que obtém a conexão com o banco de dados. Se a conexão ainda não existir, ela é criada.
    */
   public static function getConexao(): PDO
   {
      if (self::$instance === null) {
         // Carrega as configurações do banco de dados
         $config = require __DIR__ . '/../../config/config.php';

         $dbConfig = $config['database'];

         // Monta a DSN (Data Source Name)
         $dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['name']};port={$dbConfig['port']};charset={$dbConfig['charset']}";

         $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,             // Lança exceções em erros
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,        // Retorna arrays associativos por padrão
            PDO::ATTR_EMULATE_PREPARES => false,                     // Usa prepared statements nativos
         ];

         try {
            self::$instance = new PDO($dsn, $dbConfig['user'], $dbConfig['pass'], $options);
         } catch (PDOException $e) {
            // Em caso de falha na conexão, lança um erro.
            // Em produção (APP_ENV), isso seria logado em vez de exibido.
            throw new PDOException("Falha na conexão com o banco de dados: " . $e->getMessage(), (int) $e->getCode());
         }
      }

      return self::$instance;
   }
}