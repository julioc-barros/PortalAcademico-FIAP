<?php require __DIR__ . '/../template/header.php'; ?>

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
               <td>
                  <a href="/alunos/editar?id=<?= $aluno->id; ?>" class="btn btn-sm btn-outline-primary">Editar</a>

                  <form action="/alunos/excluir" method="POST" class="d-inline"
                     onsubmit="return confirm('Tem certeza que deseja excluir este aluno?');">
                     <input type="hidden" name="csrf_token"
                        value="<?= \PortalAcademicoFIAP\Service\Auth::generateCsrfToken(); ?>">
                     <input type="hidden" name="id" value="<?= $aluno->id; ?>">
                     <button typea="submit" class="btn btn-sm btn-outline-danger">Excluir</button>
                  </form>
               </td>
            </tr>
         <?php endforeach; ?>
      </tbody>
   </table>
</div>

<?php require __DIR__ . '/../template/footer.php';?>