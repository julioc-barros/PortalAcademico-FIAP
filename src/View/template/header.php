<?php use PortalAcademicoFIAP\Service\Auth; ?>
<!DOCTYPE html>
<html lang="pt-br" class="h-100">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
   <title>Portal FIAP</title>

   <link rel="shortcut icon" type="imagex/png" href="<?= APP_URL ?>/assets/img/favicon.ico">
   <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
   <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
   <link rel='stylesheet'
      href='https://fonts.googleapis.com/css?family=Roboto%3A400%2C100%2C100italic%2C300%2C300italic%2C400italic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic&#038;ver=4.9.15'
      type='text/css' media='all' />

   <style>
      /* 1. Variáveis do Dark Theme */
      :root {
         --dark-bg-primary: #1a1a1a;
         --dark-bg-secondary: #2d2d2d;
         --dark-bg-tertiary: #383838;
         --dark-text-primary: #ffffff;
         --dark-text-secondary: #b3b3b3;
         --dark-text-muted: #888888;
         --dark-border: #404040;
         --dark-accent: #8D080A;
         --dark-accent-hover: #a50a0c;
         --dark-shadow: rgba(0, 0, 0, 0.3);
         --dark-success: #28a745;
         --dark-warning: #ffc107;
         --dark-danger: #dc3545;
         --dark-info: #17a2b8;
      }

      body {
         background-color: var(--dark-bg-secondary);
         color: var(--dark-text-secondary);
         font-family: 'Roboto', sans-serif;
      }

      main.container {
         padding-top: 80px;
         padding-bottom: 2rem;
         transition: margin-left 1s cubic-bezier(0.23, 1, 0.32, 1);
      }

      .card {
         background-color: var(--dark-bg-primary);
         border: 1px solid var(--dark-border);
         color: var(--dark-text-primary);
      }

      .table {
         --bs-table-bg: var(--dark-bg-primary);
         --bs-table-border-color: var(--dark-border);
         --bs-table-color: var(--dark-text-secondary);
         --bs-table-striped-bg: var(--dark-bg-secondary);
         --bs-table-striped-color: var(--dark-text-primary);
      }

      .form-control,
      .form-select {
         background-color: var(--dark-bg-tertiary);
         border: 1px solid var(--dark-border);
         color: var(--dark-text-primary);
      }

      .form-control:focus,
      .form-select:focus {
         background-color: var(--dark-bg-tertiary);
         border-color: var(--dark-accent);
         box-shadow: 0 0 0 0.25rem rgba(141, 8, 10, 0.5);
         color: var(--dark-text-primary);
      }

      .footer {
         background-color: var(--dark-bg-primary) !important;
         border-top: 1px solid var(--dark-border);
      }

      .footer .text-muted {
         color: var(--dark-text-muted) !important;
      }

      .navbar {
         display: flex;
         flex-wrap: wrap;
         align-items: center;
         justify-content: space-between;
         padding: 8px 20px;
         background-color: var(--dark-bg-primary);
         color: var(--dark-text-primary);
         width: 100%;
         position: fixed;
         top: 0;
         z-index: 1000;
      }

      .navbar-left {
         display: flex;
         align-items: center;
         gap: 15px;
      }

      .logo img {
         width: 100px;
         display: block;
      }

      .container-data-perfil {
         display: flex;
         align-items: center;
         gap: 15px;
         color: var(--dark-text-primary);
      }

      .burger {
         color: var(--dark-text-primary);
         cursor: pointer;
         position: relative;
         z-index: 1002;
         display: flex;
         align-items: center;
         justify-content: center;
         width: 40px;
         height: 40px;
         padding: 0;
         text-decoration: none;
      }

      .burger:before,
      .burger span,
      .burger:after {
         display: none !important;
      }

      .burger i {
         position: absolute;
         transition: transform 0.3s cubic-bezier(0.23, 1, 0.32, 1), opacity 0.3s ease-in-out;
         color: var(--dark-text-primary);
      }

      .burger .icon-default {
         opacity: 1;
         transform: rotate(0deg);
         pointer-events: auto;
      }

      .burger .icon-active {
         opacity: 0;
         transform: rotate(-90deg);
         pointer-events: none;
      }

      .burger.active .icon-default {
         opacity: 0;
         transform: rotate(90deg);
         pointer-events: none;
      }

      .burger.active .icon-active {
         opacity: 1;
         transform: rotate(0deg);
         pointer-events: auto;
      }

      aside {
         width: 250px;
         left: 0;
         z-index: 1001;
         position: fixed;
         height: 100vh;
         transform: translateX(-100%);
         background-color: var(--dark-bg-primary);
         transition: 1s transform cubic-bezier(0.23, 1, 0.32, 1);
         box-shadow: var(--dark-shadow);
         border-right: 1px solid var(--dark-border);
      }

      .show-sidebar aside {
         transform: translateX(0%);
      }

      aside .side-inner {
         height: 100vh;
         display: flex;
         flex-direction: column;
         padding: 0;
         overflow: hidden;
      }

      aside .side-inner .profile {
         text-align: center;
         margin-bottom: 20px;
         padding: 20px 0;
         border-bottom: 1px solid var(--dark-border);
         flex-shrink: 0;
      }

      aside .side-inner .profile img {
         width: 120px;
      }

      aside .side-inner .nav-menu {
         flex-grow: 1;
         overflow-y: auto;
         padding-bottom: 20px;
      }

      aside .side-inner .nav-menu ul,
      aside .side-inner .nav-menu ul li {
         padding: 0;
         margin: 0;
         list-style: none;
      }

      aside .side-inner .nav-menu ul li a {
         display: block;
         padding: 10px 20px;
         color: var(--dark-text-secondary);
         position: relative;
         transition: 0.3s all ease;
         text-decoration: none;
      }

      aside .side-inner .nav-menu ul li a:hover {
         background: var(--dark-bg-secondary);
         color: var(--dark-text-primary);
      }

      aside .side-inner .nav-menu ul li a:before {
         content: "";
         position: absolute;
         left: 0;
         top: 0;
         bottom: 0;
         width: 0px;
         background-color: var(--dark-accent);
         opacity: 0;
         visibility: hidden;
         transition: .3s all ease;
      }

      aside .side-inner .nav-menu ul li a:hover:before {
         width: 4px;
         opacity: 1;
         visibility: visible;
      }

      aside .side-inner .nav-menu ul li.active a {
         background: var(--dark-bg-secondary);
         color: var(--dark-text-primary);
      }

      aside .side-inner .nav-menu ul li.active a:before {
         opacity: 1;
         visibility: visible;
         width: 4px;
      }

      aside .side-inner .nav-menu ul li .collapsible:after {
         content: "\f282";
         font-family: 'bootstrap-icons';
         font-size: 14px;
         position: absolute;
         right: 20px;
         transition: .3s transform ease;
      }

      aside .side-inner .nav-menu ul li .collapsible[aria-expanded="true"] {
         background: var(--dark-bg-secondary);
         color: var(--dark-text-primary);
      }

      aside .side-inner .nav-menu ul li .collapsible[aria-expanded="true"]:after {
         transform: rotate(90deg);
      }

      .nav-menu .accordion ul {
         padding-left: 20px !important;
         background-color: var(--dark-bg-tertiary);
      }

      .nav-menu .accordion .collapse {
         display: none;
      }

      .nav-menu .accordion .collapse.show {
         display: block;
      }

      .sidebar-footer {
         padding: 20px;
         border-top: 1px solid var(--dark-border);
         flex-shrink: 0;
         margin-top: 0;
      }
   </style>
</head>

<body class="d-flex flex-column h-100">

   <?php require __DIR__ . '/navbar.php'; // Carrega a barra do topo ?>
   <?php require __DIR__ . '/sidemenu.php'; // Carrega o menu lateral ?>

   <main class="container">