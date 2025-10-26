<?php
use PortalAcademicoFIAP\Service\Auth;
?>
<nav class="navbar">
    <div class="navbar-left">
        <?php // SÓ MOSTRA O TOGGLE SE ESTIVER LOGADO ===
        if (Auth::check()): ?>
            <?php require __DIR__ . '/toggle-menu.php'; ?>
        <?php endif; ?>
        <div class="logo">
            <a href="<?= route('dashboard') ?>">
                <img src="<?= APP_URL ?>/assets/img/fiap_logo.webp" alt="logo FIAP">
            </a>
        </div>
    </div>

    <?php // === [AÇÃO] SÓ MOSTRA O PERFIL/SAIR SE ESTIVER LOGADO ===
    if (Auth::check()): ?>
        <div class="container-data-perfil">
            <span class="navbar-text me-3" style="color: var(--dark-text-primary);">
                <i class="bi bi-person-circle me-1"></i> Olá, <?= htmlspecialchars(Auth::userName() ?? 'Admin'); ?>
            </span>
            <a href="<?= route('logout') ?>" class="btn btn-outline-danger btn-sm" title="Sair">
                <i class="bi bi-box-arrow-right"></i> Sair
            </a>
        </div>
    <?php endif; ?>
</nav>