<?php require __DIR__ . '/../template/header.php'; // Inclui o topo ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">Alunos da Turma: <?= htmlspecialchars($turma->nome); ?></h1>
   <a href="<?= APP_URL ?>/turmas" class="btn btn-sm btn-outline-secondary">
      Voltar para Turmas
   </a>
</div>

<?php if (empty($alunos)): ?>
   <div class="alert alert-info">Nenhum aluno matriculado nesta turma ainda.</div>
<?php else: ?>
   <div class="table-responsive">
      <table class="table table-striped table-sm">
         <thead>
            <tr>
               <th scope="col">Nome</th>
               <th scope="col">E-mail</th>
               <th scope="col">CPF</th>
            </tr>
         </thead>
         <tbody>
            <?php foreach ($alunos as $aluno): ?>
               <tr>
                  <td><?= htmlspecialchars($aluno->nome); ?></td>
                  <td><?= htmlspecialchars($aluno->email); ?></td>
                  <td><?= htmlspecialchars($aluno->cpf); ?></td>
               </tr>
            <?php endforeach; ?>
         </tbody>
      </table>
   </div>
<?php endif; ?>

<?php require __DIR__ . '/../template/footer.php'; // Inclui o rodapé ?>