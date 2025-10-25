<?php
namespace PortalAcademicoFIAP\Controller;

// (No futuro, vamos importar os Repositories aqui para buscar os dados)
// use PortalAcademicoFIAP\Repository\AlunoRepository;

class AdminController
{
    /**
     * Exibe a página principal (Dashboard) - (GET /)
     */
    public function dashboard()
    {
        // --- BUSCA DE DADOS (POR ENQUANTO, MOCKADO) ---
        // $alunoRepo = new AlunoRepository();
        // $turmaRepo = new TurmaRepository();
        // $matriculaRepo = new MatriculaRepository();
        
        // $totalAlunos = $alunoRepo->countAtivos();
        // $totalTurmas = $turmaRepo->countAtivos();
        // $totalMatriculas = $matriculaRepo->count();
        
        // Vamos usar dados fixos por enquanto:
        $stats = [
            'total_alunos' => 30, // Do nosso dump
            'total_turmas' => 8,  // Do nosso dump
            'total_matriculas' => 26 // Do nosso dump
        ];

        // Carrega a view do dashboard e passa os dados para ela
        // require __DIR__ . '/../View/admin/dashboard.php';
    }
}