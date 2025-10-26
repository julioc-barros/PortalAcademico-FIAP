<?php require __DIR__ . '/../template/header.php';

use PortalAcademicoFIAP\Service\Auth; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">Gerenciamento de Turmas</h1>
   <div class="btn-toolbar mb-2 mb-md-0">
      <a href="<?= APP_URL ?>/turmas/novo" class="btn btn btn-sm btn-outline-success">
         + Nova Turma
      </a>
   </div>
</div>

<div class="table-responsive">
   <table id="tabela-dados" class="table table-striped table-sm">
      <thead>
         <tr>
            <th scope="col">Nome da Turma</th>
            <th scope="col">Descrição</th>
            <th scope="col">Nº de Alunos</th>
            <th scope="col">Ações</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($turmas as $turma): ?>
            <tr>
               <td><?= htmlspecialchars($turma->nome); ?></td>
               <td><?= htmlspecialchars($turma->descricao); ?></td>
               <td>
                  <?= htmlspecialchars($turma->total_alunos); ?>
               </td>
               <td class="action-buttons">
                  <a href="<?= route('turmas.show', ['id' => $turma->id]) ?>" class="btn btn-sm action-btn">Ver
                     Alunos</a>
                  <a href="<?= route('turmas.edit', ['id' => $turma->id]) ?>" class="btn btn-sm action-btn"><i
                        class="bi bi-pencil-square"></i></a>

                  <form action="<?= route('turmas.delete') ?>" method="POST" class="d-inline"
                     data-confirm="Tem certeza? Apenas turmas sem alunos podem ser excluídas. Esta ação marcará a turma como inativa.">
                     <input type="hidden" name="csrf_token" value="<?= Auth::generateCsrfToken(); ?>">
                     <input type="hidden" name="id" value="<?= $turma->id; ?>">
                     <button type="submit" class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button>
                  </form>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>

<?php require __DIR__ . '/../template/footer.php'; ?>