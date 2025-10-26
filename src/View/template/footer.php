<!-- footer.php -->

</main>
<footer class="footer mt-auto py-3 bg-light" style="text-align: center;">
   <div class="container">
      <span class="text-muted">Portal Acadêmico FIAP &copy; <?= date(format: 'Y'); ?></span>
   </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<script>
   $(document).ready(function () {
      // Aplica o DataTables em qualquer tabela com o ID 'tabela-dados'
      $('#tabela-dados').DataTable({
         "columnDefs": [{
            "targets": 3,
            "orderable": false
         }],
         "language": {
            "url": "https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json"
         }
      });
   });
</script>

<script>
   $(function () {
      'use strict';

      // Seleciona TODOS os botões de toggle (o burger E o "Fechar Menu")
      var $menuToggles = $('.js-menu-toggle');

      if ($menuToggles.length > 0) {
         // Adiciona o clique a TODOS eles
         $menuToggles.click(function (e) {
            e.preventDefault();

            if ($('body').hasClass('show-sidebar')) {
               // Se está aberto, FECHA
               $('body').removeClass('show-sidebar');
               $menuToggles.removeClass('active'); // Remove 'active' de TODOS os botões
            } else {
               // Se está fechado, ABRE
               $('body').addClass('show-sidebar');
               // Adiciona 'active' APENAS ao ícone burger (o 'X')
               $('.burger.js-menu-toggle').addClass('active');
            }
         });

         // Clique fora do menu (fecha o menu)
         $(document).mouseup(function (e) {
            var container = $(".sidebar");
            if (!container.is(e.target) && container.has(e.target).length === 0) {
               if ($('body').hasClass('show-sidebar')) {
                  $('body').removeClass('show-sidebar');
                  $menuToggles.removeClass('active');
               }
            }
         });
      }

      // Lógica do Accordion (Bootstrap 5)
      $('.collapsible').on('click', function (e) {
         e.preventDefault();
         var targetId = $(this).attr('data-bs-target');
         var $collapseTarget = $(targetId);
         var collapseInstance = bootstrap.Collapse.getOrCreateInstance($collapseTarget[0]);
         collapseInstance.toggle();
         var isExpanded = $(this).attr('aria-expanded') === 'true';
         $(this).attr('aria-expanded', !isExpanded);
      });
   });
</script>

<script>
   $(document).ready(function () {
      // Intercepta o submit de QUALQUER formulário que tenha o atributo 'data-confirm'
      $('form[data-confirm]').on('submit', function (e) {
         e.preventDefault(); // Impede o envio normal do formulário

         var form = this; // Guarda a referência do formulário
         var message = $(form).data('confirm'); // Pega a mensagem do atributo

         Swal.fire({
            title: 'Atenção!',
            text: message, // Usa a mensagem personalizada
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: 'var(--dark-danger)', // Usa a cor do dark theme
            cancelButtonColor: '#6c757d', // Cinza padrão do Bootstrap
            confirmButtonText: 'Sim, continuar!',
            cancelButtonText: 'Cancelar',
            background: 'var(--dark-bg-secondary)', // Fundo do modal
            color: 'var(--dark-text-primary)' // Cor do texto
         }).then((result) => {
            if (result.isConfirmed) {
               // Se o usuário confirmou, envia o formulário
               form.submit();
            }
         });
      });
   });
</script>

<script>
   $(document).ready(function () {

      // 1. Exibe Erros de Validação (se existirem)
      var validationErrors = <?= isset($errors) ? json_encode($errors) : 'null'; ?>;
      if (validationErrors && validationErrors.length > 0) {
         let errorHtml = '<ul style="text-align: left; list-style-position: inside;">';
         validationErrors.forEach(function (error) {
            let escapedError = $('<div>').text(error).html();
            errorHtml += '<li>' + escapedError + '</li>';
         });
         errorHtml += '</ul>';

         Swal.fire({
            title: 'Erro de Validação!',
            html: errorHtml,
            icon: 'error',
            confirmButtonColor: 'var(--dark-danger)',
            background: 'var(--dark-bg-secondary)',
            color: 'var(--dark-text-primary)'
         });
      }

      // 2. Exibe Mensagem de Sucesso (se existir via Flash)
      var successMessage = <?= isset($success) ? json_encode($success) : 'null'; ?>;
      if (successMessage) {
         let title = 'Sucesso!';
         let text = '';
         switch (successMessage) {
            case '1': case 'cadastrado': text = 'Registro cadastrado com sucesso!'; break;
            case 'atualizado': text = 'Registro atualizado com sucesso!'; break;
            case 'excluido': text = 'Registro excluído com sucesso!'; break;
            case 'matriculado': text = 'Aluno matriculado com sucesso!'; break;
            case 'desmatriculado': text = 'Aluno desmatriculado com sucesso!'; break;
            default: text = successMessage;
         }
         Swal.fire({
            title: title, text: text, icon: 'success',
            background: 'var(--dark-bg-secondary)', color: 'var(--dark-text-primary)'
         });
      }

      // 3. Exibe Mensagem de Erro Geral (se existir via Flash)
      var errorMessage = <?= isset($error) ? json_encode($error) : 'null'; ?>;
      if (errorMessage && !validationErrors) { // Só mostra erro geral se não houver erro de validação
         let title = 'Erro!';
         let text = '';
         switch (errorMessage) {
            case 'id_invalido': text = 'ID inválido fornecido.'; break;
            case 'nao_encontrado':
            case 'aluno_nao_encontrado':
            case 'turma_nao_encontrada': text = 'Registro não encontrado.'; break;
            case 'excluir_falhou': text = 'Falha ao excluir. Verifique dependências (ex: alunos matriculados).'; break;
            case 'falha_desmatricular': text = 'Não foi possível desmatricular o aluno.'; break;
            case 'invalido':
            case 'dados_matricula_invalidos':
            case 'dados_desmatricula_invalidos': text = 'Dados inválidos fornecidos.'; break;
            case 'acesso_negado': text = 'Acesso negado. Você não tem permissão para acessar esta área.'; break; // Erro do middleware Super Admin
            default: text = errorMessage;
         }
         // Trata erro RN04 especificamente
         if (text.includes('RN04')) {
            text = 'Este aluno já está matriculado nesta turma.';
         }
         Swal.fire({
            title: title, text: text, icon: 'error',
            background: 'var(--dark-bg-secondary)', color: 'var(--dark-text-primary)'
         });
      }

   });
</script>

</body>

</html>