<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\AlunoRepository;
use PortalAcademicoFIAP\Repository\TurmaRepository;

class AdminController
{
    /**
     * Exibe a página principal (Dashboard)
     */
    public function dashboard()
    {
        $alunoRepo = new AlunoRepository();
        $TurmaRepo = new TurmaRepository();

        $totalAlunos = $alunoRepo->ContarAtivos();
        $totalTurmas = $TurmaRepo->ContarAtivos();

        // Vamos usar dados fixos por enquanto:
        $stats = [
            'total_alunos' => $totalAlunos,
            'total_turmas' => $totalTurmas,
            'total_matriculas' => 26 // Do nosso dump
        ];

        // Carrega a view do dashboard e passa os dados para ela
        view("admin.dashboard", ["stats" => $stats]);
    }
}