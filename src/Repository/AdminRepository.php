<?php
namespace PortalAcademicoFIAP\Repository;

use PortalAcademicoFIAP\Model\Administrador;
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
}