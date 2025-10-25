<?php
namespace PortalAcademicoFIAP\Repository;

use PortalAcademicoFIAP\Model\Aluno;
use PortalAcademicoFIAP\Service\Database;
use PDO;

class AlunoRepository
{
   private PDO $pdo;

   public function __construct()
   {
      $this->pdo = Database::getConexao();
   }

   /**
    * Busca todos os alunos ativos, ordenados por nome. Já retorna em ordem alfabética.
    */
   public function buscarTodosAtivos(): array
   {
      $sql = "SELECT id, nome, data_nascimento, cpf, email, d_e_l_e_t_ FROM alunos WHERE d_e_l_e_t_ = false ORDER BY nome ASC";
      $stmt = $this->pdo->query($sql);

      $alunos = [];
      while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $alunos[] = $this->hidratarAluno($dados);
      }
      return $alunos;
   }

   /**
    * Função helper para converter um array do banco em um objeto Aluno.
    */
   private function hidratarAluno(array $dados): Aluno
   {
      return new Aluno(
         id: $dados['id'],
         nome: $dados['nome'],
         data_nascimento: $dados['data_nascimento'],
         cpf: $dados['cpf'],
         email: $dados['email'],
         senha: null, // Não trazemos a senha do banco desnecessariamente
         d_e_l_e_t_: (bool) $dados['d_e_l_e_t_']
      );
   }
}