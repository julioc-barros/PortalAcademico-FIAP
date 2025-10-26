<?php require __DIR__ . '/../template/header.php'; 

use PortalAcademicoFIAP\Service\Auth;?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">Gerenciar Matrículas de: <?= htmlspecialchars($aluno->nome); ?></h1>
   <a href="<?= route('alunos.index') ?>" class="btn btn-sm btn-outline-secondary">
      Voltar para Alunos
   </a>
</div>

<div class="row">
   <div class="col-md-6">
      <h3>Turmas Matriculadas Atualmente</h3>
      <?php if (empty($turmasAtuais)): ?>
         <div class="alert alert-info">Este aluno não está matriculado em nenhuma turma.</div>
      <?php else: ?>
         <ul class="list-group">
            <?php foreach ($turmasAtuais as $turma): ?>
               <li class="list-group-item d-flex justify-content-between align-items-center"
                  style="background-color: var(--dark-bg-secondary); border-color: var(--dark-border); color: var(--dark-text-primary);">
                  <span><?= htmlspecialchars($turma->nome); ?></span>

                  <form action="<?= route('alunos.desmatricular') ?>" method="POST" class="d-inline"
                     onsubmit="return confirm('Tem certeza que deseja desmatricular este aluno da turma <?= htmlspecialchars(addslashes($turma->nome)); ?>?');">
                     <input type="hidden" name="csrf_token"
                        value="<?= Auth::generateCsrfToken();?>">
                     <input type="hidden" name="aluno_id" value="<?= htmlspecialchars($aluno->id); ?>">
                     <input type="hidden" name="turma_id" value="<?= htmlspecialchars($turma->id); ?>">
                     <input type="hidden" name="redirect_url" value="<?= route('turmas.show', ['id' => $turma->id]) ?>">
                     <button type="submit" class="btn btn-sm btn-outline-warning" title="Desmatricular da Turma">
                        <i class="bi bi-person-dash"></i>
                     </button>
                  </form>
               </li>
            <?php endforeach; ?>
         </ul>
      <?php endif; ?>
   </div>

   <div class="col-md-6">
      <h3>Matricular em Nova Turma</h3>
      <?php if (empty($turmasParaMatricular)): ?>
         <div class="alert alert-secondary">Não há outras turmas disponíveis para matrícula ou o aluno já está em todas.
         </div>
      <?php else: ?>
         <form action="<?= route('alunos.matricular') ?>" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">
            <input type="hidden" name="aluno_id" value="<?= htmlspecialchars($aluno->id); ?>">

            <div class="mb-3">
               <label for="turma_id" class="form-label">Selecione a Turma *</label>
               <select id="turma_id" name="turma_id" class="form-select" required>
                  <option value="" disabled selected>-- Escolha uma turma --</option>
                  <?php foreach ($turmasParaMatricular as $turma): ?>
                     <option value="<?= htmlspecialchars($turma->id); ?>">
                        <?= htmlspecialchars($turma->nome); ?>
                     </option>
                  <?php endforeach; ?>
               </select>
            </div>
            <button type="submit" class="btn btn-success">
               <i class="bi bi-plus-circle me-2"></i> Matricular na Turma Selecionada
            </button>
         </form>
      <?php endif; ?>
   </div>
</div>

<?php require __DIR__ . '/../template/footer.php'; ?>