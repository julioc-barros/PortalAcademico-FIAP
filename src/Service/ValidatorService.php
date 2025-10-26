<?php
namespace PortalAcademicoFIAP\Service;

use PortalAcademicoFIAP\Repository\AlunoRepository;

class ValidatorService
{
   /**
    * Valida os dados de cadastro de um novo aluno.
    * Retorna um array de erros. Se o array estiver vazio, está válido.
    */
   public static function validarNovoAluno(array $dados): array
   {
      $erros = [];
      $repo = new AlunoRepository();

      // RN03: Validar campos obrigatórios
      $camposObrigatorios = ['nome', 'data_nascimento', 'cpf', 'email', 'senha', 'senha_confirma'];
      foreach ($camposObrigatorios as $campo) {
         if (empty(trim($dados[$campo]))) {
            $erros[] = "O campo '{$campo}' é obrigatório.";
         }
      }

      // Se já há erros de campos vazios, não adianta continuar
      if (!empty($erros))
         return $erros;

      // RN02: Validar tamanho do nome
      if (mb_strlen(trim($dados['nome'])) < 3) {
         $erros[] = "O nome deve ter no mínimo 3 caracteres.";
      }

      // RN05: Validar CPF ou e-mail únicos
      if ($repo->findByCpf(trim($dados['cpf']))) {
         $erros[] = "Este CPF já está cadastrado.";
      }
      if ($repo->findByEmail(trim($dados['email']))) {
         $erros[] = "Este e-mail já está cadastrado.";
      }

      // RN03: Validar e-mail
      if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
         $erros[] = "O e-mail informado não é válido.";
      }

      // RN07: Validar senha forte
      $senha = $dados['senha'];
      if (
         strlen($senha) < 8 ||
         !preg_match('/[A-Z]/', $senha) || // Maiúscula
         !preg_match('/[a-z]/', $senha) || // Minúscula
         !preg_match('/[0-9]/', $senha) || // Número
         !preg_match('/[\W_]/', $senha)
      ) {
         $erros[] = "A senha não atende aos requisitos: mínimo 8 caracteres, com maiúsculas, minúsculas, números e símbolos.";
      }

      // RN03: Validar confirmação de senha
      if ($senha !== $dados['senha_confirma']) {
         $erros[] = "As senhas não conferem.";
      }

      return $erros;
   }

   /**
    * Valida os dados de ATUALIZAÇÃO de um aluno.
    * Retorna um array de erros.
    */
   public static function validarUpdateAluno(array $dados): array
   {
      $erros = [];
      $repo = new AlunoRepository();

      // RN03: Validar campos obrigatórios (ID é crucial)
      $camposObrigatorios = ['id', 'nome', 'data_nascimento', 'cpf', 'email'];
      foreach ($camposObrigatorios as $campo) {
         if (empty(trim($dados[$campo]))) {
            $erros[] = "O campo '{$campo}' é obrigatório.";
         }
      }
      if (!empty($erros))
         return $erros; // Não continuar se campos básicos faltarem

      // RN02: Validar tamanho do nome
      if (mb_strlen(trim($dados['nome'])) < 3) {
         $erros[] = "O nome deve ter no mínimo 3 caracteres.";
      }

      // RN05: Validar CPF único (ignorando o ID do próprio aluno)
      $alunoComCPF = $repo->findByCpf(trim($dados['cpf']));
      if ($alunoComCPF && $alunoComCPF->id != $dados['id']) {
         $erros[] = "Este CPF já está cadastrado por outro aluno.";
      }

      // RN05: Validar E-mail único (ignorando o ID do próprio aluno)
      $alunoComEmail = $repo->findByEmail(trim($dados['email']));
      if ($alunoComEmail && $alunoComEmail->id != $dados['id']) {
         $erros[] = "Este e-mail já está cadastrado por outro aluno.";
      }

      // RN03: Validar e-mail
      if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
         $erros[] = "O e-mail informado não é válido.";
      }

      // RN07 e RN08: Validar senha (APENAS SE UMA NOVA FOI DIGITADA)
      if (!empty($dados['senha'])) {
         $senha = $dados['senha'];
         if (
            strlen($senha) < 8 ||
            !preg_match('/[A-Z]/', $senha) ||
            !preg_match('/[a-z]/', $senha) ||
            !preg_match('/[0-9]/', $senha) ||
            !preg_match('/[\W_]/', $senha)
         ) {

            $erros[] = "A nova senha não atende aos requisitos: mínimo 8 caracteres, com maiúsculas, minúsculas, números e símbolos.";
         }

         // RN03: Validar confirmação de senha
         if ($senha !== $dados['senha_confirma']) {
            $erros[] = "As novas senhas não conferem.";
         }
      }

      return $erros;
   }
}