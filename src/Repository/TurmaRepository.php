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
}