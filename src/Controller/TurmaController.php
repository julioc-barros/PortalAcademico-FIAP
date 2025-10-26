<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\AlunoRepository;
use PortalAcademicoFIAP\Repository\TurmaRepository;
use PortalAcademicoFIAP\Service\AuditLogger;
use PortalAcademicoFIAP\Service\Auth;
use PortalAcademicoFIAP\Service\ValidatorService;

class TurmaController
{
   private TurmaRepository $repository;

   public function __construct()
   {
      $this->repository = new TurmaRepository();
   }

   /**
    * Exibe a listagem de turmas
    */
   public function index()
   {
      $turmas = $this->repository->buscarTodasAtivasComContagem();
      view('turma.list', [
         'turmas' => $turmas
      ]);
   }

   /**
    * Formulário de Cadastro
    */
   public function create()
   {
      $csrfToken = Auth::generateCsrfToken();
      view('turma.form', ['csrfToken' => $csrfToken]);
   }

   /**
    * Salvar Nova Turma
    */
   public function store()
   {
      $dados = $_POST;
      Auth::validateCsrfToken($dados['csrf_token']);

      $erros = ValidatorService::validarNovaTurma($dados);
      if (!empty($erros)) {
         echo "Erros: " . implode(', ', $erros);
         exit;
      }

      if ($this->repository->salvar($dados)) {
         AuditLogger::log(Auth::id(), "Cadastrou a nova turma: {$dados['nome']}");
         redirect('/turmas?sucesso=1');
      } else {
         redirect('/turmas/novo?erro=1');
      }
   }

   /**
    * Formulário de Edição
    */
   public function edit()
   {
      $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
      if (!$id) {
         redirect('/turmas?erro=id_invalido');
      }

      $turma = $this->repository->findById($id);
      if ($turma === null) {
         redirect('/turmas?erro=turma_nao_encontrada');
      }

      $csrfToken = Auth::generateCsrfToken();
      view('turma.form', [
         'turma' => $turma,
         'csrfToken' => $csrfToken
      ]);
   }

   /**
    * Atualizar Turma
    */
   public function update()
   {
      $dados = $_POST;
      Auth::validateCsrfToken($dados['csrf_token']);

      $erros = ValidatorService::validarUpdateTurma($dados);
      if (!empty($erros)) {
         echo "Erros: " . implode(', ', $erros);
         exit;
      }

      if ($this->repository->atualizar($dados)) {
         AuditLogger::log(Auth::id(), "Atualizou dados da turma ID: {$dados['id']}");
         redirect('/turmas?sucesso=atualizado');
      } else {
         redirect('/turmas/editar?id=' . $dados['id'] . '&erro=1');
      }
   }

   /**
    * Excluir Turma
    */
   public function delete()
   {
      $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
      $token = $_POST['csrf_token'] ?? null;
      Auth::validateCsrfToken($token);

      if (!$id) {
         redirect('/turmas?erro=id_invalido');
      }

      if ($this->repository->deleteLogico($id)) {
         AuditLogger::log(Auth::id(), "Excluiu (soft delete) a turma ID: {$id}");
         redirect('/turmas?sucesso=excluido');
      } else {
         redirect('/turmas?erro=excluir_falhou');
      }
   }

   /**
    * Visualizar Alunos da Turma
    */
   public function show()
   {
      $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
      if (!$id) {
         redirect('/turmas?erro=id_invalido');
      }

      $turma = $this->repository->findById($id);
      if ($turma === null) {
         redirect('/turmas?erro=turma_nao_encontrada');
      }

      // Busca os alunos (usando o AlunoRepository)
      $alunoRepo = new AlunoRepository();
      $alunos = $alunoRepo->buscarAlunosPorTurmaId($id);

      view('turma.show', [
         'turma' => $turma,
         'alunos' => $alunos
      ]);
   }

}