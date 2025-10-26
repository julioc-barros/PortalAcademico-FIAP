<?php
use PortalAcademicoFIAP\Service\Auth;
?>
<aside class="sidebar">
    <div class="side-inner">
        <div class="profile">
            <a href="<?= route('dashboard') ?>">
                <img src="<?= APP_URL ?>/assets/img/fiap_logo.webp" alt="Logo FIAP" class="img-fluid">
            </a>
        </div>

        <div class="nav-menu">
            <ul>
                <li>
                    <a href="<?= route('dashboard') ?>"><i class="bi bi-speedometer2 me-2"></i>Dashboard</a>
                </li>

                <li class="accordion">
                    <a href="#" data-bs-toggle="collapse" data-bs-target="#area-academico" aria-expanded="false"
                        aria-controls="area-academico" class="collapsible">
                        <i class="bi bi-book me-2"></i>Acadêmico
                    </a>
                    <div id="area-academico" class="collapse">
                        <ul>
                            <li>
                                <a href="<?= route('alunos.index') ?>">
                                    <i class="bi bi-people me-2"></i> Alunos
                                </a>
                            </li>
                            <li>
                                <a href="<?= route('turmas.index') ?>">
                                    <i class="bi bi-collection me-2"></i> Turmas
                                </a>
                            </li>
                            <li>
                                <a href="<?= route('matriculas.index') ?>">
                                    <i class="bi bi-person-plus me-2"></i> Matrículas
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <?php if (Auth::isSuperAdmin()): ?>
                    <li class="accordion">
                        <a href="#" data-bs-toggle="collapse" data-bs-target="#area-admin" aria-expanded="false"
                            aria-controls="area-admin" class="collapsible">
                            <i class="bi bi-person-lock me-2"></i>Administração
                        </a>
                        <div id="area-admin" class="collapse">
                            <ul>
                                <li>
                                    <a href="<?= route('admin.users') ?>">
                                        <i class="bi bi-shield-lock me-2"></i> Usuários Admin
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>
                <?php endif; ?>

            </ul>
        </div>

        <div class="sidebar-footer">
            <a href="#" class="btn btn-outline-danger w-100 js-menu-toggle">
                <i class="bi bi-x-circle me-2"></i> Fechar Menu
            </a>
        </div>
    </div>

</aside>