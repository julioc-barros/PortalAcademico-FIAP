<?php require __DIR__ . '/../template/header.php'; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">Dashboard</h1>
</div>

<div class="row">
   <div class="col-md-4 mb-3">
      <div class="card text-white bg-primary shadow">
         <div class="card-body">
            <h5 class="card-title">Total de Alunos</h5>
            <p class="card-text fs-2 fw-bold">
               <?= $stats['total_alunos']; ?>
            </p>
            <a href="/alunos" class="text-white">Ver Alunos &raquo;</a>
         </div>
      </div>
   </div>

   <div class="col-md-4 mb-3">
      <div class="card text-white bg-success shadow">
         <div class="card-body">
            <h5 class="card-title">Total de Turmas</h5>
            <p class="card-text fs-2 fw-bold">
               <?= $stats['total_turmas']; ?>
            </p>
            <a href="/turmas" class="text-white">Ver Turmas &raquo;</a>
         </div>
      </div>
   </div>

   <div class="col-md-4 mb-3">
      <div class="card text-white bg-info shadow">
         <div class="card-body">
            <h5 class="card-title">Total de Matrículas</h5>
            <p class="card-text fs-2 fw-bold">
               <?= $stats['total_matriculas']; ?>
            </p>
            <a href="/matriculas" class="text-white">Ver Matrículas &raquo;</a>
         </div>
      </div>
   </div>
</div>

<?php require __DIR__ . '/../template/footer.php'; ?>