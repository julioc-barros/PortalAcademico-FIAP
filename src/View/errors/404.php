<?php
use PortalAcademicoFIAP\Service\Auth;
require __DIR__ . '/../template/header.php';
?>

<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
   <div class="text-center">
      <h1 class="display-1 fw-bold text-danger">404</h1>
      <p class="fs-3"> <span class="text-danger">Oops!</span> Página Não Encontrada.</p>
      <p class="lead">
         A página que você está procurando não existe ou foi movida.
      </p>
      <?php
      if (Auth::check()): ?>
         <a href="<?= route('dashboard') ?>" class="btn btn-primary">Voltar para o Dashboard</a>
      <?php else: ?>
         <a href="<?= route('login') ?>" class="btn btn-primary">Voltar para o Login</a>
      <?php endif; ?>
   </div>
</div>

<?php require __DIR__ . '/../template/footer.php'; ?>