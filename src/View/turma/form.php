<?php
// Inclui o topo
require __DIR__ . '/../template/header.php';

// Lógica da View: Verifica se está editando ou criando
$isEdit = isset($turma);

$nome_turma = $turma->nome ?? '';
$descricao_turma = $turma->descricao ?? '';

$tituloPagina = $isEdit ? "Editar Turma: " . htmlspecialchars($nome_turma) : "Nova Turma";
$formAction = $isEdit ? APP_URL . '/turmas/atualizar' : APP_URL . '/turmas/salvar';
?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2"><?= htmlspecialchars($tituloPagina); ?></h1>
   <a href="<?= APP_URL ?>/turmas" class="btn btn-sm btn-outline-secondary">
      Voltar para Listagem
   </a>
</div>

<?php?>

<form action="<?= $formAction; ?>" method="POST">

   <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">

   <?php if ($isEdit): ?>
      <input type="hidden" name="id" value="<?= htmlspecialchars($turma->id); ?>">
   <?php endif; ?>

   <div class="row g-3">
      <div class="col-12">
         <label for="nome" class="form-label">Nome da Turma *</label>
         <input type_="text" class="form-control" id="nome" name="nome" required minlength="3"
            value="<?= htmlspecialchars($nome_turma); ?>">
      </div>

      <div class="col-12">
         <label for="descricao" class="form-label">Descrição</label>
         <textarea class="form-control" id="descricao" name="descricao"
            rows="3"><?= htmlspecialchars($descricao_turma); ?></textarea>
      </div>
   </div>

   <hr class="my-4">

   <button class="btn btn-primary" type="submit">Salvar Turma</button>
</form>

<?php require __DIR__ . '/../template/footer.php'; ?>