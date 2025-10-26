<?php
use PortalAcademicoFIAP\Service\Auth;
require __DIR__ . '/../template/header.php';
?>

<div class="d-flex align-items-center justify-content-center" style="min-height: 70vh;">
   <div class="text-center">
      <h1 class="display-1 fw-bold text-warning">500</h1>
      <p class="fs-3"> <span class="text-warning">Oops!</span> Erro Interno do Servidor.</p>
      <p class="lead">
         Ocorreu um problema inesperado no servidor. Tente novamente mais tarde.
      </p>

      <?php // Mostra detalhes do erro APENAS em ambiente de desenvolvimento
      if (defined('APP_ENV') && APP_ENV === 'development' && isset($errorMessage)): ?>
         <div class="alert alert-danger mt-4 text-start">
            <strong>Detalhes do Erro (Dev Mode):</strong>
            <pre style="white-space: pre-wrap; word-break: break-all;"><?= htmlspecialchars($errorMessage); ?></pre>
         </div>
      <?php endif; ?>

      <?php
      if (Auth::check()): ?>
         <a href="<?= route('dashboard') ?>" class="btn btn-primary">Voltar para o Dashboard</a>
      <?php else: ?>
         <a href="<?= route('login') ?>" class="btn btn-primary">Voltar para o Login</a>
      <?php endif; ?>
   </div>
</div>

<?php require __DIR__ . '/../template/footer.php'; ?>