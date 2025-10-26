<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\AlunoRepository;
use PortalAcademicoFIAP\Service\AuditLogger;
use PortalAcademicoFIAP\Service\Auth;
use PortalAcademicoFIAP\Service\ValidatorService;

class AlunoController
{
   private AlunoRepository $repository;

   public function __construct()
   {
      $this->repository = new AlunoRepository();
   }

   // Exige a listagem dos alunos 
   public function index()
   {
      $alunos = $this->repository->buscarTodosAtivos();
      view('aluno.list', ['alunos' => $alunos]);
   }

   /**
    * Exibe o formulário de cadastro de novo aluno (GET /alunos/novo)
    */
   public function create()
   {
      $csrfToken = Auth::generateCsrfToken();
      view('aluno.form', ['csrfToken' => $csrfToken]);
   }

   /**
    * Salva o novo aluno no banco (POST /alunos/salvar)
    */
   public function store()
   {
      $dados = $_POST;

      // Validar Token CSRF
      Auth::validateCsrfToken($dados['csrf_token']);

      // Validar Regras de Negócio 
      $erros = ValidatorService::validarNovoAluno($dados);

      if (!empty($erros)) {
         echo "Erros: " . implode(', ', $erros);
         exit;
      }

      // Salvar no Repositório
      if ($this->repository->salvar($dados)) {
         AuditLogger::log(Auth::id(), "Cadastrou o novo aluno: {$dados['nome']}");
         redirect('/alunos?sucesso=1');
      } else {
         redirect('/alunos/novo?erro=1');
      }
   }

   /**
    * Exibe o formulário de edição de um aluno (GET /alunos/editar)
    */
   public function edit()
   {
      // Pegar o ID da URL (Query String)
      $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
      if ($id === false || $id === null) {
         redirect('/alunos?erro=id_invalido');
         exit;
      }

      // Buscar o aluno no repositório
      $aluno = $this->repository->findById($id);

      // Se o aluno não existir, redireciona
      if ($aluno === null) {
         redirect('/alunos?erro=aluno_nao_encontrado');
         exit;
      }

      $csrfToken = Auth::generateCsrfToken();
      view('aluno.form', [
         'aluno' => $aluno,
         'csrfToken' => $csrfToken
      ]);
   }

   /**
    * Atualiza um aluno existente no banco (POST /alunos/atualizar)
    */
   public function update()
   {
      $dados = $_POST;

      // 1. Validar Token CSRF (Melhoria 9)
      Auth::validateCsrfToken($dados['csrf_token']);

      // 2. Validar Regras de Negócio (a nova função de update)
      $erros = ValidatorService::validarUpdateAluno($dados);

      if (!empty($erros)) {
         echo "Erros: " . implode(', ', $erros);
         exit;
      }

      if ($this->repository->atualizar($dados)) {
         AuditLogger::log(Auth::id(), "Atualizou dados do aluno ID: {$dados['id']}");
         redirect(route('alunos.index', ['sucesso' => 'atualizado']));
      } else {
         redirect(route('alunos.edit', ['id' => $dados['id'], 'erro' => 1]));
      }
   }

   /**
    * Exclui (soft delete) um aluno (POST /alunos/excluir)
    */
   public function delete()
   {
      $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
      $token = $_POST['csrf_token'] ?? null;

      // 1. Validar Token CSRF (Melhoria 9)
      Auth::validateCsrfToken($token);

      // 2. Validar se o ID é válido
      if ($id === false || $id === null) {
         redirect('/alunos?erro=id_invalido');
         exit;
      }

      if ($this->repository->deleteLogico($id)) {
         AuditLogger::log(Auth::id(), "Excluiu (soft delete) o aluno ID: {$id}");
         redirect('/alunos?sucesso=excluido');
      } else {
         redirect('/alunos?erro=excluir');
      }
   }

}