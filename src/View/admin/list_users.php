<?php require __DIR__ . '/../template/header.php';

use PortalAcademicoFIAP\Service\Auth; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">Gerenciamento de Administradores</h1>
   <a href="<?= route('admin.users.create') ?>" class="btn btn-sm btn-outline-success">
      <i class="bi bi-plus-circle me-1"></i> Novo Administrador
   </a>
</div>

<div class="table-responsive">
   <table id="tabela-dados" class="table table-striped table-sm">
      <thead>
         <tr>
            <th>Nome</th>
            <th>E-mail</th>
            <th>Super Admin?</th>
            <th>Ações</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($admins as $admin): ?>
            <tr>
               <td><?= htmlspecialchars($admin->nome); ?></td>
               <td><?= htmlspecialchars($admin->email); ?></td>
               <td>
                  <?= $admin->is_super_admin ? '<span class="badge bg-success">Sim</span>' : '<span class="badge bg-secondary">Não</span>'; ?>
               </td>
               <td>
                  <a href="<?= route('admin.users.edit', ['id' => $admin->id]) ?>" class="btn btn-sm btn-outline-primary"
                     title="Editar">
                     <i class="bi bi-pencil-square"></i>
                  </a>

                  <?php if (Auth::id() !== $admin->id): // Não mostra botão de excluir para si mesmo ?>
                     <form action="<?= route('admin.users.delete') ?>" method="POST" class="d-inline"
                        data-confirm="Tem certeza que deseja excluir este administrador?">
                        <input type="hidden" name="csrf_token" value="<?= Auth::generateCsrfToken(); ?>">
                        <input type="hidden" name="id" value="<?= $admin->id; ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                           <i class="bi bi-trash3"></i>
                        </button>
                     </form>
                  <?php endif; ?>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>

<?php require __DIR__ . '/../template/footer.php'; ?>
