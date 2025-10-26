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
      $sql = "SELECT id, nome, data_nascimento, cpf, email, d_e_l_e_t_ FROM alunos WHERE d_e_l_e_t_ = false ORDER BY nome ASC;";
      $stmt = $this->pdo->query($sql);

      $alunos = [];
      while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $alunos[] = $this->hidratarAluno($dados);
      }
      return $alunos;
   }

   /**
    * Busca Contagem de todos os alunos ativos
    */
   public function ContarAtivos(): int
   {
      $sql = "SELECT count(1) FROM alunos WHERE d_e_l_e_t_ = false;";
      $stmt = $this->pdo->query($sql);
      $contagemAtivos = $stmt->fetchColumn(); // Função que busca apenas uma coluna

      return $contagemAtivos;
   }

   /**
    * Conta o número de alunos ativos que não estão matriculados em nenhuma turma.
    */
   public function ContarAlunosSemMatriculas(): int
   {
      $sql = "SELECT COUNT(a.id) 
                FROM alunos a
                LEFT JOIN matriculas m ON a.id = m.aluno_id
                WHERE a.d_e_l_e_t_ = false AND m.id IS NULL";

      $stmt = $this->pdo->query($sql);
      return (int) $stmt->fetchColumn();
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

   /**
    * Busca um aluno ativo pelo seu ID.
    */
   public function findById(int $id): ?Aluno
   {
      $sql = "SELECT * FROM alunos WHERE id = ? AND d_e_l_e_t_ = false";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$id]);

      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      return $dados ? $this->hidratarAluno($dados) : null;
   }

   /**
    * Busca um aluno ativo pelo CPF.
    */
   public function findByCpf(string $cpf): ?Aluno
   {
      $sql = "SELECT * FROM alunos WHERE cpf = ? AND d_e_l_e_t_ = false";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$cpf]);
      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      return $dados ? $this->hidratarAluno($dados) : null;
   }

   /**
    * Busca um aluno ativo pelo E-mail.
    */
   public function findByEmail(string $email): ?Aluno
   {
      $sql = "SELECT * FROM alunos WHERE email = ? AND d_e_l_e_t_ = false";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$email]);
      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      return $dados ? $this->hidratarAluno($dados) : null;
   }

   /**
    * Salva um novo aluno no banco de dados.
    */
   public function salvar(array $dados): bool
   {
      $hashSenha = password_hash($dados['senha'], PASSWORD_BCRYPT);

      $sql = "INSERT INTO alunos (nome, data_nascimento, cpf, email, senha) 
                VALUES (?, ?, ?, ?, ?)";

      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute([
            trim($dados['nome']),
            $dados['data_nascimento'],
            trim($dados['cpf']),
            trim($dados['email']),
            $hashSenha
         ]);
      } catch (\PDOException $e) {
         return false;
      }
   }

   /**
    * Atualiza os dados de um aluno no banco.
    */
   public function atualizar(array $dados): bool
   {
      // Query base (sem a senha)
      $sql = "UPDATE alunos SET 
                    nome = ?, 
                    data_nascimento = ?, 
                    cpf = ?, 
                    email = ? 
                WHERE id = ?";

      $params = [
         trim($dados['nome']),
         $dados['data_nascimento'],
         trim($dados['cpf']),
         trim($dados['email']),
         $dados['id']
      ];

      // Se uma nova senha foi fornecida, adiciona ela na query
      if (!empty($dados['senha'])) {
         $hashSenha = password_hash($dados['senha'], PASSWORD_BCRYPT);

         $sql = "UPDATE alunos SET 
                        nome = ?, 
                        data_nascimento = ?, 
                        cpf = ?, 
                        email = ?, 
                        senha = ? 
                    WHERE id = ?";

         // Recria os parâmetros com a senha
         $params = [
            trim($dados['nome']),
            $dados['data_nascimento'],
            trim($dados['cpf']),
            trim($dados['email']),
            $hashSenha,
            $dados['id']
         ];
      }

      // Executa a query (com ou sem a senha)
      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute($params);
      } catch (\PDOException $e) {
         // (O ideal é logar o $e->getMessage())
         return false;
      }
   }

   /**
    * Realiza um "soft delete" do aluno, marcando d_e_l_e_t_ = true.
    */
   public function deleteLogico(int $id): bool
   {
      // Antes de excluir, verificamos se o aluno pode ser excluído
      // (ex: se ele tem matrículas ativas).
      // No nosso dump.sql, a 'CONSTRAINT fk_matriculas_alunos'
      // está com 'ON DELETE RESTRICT', o que impediria um DELETE físico.
      // Como é um UPDATE, a restrição não se aplica, o que é bom.

      $sql = "UPDATE alunos SET d_e_l_e_t_ = true WHERE id = ?";

      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute([$id]);
      } catch (\PDOException $e) {
         return false;
      }
   }

   /**
    * Busca todos os alunos matriculados em uma turma específica.
    * @return Aluno[]
    */
   public function buscarAlunosPorTurmaId(int $turma_id): array
   {
      $sql = "SELECT a.* FROM alunos a
               JOIN matriculas m ON (a.id = m.aluno_id)
               WHERE 1=1
               AND m.turma_id = ? 
               AND a.d_e_l_e_t_ = false
               ORDER BY a.nome ASC";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$turma_id]);

      $alunos = [];
      while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $alunos[] = $this->hidratarAluno($dados);
      }
      return $alunos;
   }

}