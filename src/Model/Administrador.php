<?php
namespace PortalAcademicoFIAP\Model;

/**
 * Classe que representa a entidade Administrador.
 */
class Administrador
{
   public function __construct(
      public readonly ?int $id,
      public string $nome,
      public string $email,
      public readonly string $senha, // A senha é 'readonly' pois só a lemos do DB
      public bool $is_super_admin, // Campo que vai definir acesso a pagina de cadastro de novos usuarios do portal
      public bool $d_e_l_e_t_ = false // Campo Soft Delete
   ) {
   }
}