<?php
namespace PortalAcademicoFIAP\Model;

/**
 * Entidade Turma
 * Representa os dados da tabela 'turmas'.
 */
class Turma
{
   public function __construct(
      public readonly ?int $id,
      public string $nome,
      public ?string $descricao,
      public bool $d_e_l_e_t_ = false,
      public readonly ?int $total_alunos = null
   ) {
   }
}