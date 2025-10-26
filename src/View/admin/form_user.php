<?php
require __DIR__ . '/../template/header.php';

$isEdit = isset($admin);
$nome_admin = $oldInput['nome'] ?? ($admin->nome ?? '');
$email_admin = $oldInput['email'] ?? ($admin->email ?? '');
$is_super_admin_value = $oldInput['is_super_admin'] ?? ($admin->is_super_admin ?? '0'); // Padrão é '0' (Não)

$tituloPagina = $isEdit ? "Editar Administrador: " . htmlspecialchars($nome_admin) : "Novo Administrador";
$formAction = $isEdit ? route('admin.users.update') : route('admin.users.store');
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2"><?= htmlspecialchars($tituloPagina); ?></h1>
   <a href="<?= route('admin.users.index') ?>" class="btn btn-sm btn-outline-secondary">Voltar</a>
</div>

<form action="<?= $formAction; ?>" method="POST">
   <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">
   <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= $admin->id; ?>"><?php endif; ?>

   <div class="row g-3">
      <div class="col-md-6">
         <label for="nome" class="form-label">Nome Completo *</label>
         <input type="text" class="form-control" id="nome" name="nome" required minlength="3"
            value="<?= htmlspecialchars($nome_admin); ?>">
      </div>
      <div class="col-md-6">
         <label for="email" class="form-label">E-mail *</label>
         <input type="email" class="form-control" id="email" name="email" required
            value="<?= htmlspecialchars($email_admin); ?>">
      </div>

      <div class="col-md-12">
         <label class="form-label">Permissão *</label>
         <div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="is_super_admin" id="super_admin_nao" value="0"
                  <?= $is_super_admin_value == '0' ? 'checked' : ''; ?>>
               <label class="form-check-label" for="super_admin_nao">Administrador Padrão</label>
            </div>
            <div class="form-check form-check-inline">
               <input class="form-check-input" type="radio" name="is_super_admin" id="super_admin_sim" value="1"
                  <?= $is_super_admin_value == '1' ? 'checked' : ''; ?>>
               <label class="form-check-label" for="super_admin_sim">Super Administrador</label>
            </div>
         </div>
      </div>

      <hr class="my-3">
      <?php if ($isEdit): ?><small class="text-muted col-12 mb-2">Deixe os campos de senha em branco para não
            alterá-la.</small><?php endif; ?>

      <div class="col-md-6">
         <label for="senha" class="form-label"><?= $isEdit ? 'Nova Senha' : 'Senha *' ?></label>
         <input type="password" class="form-control" id="senha" name="senha" minlength="8"
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" <?= !$isEdit ? 'required' : ''; ?>>
         <?php if (!$isEdit): ?>
            <div class="form-text">Mínimo 8 caracteres, com maiúsculas, minúsculas, números e símbolos.</div>
         <?php endif; ?>
      </div>
      <div class="col-md-6">
         <label for="senha_confirma"
            class="form-label"><?= $isEdit ? 'Confirmar Nova Senha' : 'Confirmar Senha *' ?></label>
         <input type="password" class="form-control" id="senha_confirma" name="senha_confirma" <?= !$isEdit ? 'required' : ''; ?>>
      </div>
   </div>

   <hr class="my-4">
   <button class="btn btn-primary" type="submit">Salvar Administrador</button>
</form>

<?php require __DIR__ . '/../template/footer.php'; ?>
