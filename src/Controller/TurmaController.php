<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Repository\TurmaRepository;

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

}