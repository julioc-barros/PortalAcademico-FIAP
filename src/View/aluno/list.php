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
               <td><?= htmlspecialchars(formatarCpf($aluno->cpf)); ?></td>
               <td class="action-buttons">
                  <a href="<?= route('alunos.matriculas', ['aluno_id' => $aluno->id]) ?>" class="btn btn-sm action-btn"
                     title="Gerenciar Matrículas">
                     Gerenciar Matriculas
                  </a>

                  <a href="<?= route('alunos.edit', ['id' => $aluno->id]) ?>" class="btn btn-sm action-btn"
                     title="Editar Aluno">
                     <i class="bi bi-pencil-square"></i>
                  </a>

                  <form action="<?= route('alunos.delete') ?>" method="POST" class="d-inline"
                     data-confirm="Tem certeza que deseja excluir este aluno? Esta ação marcará o aluno como inativo.">
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

<script>
   $(document).ready(function () {
      const urlParams = new URLSearchParams(window.location.search);
      const sucesso = urlParams.get('sucesso');
      const erro = urlParams.get('erro');

      if (sucesso) {
         let title = 'Sucesso!';
         let text = '';
         switch (sucesso) {
            case '1': text = 'Aluno cadastrado com sucesso!'; break;
            case 'atualizado': text = 'Aluno atualizado com sucesso!'; break;
            case 'excluido': text = 'Aluno excluído com sucesso!'; break;
            default: text = 'Operação realizada com sucesso!';
         }
         Swal.fire({ title: title, text: text, icon: 'success', background: 'var(--dark-bg-secondary)', color: 'var(--dark-text-primary)' });
      }

      if (erro) {
         let title = 'Erro!';
         let text = '';
         switch (erro) {
            case 'id_invalido': text = 'ID inválido fornecido.'; break;
            case 'aluno_nao_encontrado': text = 'Aluno não encontrado.'; break;
            case 'excluir': text = 'Falha ao excluir o aluno.'; break;
            default: text = decodeURIComponent(erro); // Para erros genéricos ou do banco
         }
         Swal.fire({ title: title, text: text, icon: 'error', background: 'var(--dark-bg-secondary)', color: 'var(--dark-text-primary)' });
      }
   });
</script>