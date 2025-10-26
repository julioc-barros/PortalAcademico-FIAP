<?php
use PortalAcademicoFIAP\Service\Auth;
?>
<nav class="navbar">
    <div class="navbar-left">
        <?php require __DIR__ . '/toggle-menu.php'; // Botão Hamburger ?>
        <div class="logo">
            <a href="<?= route('dashboard') ?>">
                <img src="<?= APP_URL ?>/assets/img/Artboard-1.webp" alt="logo FIAP">
            </a>
        </div>
    </div>

    <div class="container-data-perfil">
        <span>
            Olá, <?= htmlspecialchars(Auth::userName() ?? 'Admin'); ?>
        </span>
        <a href="<?= route('logout') ?>" class="btn btn-outline-danger btn-sm" title="Sair">
            <i class="bi bi-box-arrow-right"></i>
        </a>
    </div>
</nav>