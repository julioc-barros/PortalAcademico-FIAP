<?php
namespace PortalAcademicoFIAP\Service;

use PortalAcademicoFIAP\Service\Database;
use PortalAcademicoFIAP\Service\Auth;
use PDO;

class AuditLogger
{
   /**
    * Registra uma ação no log do administrador.
    */
   public static function log(?int $admin_id, string $acao): void
   {
      try {
         // Se o ID não for fornecido, tenta pegar da sessão
         $id = $admin_id ?? Auth::id();

         // Se mesmo assim não houver ID (ex: falha de login antes da sessão ser criada), podemos logar com ID nulo ou decidir não logar.
         // Por segurança, vamos logar com ID nulo (ou um ID "sistema", ex: 0)
         if ($id === null) {
            // Em uma falha de login, $admin_id será nulo e Auth::id() também.
            // Vamos apenas logar a ação sem um ID de admin.
            // NOTA: Nossa tabela 'logs_admin' exige um admin_id.
            // Vamos ajustar o log para pegar o IP em falhas de login.

            // Vamos simplificar: O Auth::login só chama o log DEPOIS do sucesso.
            // Então o Auth::id() NUNCA será nulo.
            // O Auth::login falho não precisa ser logado aqui,
            // pois já temos o rate limit.

            if ($id === null) {
               // Se por algum motivo o ID ainda é nulo, não loga.
               return;
            }
         }

         $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

         $pdo = Database::getConexao();
         $sql = "INSERT INTO logs_admin (admin_id, acao, ip_address, timestamp) 
                    VALUES (?, ?, ?, NOW())";

         $stmt = $pdo->prepare($sql);
         $stmt->execute([$id, $acao, $ip]);

      } catch (\Exception $e) {
         // Se o log falhar, não queremos quebrar a aplicação principal.
         // Em produção, isso seria logado em um arquivo de texto.
         if (APP_ENV === 'development') {
            error_log("Falha ao registrar no AuditLogger: " . $e->getMessage());
         }
      }
   }
}