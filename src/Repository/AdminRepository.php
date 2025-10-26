<?php
namespace PortalAcademicoFIAP\Repository;

use PortalAcademicoFIAP\Model\Administrador;
use PortalAcademicoFIAP\Service\Auth;
use PortalAcademicoFIAP\Service\Database;
use PDO;

class AdminRepository
{
   private PDO $pdo;

   public function __construct()
   {
      $this->pdo = Database::getConexao();
   }

   /**
    * Busca um administrador ativo pelo e-mail.
    * Retorna um objeto Administrador ou null se não encontrar.
    */
   public function findByEmail(string $email): ?Administrador
   {
      $sql = "SELECT * FROM administradores WHERE email = ? AND d_e_l_e_t_ = false";

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$email]);

      $dados = $stmt->fetch(PDO::FETCH_ASSOC);

      if (!$dados) {
         // Usuário não encontrado
         return null;
      }

      // "Hidrata" o Model com os dados do banco
      return new Administrador(
         id: $dados['id'],
         nome: $dados['nome'],
         email: $dados['email'],
         senha: $dados['senha'], // Retorna o HASH da senha
         is_super_admin: (bool) $dados['is_super_admin'],
         d_e_l_e_t_: (bool) $dados['d_e_l_e_t_']
      );
   }

   /**
    * Busca todos os administradores ativos.
    */
   public function findAllActive(): array
   {
      $sql = "SELECT * FROM administradores WHERE d_e_l_e_t_ = false ORDER BY nome ASC";
      $stmt = $this->pdo->query($sql);

      $admins = [];
      while ($dados = $stmt->fetch(PDO::FETCH_ASSOC)) {
         $admins[] = $this->hidratarAdmin($dados);
      }
      return $admins;
   }

   /**
    * Busca um administrador ativo pelo ID.
    */
   public function findById(int $id): ?Administrador
   {
      $sql = "SELECT * FROM administradores WHERE id = ? AND d_e_l_e_t_ = false";
      $stmt = $this->pdo->prepare($sql);
      $stmt->execute([$id]);
      $dados = $stmt->fetch(PDO::FETCH_ASSOC);
      return $dados ? $this->hidratarAdmin($dados) : null;
   }

   /**
    * Salva um novo administrador.
    */
   public function saveAdmin(array $dados): bool
   {
      $hashSenha = password_hash($dados['senha'], PASSWORD_BCRYPT);
      $sql = "INSERT INTO administradores (nome, email, senha, is_super_admin) VALUES (?, ?, ?, ?)";
      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute([
            trim($dados['nome']),
            trim($dados['email']),
            $hashSenha,
            (int) $dados['is_super_admin'] // Converte para inteiro (0 ou 1)
         ]);
      } catch (\PDOException $e) {
         return false;
      }
   }

   /**
    * Atualiza um administrador.
    */
   public function updateAdmin(array $dados): bool
   {
      $sqlBase = "UPDATE administradores SET nome = ?, email = ?, is_super_admin = ?";
      $params = [
         trim($dados['nome']),
         trim($dados['email']),
         (int) $dados['is_super_admin']
      ];

      // Atualiza senha apenas se fornecida
      if (!empty($dados['senha'])) {
         $hashSenha = password_hash($dados['senha'], PASSWORD_BCRYPT);
         $sqlBase .= ", senha = ?";
         $params[] = $hashSenha;
      }

      $sql = $sqlBase . " WHERE id = ?";
      $params[] = $dados['id'];

      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute($params);
      } catch (\PDOException $e) {
         return false;
      }
   }

   /**
    * Realiza soft delete de um administrador.
    * Impede a auto-exclusão.
    */
   public function deleteLogicoAdmin(int $idToDelete): bool
   {
      // Impede que o usuário logado se delete
      if (Auth::id() === $idToDelete) {
         return false; // Ou lançar uma exceção específica
      }

      $sql = "UPDATE administradores SET d_e_l_e_t_ = true WHERE id = ?";
      try {
         $stmt = $this->pdo->prepare($sql);
         return $stmt->execute([$idToDelete]);
      } catch (\PDOException $e) {
         return false;
      }
   }

   /**
    * Helper para hidratar o model Administrador.
    */
   private function hidratarAdmin(array $dados): Administrador
   {
      return new Administrador(
         id: $dados['id'],
         nome: $dados['nome'],
         email: $dados['email'],
         senha: $dados['senha'], // Retorna o hash
         is_super_admin: (bool) $dados['is_super_admin'],
         d_e_l_e_t_: (bool) $dados['d_e_l_e_t_']
      );
   }
}