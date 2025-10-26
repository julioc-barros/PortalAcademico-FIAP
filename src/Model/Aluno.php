<?php
namespace PortalAcademicoFIAP\Model;

/**
 * Entidade Aluno
 * Representa os dados da tabela 'alunos'.
 */
class Aluno
{
   public function __construct(
      public readonly ?int $id,
      public string $nome,
      public string $data_nascimento,
      public string $cpf,
      public string $email,
      public ?string $senha, // Nulo ao buscar, obrigatório ao criar
      public bool $d_e_l_e_t_ = false // Campo Soft delete
   ) {
   }

   public function validarNome(): bool
   {
      return mb_strlen(trim($this->nome)) >= 3;
   }

}