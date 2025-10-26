<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\MatriculaRepository;
use PortalAcademicoFIAP\Repository\AlunoRepository;
use PortalAcademicoFIAP\Repository\TurmaRepository;
use PortalAcademicoFIAP\Service\Auth;
use PortalAcademicoFIAP\Service\AuditLogger;

class MatriculaController
{
   private MatriculaRepository $matriculaRepo;

   public function __construct()
   {
      $this->matriculaRepo = new MatriculaRepository();
   }

   /**
    * Exibe o formulário de matrícula (GET /matriculas)
    * Carrega os alunos e turmas para os dropdowns.
    */
   public function index()
   {
      $alunoRepo = new AlunoRepository();
      $turmaRepo = new TurmaRepository();

      $alunos = $alunoRepo->buscarTodosAtivos();
      $turmas = $turmaRepo->buscarTodasAtivas(); // O método simples que criamos
      $csrfToken = Auth::generateCsrfToken();

      view('matricula.form', [
         'alunos' => $alunos,
         'turmas' => $turmas,
         'csrfToken' => $csrfToken
      ]);
   }

   /**
    * Salva a nova matrícula (POST /matriculas/salvar)
    */
   public function store()
   {
      $dados = $_POST;
      Auth::validateCsrfToken($dados['csrf_token']);

      $aluno_id = filter_input(INPUT_POST, 'aluno_id', FILTER_VALIDATE_INT);
      $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);

      // RN03: Validação básica
      if (!$aluno_id || !$turma_id) {
         redirect('/matriculas?erro=invalido');
      }

      // Tenta matricular
      $resultado = $this->matriculaRepo->matricular($aluno_id, $turma_id);

      if ($resultado === true) {
         AuditLogger::log(Auth::id(), "Matriculou aluno ID {$aluno_id} na turma ID {$turma_id}");
         redirect('/matriculas?sucesso=1');
      } else {
         redirect('/matriculas?erro=' . urlencode($resultado));
      }
   }
}