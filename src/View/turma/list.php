<?php require __DIR__ . '/../template/header.php'; // Inclui o topo ?>

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
            <th scope="col">Nº de Alunos (RN06)</th>
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
               <td>
                  <a href="<?= APP_URL ?>/turmas/visualizar?id=<?= htmlspecialchars($turma->id); ?>"
                     class="btn btn-sm btn-outline-success">Visualizar Alunos</a>
                  <a href="<?= APP_URL ?>/turmas/editar?id=<?= htmlspecialchars($turma->id); ?>"
                     class="btn btn-sm btn-outline-primary">Editar</a>
                  <form action="<?= APP_URL ?>/turmas/excluir" method="POST" class="d-inline"
                     onsubmit="return confirm('Tem certeza?');">
                     <input type="hidden" name="csrf_token"
                        value="<?= \PortalAcademicoFIAP\Service\Auth::generateCsrfToken(); ?>">
                     <input type="hidden" name="id" value="<?= htmlspecialchars($turma->id); ?>">
                     <button type="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                  </form>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>

<?php require __DIR__ . '/../template/footer.php'; // Inclui o rodapé ?>