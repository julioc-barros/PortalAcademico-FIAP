<?php require __DIR__ . '/../template/header.php'; // Inclui o topo ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">Realizar Nova Matrícula</h1>
</div>

<form action="<?= APP_URL ?>/matriculas/salvar" method="POST">

   <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">

   <div class="row g-3">

      <div class="col-md-6">
         <label for="aluno_id" class="form-label">Selecione o Aluno *</label>
         <select id="aluno_id" name="aluno_id" class="form-select" required>
            <option value="" disabled selected>-- Escolha um aluno --</option>
            <?php foreach ($alunos as $aluno): ?>
               <option value="<?= htmlspecialchars($aluno->id); ?>">
                  <?= htmlspecialchars($aluno->nome); ?> (CPF: <?= htmlspecialchars($aluno->cpf); ?>)
               </option>
            <?php endforeach; ?>
         </select>
      </div>

      <div class="col-md-6">
         <label for="turma_id" class="form-label">Selecione a Turma *</label>
         <select id="turma_id" name="turma_id" class="form-select" required>
            <option value="" disabled selected>-- Escolha uma turma --</option>
            <?php foreach ($turmas as $turma): ?>
               <option value="<?= htmlspecialchars($turma->id); ?>">
                  <?= htmlspecialchars($turma->nome); ?>
               </option>
            <?php endforeach; ?>
         </select>
      </div>
   </div>

   <hr class="my-4">

   <button class="btn btn-primary btn-lg" type="submit">Matricular Aluno</button>
</form>

<?php require __DIR__ . '/../template/footer.php'; ?>