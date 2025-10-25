<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\AlunoRepository;

class AlunoController
{
   private AlunoRepository $repository;

   public function __construct()
   {
      $this->repository = new AlunoRepository();
   }

   /**
    * Exibe a listagem de alunos (GET /alunos)
    */
   public function index()
   {
      // Busca os dados no repositório
      $alunos = $this->repository->buscarTodosAtivos();

      // Carrega a view e passa os dados para ela
      // require __DIR__ . '/../View/aluno/list.php';
   }
}