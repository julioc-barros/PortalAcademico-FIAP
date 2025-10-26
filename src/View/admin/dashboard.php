<?php require __DIR__ . '/../template/header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
   <div class="col-md-4 mb-3">
      <div class="card text-white bg-primary shadow">
         <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
               <div>
                  <h5 class="card-title mb-0">Alunos Ativos</h5>
                  <p class="card-text fs-2 fw-bold mb-0"><?= htmlspecialchars($stats['total_alunos']); ?></p>
               </div>
               <i class="bi bi-people-fill opacity-50" style="font-size: 3rem;"></i>
            </div>
            <a href="<?= route('alunos.index') ?>" class="text-white stretched-link">Ver detalhes</a>
         </div>
      </div>
   </div>

   <div class="col-md-4 mb-3">
      <div class="card text-white bg-success shadow">
         <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
               <div>
                  <h5 class="card-title mb-0">Turmas Ativas</h5>
                  <p class="card-text fs-2 fw-bold mb-0"><?= htmlspecialchars($stats['total_turmas']); ?></p>
               </div>
               <i class="bi bi-collection-fill opacity-50" style="font-size: 3rem;"></i>
            </div>
            <a href="<?= route('turmas.index') ?>" class="text-white stretched-link">Ver detalhes</a>
         </div>
      </div>
   </div>

   <div class="col-md-4 mb-3">
      <div class="card text-white bg-info shadow">
         <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
               <div>
                  <h5 class="card-title mb-0">Matrículas Realizadas</h5>
                  <p class="card-text fs-2 fw-bold mb-0"><?= htmlspecialchars($stats['total_matriculas']); ?></p>
               </div>
               <i class="bi bi-person-check-fill opacity-50" style="font-size: 3rem;"></i>
            </div>
            <a href="<?= route('turmas.index') ?>" class="text-white stretched-link">Ver detalhes</a>
         </div>
      </div>
   </div>

   <div class="col-md-4 mb-3">
      <div class="card text-white shadow" style="background-color: var(--dark-warning);">
         <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
               <div>
                  <h5 class="card-title mb-0">Turma Mais Cheia</h5>
                  <?php if ($stats['turma_mais_populosa']): ?>
                     <p class="card-text small mb-0" title="<?= htmlspecialchars($stats['turma_mais_populosa']->nome); ?>"
                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= htmlspecialchars($stats['turma_mais_populosa']->nome); ?>
                     </p>
                     <p class="card-text fs-2 fw-bold mb-0">
                        <?= htmlspecialchars($stats['turma_mais_populosa']->total_alunos); ?> <span
                           class="fs-6 fw-normal">alunos</span>
                     </p>
                  <?php else: ?>
                     <p class="card-text">N/A</p>
                  <?php endif; ?>
               </div>
               <i class="bi bi-graph-up opacity-50" style="font-size: 3rem;"></i>
            </div>
            <?php if ($stats['turma_mais_populosa']): ?>
               <a href="<?= route('turmas.show', ['id' => $stats['turma_mais_populosa']->id]) ?>"
                  class="text-white stretched-link">Ver turma</a>
            <?php endif; ?>
         </div>
      </div>
   </div>

   <div class="col-md-4 mb-3">
      <div class="card text-white shadow" style="background-color: var(--dark-info);">
         <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
               <div>
                  <h5 class="card-title mb-0">Turma Menos Cheia</h5>
                  <?php if ($stats['turma_menos_populosa']): ?>
                     <p class="card-text small mb-0" title="<?= htmlspecialchars($stats['turma_menos_populosa']->nome); ?>"
                        style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                        <?= htmlspecialchars($stats['turma_menos_populosa']->nome); ?>
                     </p>
                     <p class="card-text fs-2 fw-bold mb-0">
                        <?= htmlspecialchars($stats['turma_menos_populosa']->total_alunos); ?> <span
                           class="fs-6 fw-normal">alunos</span>
                     </p>
                  <?php else: ?>
                     <p class="card-text">N/A</p>
                  <?php endif; ?>
               </div>
               <i class="bi bi-graph-down opacity-50" style="font-size: 3rem;"></i>
            </div>
            <?php if ($stats['turma_menos_populosa']): ?>
               <a href="<?= route('turmas.show', ['id' => $stats['turma_menos_populosa']->id]) ?>"
                  class="text-white stretched-link">Ver turma</a>
            <?php endif; ?>
         </div>
      </div>
   </div>

   <div class="col-md-4 mb-3">
      <div class="card text-white shadow" style="background-color: var(--dark-danger);">
         <div class="card-body">
            <div class="d-flex justify-content-between align-items-center">
               <div>
                  <h5 class="card-title mb-0">Alunos Sem Turma</h5>
                  <p class="card-text fs-2 fw-bold mb-0"><?= htmlspecialchars($stats['alunos_sem_turma']); ?></p>
               </div>
               <i class="bi bi-person-x-fill opacity-50" style="font-size: 3rem;"></i>
            </div>
            <a href="<?= route('alunos.index') ?>" class="text-white stretched-link">Ver detalhes</a>
         </div>
      </div>
   </div>
</div>

<?php require __DIR__ . '/../template/footer.php'; ?>