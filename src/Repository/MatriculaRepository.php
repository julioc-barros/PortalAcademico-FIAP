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

}