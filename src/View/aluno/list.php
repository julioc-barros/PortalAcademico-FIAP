<?php require __DIR__ . '/../template/header.php';

use PortalAcademicoFIAP\Service\Auth; ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
   <h1 class="h2">Gerenciamento de Alunos</h1>
   <div class="btn-toolbar mb-2 mb-md-0">
      <a href="/alunos/novo" class="btn btn-sm btn-outline-success">
         + Novo Aluno
      </a>
   </div>
</div>

<?php ?>

<div class="table-responsive">
   <table id="tabela-dados" class="table table-striped table-sm">
      <thead>
         <tr>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">CPF</th>
            <th scope="col">Ações</th>
         </tr>
      </thead>
      <tbody>
         <?php foreach ($alunos as $aluno): ?>
            <tr>
               <td><?= htmlspecialchars($aluno->nome); ?></td>
               <td><?= htmlspecialchars($aluno->email); ?></td>
               <td><?= htmlspecialchars($aluno->cpf); ?></td>
               <td class="action-buttons">
                  <a href="<?= route('alunos.matriculas', ['aluno_id' => $aluno->id]) ?>"
                     class="btn btn-sm btn-outline-info" title="Gerenciar Matrículas">
                     <i class="bi bi-person-lines-fill"></i>
                  </a>

                  <a href="<?= route('alunos.edit', ['id' => $aluno->id]) ?>" class="btn btn-sm btn-outline-primary"
                     title="Editar Aluno">
                     <i class="bi bi-pencil-square"></i>
                  </a>

                  <form action="<?= route('alunos.delete') ?>" method="POST" class="d-inline"
                     onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
                     <input type="hidden" name="csrf_token" value="<?= Auth::generateCsrfToken(); ?>">
                     <input type="hidden" name="id" value="<?= $aluno->id; ?>">
                     <input type="hidden" name="redirect_url"
                        value="<?= route('alunos.matriculas', ['aluno_id' => $aluno->id]) ?>">
                     <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Aluno">
                        <i class="bi bi-trash3"></i>
                     </button>
                  </form>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>

<?php require __DIR__ . '/../template/footer.php'; ?>