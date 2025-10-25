<?php use PortalAcademicoFIAP\Service\Auth; ?>
<!DOCTYPE html>
<html lang="pt-br" class="h-100">

<head>
   <meta charset="UTF-M">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Portal FIAP</title>

   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

   <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

   <style>
      .navbar {
         background-color: #ED145B;
      }

      /* Cor FIAP */
      .navbar .navbar-brand,
      .navbar .nav-link {
         color: #fff !important;
      }

      .bd-placeholder-img {
         font-size: 1.125rem;
         text-anchor: middle;
         -webkit-user-select: none;
         -moz-user-select: none;
         user-select: none;
      }

      @media (min-width: 768px) {
         .bd-placeholder-img-lg {
            font-size: 3.5rem;
         }
      }

      main>.container {
         padding: 60px 15px 0;
      }
   </style>
</head>

<body class="d-flex flex-column h-100">

   <header>
      <nav class="navbar navbar-expand-md navbar-dark fixed-top">
         <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="/">Portal Acadêmico FIAP</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse"
               aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
               <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
               <ul class="navbar-nav me-auto mb-2 mb-md-0">
                  <li class="nav-item">
                     <a class="nav-link active" aria-current="page" href="/">Dashboard</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/alunos">Alunos</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/turmas">Turmas</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" href="/matriculas">Matrículas</a>
                  </li>
               </ul>
               <div class="d-flex text-white">
                  <span class="navbar-text me-3">
                     Olá, <?= htmlspecialchars(Auth::userName() ?? 'Admin'); ?>
                  </span>
                  <a href="/logout" class="btn btn-outline-light">Sair</a>
               </div>
            </div>
         </div>
      </nav>
   </header>

   <main class="flex-shrink-0">
      <div class="container"></div>