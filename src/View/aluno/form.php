<?php
require __DIR__ . '/../template/header.php';

$isEdit = isset($aluno);

// Usa oldInput se existir, senão usa dados do $aluno (edição) ou vazio (criação)
$nome_aluno = $oldInput['nome'] ?? ($aluno->nome ?? '');
$data_nascimento_aluno = $oldInput['data_nascimento'] ?? ($aluno->data_nascimento ?? '');
$cpf_aluno = $oldInput['cpf'] ?? ($aluno->cpf ?? '');
$email_aluno = $oldInput['email'] ?? ($aluno->email ?? '');

$tituloPagina = $isEdit ? "Editar Aluno: " . htmlspecialchars($nome_aluno) : "Novo Aluno";
$formAction = $isEdit ? route('alunos.update') : route('alunos.store');

?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2"><?= $tituloPagina; ?></h1>
   <a href="/alunos" class="btn btn-sm btn-outline-secondary">
      Voltar para Listagem
   </a>
</div>

<?php ?>

<form action="<?= $formAction; ?>" method="POST">

   <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">

   <?php
   if ($isEdit): ?>
      <input type="hidden" name="id" value="<?= $aluno->id; ?>">
   <?php endif; ?>

   <div class="row g-3">
      <div class="col-md-8">
         <label for="nome" class="form-label">Nome Completo *</label>
         <input type="text" class="form-control" id="nome" name="nome" required minlength="3"
            value="<?= htmlspecialchars($nome_aluno); ?>">
      </div>

      <div class="col-md-4">
         <label for="data_nascimento" class="form-label">Data de Nascimento *</label>
         <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" required
            value="<?= htmlspecialchars($data_nascimento_aluno); ?>">
      </div>

      <div class="col-md-6">
         <label for="cpf" class="form-label">CPF (apenas números) *</label>
         <input type="text" class="form-control" id="cpf" name="cpf" required maxlength="11" pattern="\d{11}"
            value="<?= htmlspecialchars($cpf_aluno); ?>">
      </div>

      <div class="col-md-6">
         <label for="email" class="form-label">E-mail *</label>
         <input type="email" class="form-control" id="email" name="email" required
            value="<?= htmlspecialchars($email_aluno); ?>">
      </div>

      <hr class="my-4">
      <small class="text-muted">Deixe os campos de senha em branco para não alterá-la.</small>

      <div class="col-md-6">
         <label for="senha" class="form-label">Nova Senha</label>
         <input type="password" class="form-control" id="senha" name="senha" minlength="8"
            title="Mínimo 8 caracteres com maiúsculas, minúsculas, números e símbolos."
            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*\W).{8,}" <?php // Senha NÃO é obrigatória na edição
            if (!$isEdit)
               echo 'required'; ?>>
      </div>

      <div class="col-md-6">
         <label for="senha_confirma" class="form-label">Confirmar Nova Senha</label>
         <input type="password" class="form-control" id="senha_confirma" name="senha_confirma" <?php // Confirmação só é obrigatória se a senha for digitada
         if (!$isEdit)
            echo 'required'; ?>>
      </div>
   </div>

   <hr class="my-4">

   <button class="btn btn-primary" type="submit">Salvar Aluno</button>
</form>

<?php require __DIR__ . '/../template/footer.php'; ?>