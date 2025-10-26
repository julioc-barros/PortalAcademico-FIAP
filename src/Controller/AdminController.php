<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\AlunoRepository;

class AdminController
{
    /**
     * Exibe a página principal (Dashboard) - (GET /)
     */
    public function dashboard()
    {
        // --- BUSCA DE DADOS (POR ENQUANTO, MOCKADO) ---
        $alunoRepo = new AlunoRepository();

        $totalAlunos = $alunoRepo->ContarAtivos();

        // Vamos usar dados fixos por enquanto:
        $stats = [
            'total_alunos' => $totalAlunos,
            'total_turmas' => 8,  // Do nosso dump
            'total_matriculas' => 26 // Do nosso dump
        ];

        // Carrega a view do dashboard e passa os dados para ela
        view("admin.dashboard", ["stats" => $stats]);
    }
}