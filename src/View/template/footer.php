</div>
</main>
<footer class="footer mt-auto py-3 bg-light">
   <div class="container">
      <span class="text-muted">Portal Acadêmico FIAP &copy; <?= date('Y'); ?></span>
   </div>
</footer>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<script>
   $(document).ready(function () {
      // Aplica o DataTables em qualquer tabela com o ID 'tabela-dados'
      // Isso atende RN01 (ordem), RN09 (paginação) e RN10 (busca) automaticamente.
      $('#tabela-dados').DataTable({
         "language": {
            "url": "https://cdn.datatables.net/plug-ins/2.0.8/i18n/pt-BR.json"
         }
      });
   });
</script>

</body>

</html>