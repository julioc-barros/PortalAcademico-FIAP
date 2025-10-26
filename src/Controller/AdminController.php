<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\AdminRepository;
use PortalAcademicoFIAP\Repository\AlunoRepository;
use PortalAcademicoFIAP\Repository\MatriculaRepository;
use PortalAcademicoFIAP\Repository\TurmaRepository;
use PortalAcademicoFIAP\Service\Auth;
use PortalAcademicoFIAP\Service\FlashMessageService;
use PortalAcademicoFIAP\Service\ValidatorService;
use PortalAcademicoFIAP\Service\AuditLogger;

class AdminController
{
    private AdminRepository $repository;

    public function __construct()
    {
        $this->repository = new AdminRepository();
    }

    /**
     * Exibe o Dashboard (GET /)
     */
    public function dashboard()
    {
        $error = FlashMessageService::get('error');
        $success = FlashMessageService::get('success');

        $alunoRepo = new AlunoRepository();
        $turmaRepo = new TurmaRepository();
        $matriculaRepo = new MatriculaRepository();

        $stats = [
            'total_alunos' => $alunoRepo->ContarAtivos(),
            'total_turmas' => $turmaRepo->ContarAtivos(),
            'total_matriculas' => $matriculaRepo->contarTotal(),
            'turma_mais_populosa' => $turmaRepo->findTurmasOrderedByStudentCount('DESC', 1)[0] ?? null,
            'turma_menos_populosa' => $turmaRepo->findTurmasOrderedByStudentCount('ASC', 1, true)[0] ?? null,
            'alunos_sem_turma' => $alunoRepo->ContarAlunosSemMatriculas()
        ];

        view('admin.dashboard', [
            'stats' => $stats,
            'error' => $error,
            'success' => $success
        ]);
    }
    /**
     * Listagem de Admins (GET /admin/usuarios)
     */
    public function indexUsers()
    {
        // Pega mensagens flash
        $success = FlashMessageService::get('success');
        $error = FlashMessageService::get('error');

        $admins = $this->repository->findAllActive();

        view('admin.list_users', [
            'admins' => $admins,
            'success' => $success,
            'error' => $error
        ]);
    }

    /**
     * Formulário de Cadastro (GET /admin/usuarios/novo)
     */
    public function createUser()
    {
        $csrfToken = Auth::generateCsrfToken();
        // Pega mensagens flash (incluindo sucesso/erro caso haja redirect de storeUser)
        $errors = FlashMessageService::get('errors');
        $oldInput = FlashMessageService::get('old_input') ?? [];
        $success = FlashMessageService::get('success'); // Não esperado aqui, mas seguro incluir
        $error = FlashMessageService::get('error');     // Para erro genérico do storeUser

        view('admin.form_user', compact('csrfToken', 'errors', 'oldInput', 'success', 'error'));
    }

    /**
     * Salvar Novo Admin (POST /admin/usuarios/salvar)
     */
    public function storeUser()
    {
        $dados = $_POST;
        Auth::validateCsrfToken($dados['csrf_token']);
        $errors = ValidatorService::validarNovoAdmin($dados);

        if (!empty($errors)) {
            FlashMessageService::set('errors', $errors);
            FlashMessageService::set('old_input', $dados);
            redirect(route('admin.users.create'));
        }

        if ($this->repository->saveAdmin($dados)) {
            AuditLogger::log(Auth::id(), "Cadastrou novo admin: {$dados['email']}");
            FlashMessageService::set('success', 'cadastrado'); // Usa Flash
            redirect(route('admin.users.index'));
        } else {
            FlashMessageService::set('error', 'Erro ao salvar o administrador no banco.'); // Usa Flash
            FlashMessageService::set('old_input', $dados);
            redirect(route('admin.users.create'));
        }
    }

    /**
     * Formulário de Edição (GET /admin/usuarios/editar)
     */
    public function editUser()
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            FlashMessageService::set('error', 'id_invalido'); // Usa Flash
            redirect(route('admin.users.index'));
        }

        $admin = $this->repository->findById($id);
        if (!$admin) {
            FlashMessageService::set('error', 'nao_encontrado'); // Usa Flash
            redirect(route('admin.users.index'));
        }

        $csrfToken = Auth::generateCsrfToken();
        // Pega mensagens flash
        $errors = FlashMessageService::get('errors');
        $oldInput = FlashMessageService::get('old_input') ?? [];
        $success = FlashMessageService::get('success'); // Não esperado aqui, mas seguro incluir
        $error = FlashMessageService::get('error');     // Para erro genérico do updateUser

        view('admin.form_user', compact('admin', 'csrfToken', 'errors', 'oldInput', 'success', 'error'));
    }

    /**
     * Atualizar Admin (POST /admin/usuarios/atualizar)
     */
    public function updateUser()
    {
        $dados = $_POST;
        Auth::validateCsrfToken($dados['csrf_token']);
        $errors = ValidatorService::validarUpdateAdmin($dados);

        if (!empty($errors)) {
            FlashMessageService::set('errors', $errors);
            FlashMessageService::set('old_input', $dados);
            redirect(route('admin.users.edit', ['id' => $dados['id']]));
        }

        if ($dados['id'] == Auth::id() && $dados['is_super_admin'] == '0') {
            FlashMessageService::set('error', 'Você não pode remover sua própria permissão de Super Admin.');
            FlashMessageService::set('old_input', $dados);
            redirect(route('admin.users.edit', ['id' => $dados['id']]));
        }

        if ($this->repository->updateAdmin($dados)) {
            AuditLogger::log(Auth::id(), "Atualizou admin ID: {$dados['id']}");
            FlashMessageService::set('success', 'atualizado'); // Usa Flash
            redirect(route('admin.users.index'));
        } else {
            FlashMessageService::set('error', 'Erro ao atualizar o administrador no banco.'); // Usa Flash
            FlashMessageService::set('old_input', $dados);
            redirect(route('admin.users.edit', ['id' => $dados['id']]));
        }
    }

    /**
     * Excluir Admin (POST /admin/usuarios/excluir)
     */
    public function deleteUser()
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $token = $_POST['csrf_token'] ?? null;
        Auth::validateCsrfToken($token);

        if (!$id) {
            FlashMessageService::set('error', 'id_invalido'); // Usa Flash
            redirect(route('admin.users.index'));
        }

        if ($this->repository->deleteLogicoAdmin($id)) {
            AuditLogger::log(Auth::id(), "Excluiu (soft delete) admin ID: {$id}");
            FlashMessageService::set('success', 'excluido'); // Usa Flash
            redirect(route('admin.users.index'));
        } else {
            if (Auth::id() === $id) {
                FlashMessageService::set('error', 'Você não pode excluir sua própria conta.'); // Usa Flash
            } else {
                FlashMessageService::set('error', 'Erro ao excluir o administrador.'); // Usa Flash
            }
            redirect(route('admin.users.index'));
        }
    }
}