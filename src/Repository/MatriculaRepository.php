<?php
namespace PortalAcademicoFIAP\Repository;

use PortalAcademicoFIAP\Service\Database;
use PDO;
use PDOException;

class MatriculaRepository
{
   private PDO $pdo;

   public function __construct()
   {
      $this->pdo = Database::getConexao();
   }

   /**
    * Realiza a matrícula de um aluno em uma turma.
    */
   public function matricular(int $aluno_id, int $turma_id): bool|string
   {
      $sql = "INSERT INTO matriculas (aluno_id, turma_id) VALUES (?, ?)";

      try {
         $stmt = $this->pdo->prepare($sql);
         $stmt->execute([$aluno_id, $turma_id]);
         return true;

      } catch (PDOException $e) {
         // Verifica se o erro é de Chave Duplicada (UNIQUE constraint)
         // O código '23000' é o SQLSTATE para violação de integridade.
         if ($e->getCode() == '23000') {
            return "Este aluno já está matriculado nesta turma.";
         }

         return "Erro de banco: " . $e->getMessage();
      }
   }

   /**
    * Remove a matrícula de um aluno em uma turma específica.
    */
   public function desmatricular(int $aluno_id, int $turma_id): bool
   {
      $sql = "DELETE FROM matriculas WHERE aluno_id = ? AND turma_id = ?";

      try {
         $stmt = $this->pdo->prepare($sql);
         // execute() retorna true/false, mas rowCount() confirma se algo foi apagado
         $stmt->execute([$aluno_id, $turma_id]);
         return $stmt->rowCount() > 0; // Retorna true se 1 linha foi afetada

      } catch (PDOException $e) {
         return false;
      }
   }

   /**
    * Conta o número total de matrículas existentes.
    */
   public function contarTotal(): int
   {
      $stmt = $this->pdo->query("SELECT COUNT(*) FROM matriculas");
      return (int) $stmt->fetchColumn();
   }

}