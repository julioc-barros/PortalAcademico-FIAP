<?php
namespace PortalAcademicoFIAP\Repository;

use PortalAcademicoFIAP\Model\Turma;
use PortalAcademicoFIAP\Service\Database;
use PDO;

class TurmaRepository
{
   private PDO $pdo;

   public function __construct()
   {
      $this->pdo = Database::getConexao();
   }

   /**
    * Busca todas as turmas ativas com a contagem de alunos.
    * @return Turma[]
    */
   public function buscarTodasAtivasComContagem(): array
   {
      $sql = "SELECT   
                  tur.id, 
                  tur.nome, 
                  tur.descricao, 
                  tur.d_e_l_e_t_,
                  COUNT(mat.aluno_id) as total_alunos
               FROM turmas tur
               LEFT JOIN matriculas mat ON ( tur.id = mat.turma_id )
               WHERE 1=1
               AND tur.d_e_l_e_t_ = false
               GROUP BY 
                  tur.id, tur.nome, tur.descricao, tur.d_e_l_e_t_
               ORDER BY 
                  tur.nome ASC";

      $stmt = $this->pdo->query($sql);

      $turmas = [];
      while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $turmas[] = $this->hidratarTurma($dados);
      }
      return $turmas;
   }

   /**
    * Função helper para converter um array do banco em um objeto Turma.
    */
   private function hidratarTurma(array $dados): Turma
   {
      return new Turma(
         id: $dados['id'],
         nome: $dados['nome'],
         descricao: $dados['descricao'],
         d_e_l_e_t_: (bool) $dados['d_e_l_e_t_'],
         total_alunos: (int) $dados['total_alunos']
      );
   }

   /**
    * Busca uma turma ativa pelo NOME (para validação).
    */
   public function findByNome(string $nome): ?Turma
   {
      $sql = "SELECT * FROM turmas WHERE nome = ? AND d_e_l_e_t_ = false";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$nome]);
      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      return $dados ? new Turma($dados['id'], $dados['nome'], $dados['descricao']) : null;
   }

   /**
    * Busca uma turma ativa pelo ID (para edição/visualização).
    */
   public function findById(int $id): ?Turma
   {
      $sql = "SELECT * FROM turmas WHERE id = ? AND d_e_l_e_t_ = false";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$id]);
      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      return $dados ? new Turma($dados['id'], $dados['nome'], $dados['descricao']) : null;
   }

   /**
    * Salva uma nova turma no banco de dados.
    */
   public function salvar(array $dados): bool
   {
      $sql = "INSERT INTO turmas (nome, descricao) VALUES (?, ?)";
      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute([
            trim($dados['nome']),
            trim($dados['descricao'])
         ]);
      } catch (\PDOException $e) {
         return false;
      }
   }

   /**
    * Atualiza os dados de uma turma no banco.
    */
   public function atualizar(array $dados): bool
   {
      $sql = "UPDATE turmas SET nome = ?, descricao = ? WHERE id = ?";
      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute([
            trim($dados['nome']),
            trim($dados['descricao']),
            $dados['id']
         ]);
      } catch (\PDOException $e) {
         return false;
      }
   }

   /**
    * Realiza um "soft delete" da turma.
    */
   public function deleteLogico(int $id): bool
   {
      // Precisamos verificar se a turma tem alunos
      // O dump.sql (ON DELETE RESTRICT) nos protege de um DELETE físico,
      // mas não de um UPDATE (soft delete).
      // Vamos verificar se há matrículas.
      $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM matriculas WHERE turma_id = ?");
      $stmt->execute([$id]);
      $totalMatriculas = $stmt->fetchColumn(); // Função que busca apenas uma coluna

      if ($totalMatriculas > 0) {
         // Não permite excluir (logicamente) uma turma com alunos.
         // O admin deve primeiro remover as matrículas.
         return false;
      }

      $sql = "UPDATE turmas SET d_e_l_e_t_ = true WHERE id = ?";
      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute([$id]);
      } catch (\PDOException $e) {
         return false;
      }
   }
}