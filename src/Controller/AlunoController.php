<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\AlunoRepository;
use PortalAcademicoFIAP\Repository\MatriculaRepository;
use PortalAcademicoFIAP\Repository\TurmaRepository;
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

   /**
    * Exibe a tela de gerenciamento de matrículas de um aluno
    */
   public function manipularMatriculas()
   {
      // Pegar o ID do aluno da URL
      $aluno_id = filter_input(INPUT_GET, 'aluno_id', FILTER_VALIDATE_INT);
      if (!$aluno_id) {
         redirect(route('alunos.index', ['erro' => 'id_aluno_invalido']));
      }

      // Buscar o aluno
      $aluno = $this->repository->findById($aluno_id);
      if (!$aluno) {
         redirect(route('alunos.index', ['erro' => 'aluno_nao_encontrado']));
      }

      // Buscar as turmas atuais do aluno
      $turmaRepo = new TurmaRepository();
      $turmasAtuais = $turmaRepo->findTurmasByAlunoId($aluno_id);

      // Buscar TODAS as turmas ativas (para o dropdown)
      $turmasDisponiveis = $turmaRepo->buscarTodasAtivas();

      // Filtrar turmas disponíveis (remover as que o aluno já está)
      $idsTurmasAtuais = array_map(fn($t) => $t->id, $turmasAtuais);
      $turmasParaMatricular = array_filter(
         $turmasDisponiveis,
         fn($t) => !in_array($t->id, $idsTurmasAtuais)
      );

      // Gerar token CSRF
      $csrfToken = Auth::generateCsrfToken();

      // Renderizar a view
      view('aluno.matriculas', [
         'aluno' => $aluno,
         'turmasAtuais' => $turmasAtuais,
         'turmasParaMatricular' => $turmasParaMatricular,
         'csrfToken' => $csrfToken
      ]);
   }

   /**
    * Processa a matrícula de um aluno em uma nova turma
    * Chamado a partir da tela de gerenciamento de matrículas do aluno.
    */
   public function matriculaAluno()
   {
      $dados = $_POST;

      // 1. Validar CSRF Token
      Auth::validateCsrfToken($dados['csrf_token']);

      // 2. Obter e Validar IDs
      $aluno_id = filter_input(INPUT_POST, 'aluno_id', FILTER_VALIDATE_INT);
      $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);

      if (!$aluno_id || !$turma_id) {
         redirect(route('alunos.index', ['erro' => 'dados_matricula_invalidos']));
      }

      // 3. Tentar Matricular usando o MatriculaRepository
      $matriculaRepo = new MatriculaRepository();
      $resultado = $matriculaRepo->matricular($aluno_id, $turma_id);

      // 4. Tratar o Resultado e Redirecionar
      if ($resultado === true) {
         AuditLogger::log(Auth::id(), "Matriculou aluno ID {$aluno_id} na turma ID {$turma_id}");
         redirect(route('alunos.matriculas', ['aluno_id' => $aluno_id, 'sucesso' => 'matriculado']));
      } else {
         redirect(route('alunos.matriculas', ['aluno_id' => $aluno_id, 'erro' => urlencode($resultado)]));
      }
   }

   /**
    * Processa a desmatrícula de um aluno de uma turma (POST /alunos/desmatricular)
    */
   public function desmatriculaAluno()
   {
      $dados = $_POST;

      // Validar CSRF Token
      Auth::validateCsrfToken($dados['csrf_token']);

      // Obter e Validar IDs
      $aluno_id = filter_input(INPUT_POST, 'aluno_id', FILTER_VALIDATE_INT);
      $turma_id = filter_input(INPUT_POST, 'turma_id', FILTER_VALIDATE_INT);

      // Tela que será redirecionado, importante para usar em mais de um lugar
      $redirectUrl = filter_input(INPUT_POST, 'redirect_url', FILTER_SANITIZE_URL);
      if (empty($redirectUrl)) {
         // Se não veio do formulário, volta para a página do aluno como padrão
         $redirectUrl = route('alunos.matriculas', ['aluno_id' => $aluno_id]);
      }

      if (!$aluno_id || !$turma_id) {
         redirect(route('alunos.index', ['erro' => 'dados_desmatricula_invalidos']));
      }

      // Tentar Desmatricular
      $matriculaRepo = new MatriculaRepository();
      $sucesso = $matriculaRepo->desmatricular($aluno_id, $turma_id);

      // Tratar o Resultado e Redirecionar
      if ($sucesso) {
         AuditLogger::log(Auth::id(), "Desmatriculou aluno ID {$aluno_id} da turma ID {$turma_id}");
         redirect($redirectUrl . (strpos($redirectUrl, '?') ? '&' : '?') . 'sucesso=desmatriculado');
      } else {
         redirect($redirectUrl . (strpos($redirectUrl, '?') ? '&' : '?') . 'erro=falha_desmatricular');
      }
   }

}