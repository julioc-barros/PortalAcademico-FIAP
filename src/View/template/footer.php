<!-- footer.php -->

</main>
<footer class="footer mt-auto py-3 bg-light" style="text-align: center;">
   <div class="container">
      <span class="text-muted">Portal Acadêmico FIAP &copy; <?= date(format: 'Y'); ?></span>
   </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

</body>

</html>