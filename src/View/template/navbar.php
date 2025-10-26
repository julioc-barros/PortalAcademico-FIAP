<!-- navbar.php -->

<style>
   .navbar {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
      padding: 8px 20px 8px 50px;
      background-color: #1a1a1a;
      align-items: center;
   }

   .navbar .container,
   .navbar .container-fluid {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      justify-content: space-between;
   }

   .logo img {
      width: 100px;
   }

   .container-data-perfil {
      display: flex;
      align-items: center;
      gap: 15px;
   }

   /* Estilos Comuns para Ícones de Carrinho e Notificações */
   .icon-container {
      position: relative;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      cursor: pointer;
      transition: background-color 0.3s ease;
   }

   /* Estilos do Modal do Carrinho */
   .cart-modal {
      display: none;
      position: fixed;
      z-index: 1001;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
      overflow-y: auto;
   }

   .cart-modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 20px;
      border-radius: 8px;
      width: 90%;
      max-width: 1400px;
      position: relative;
      max-height: 80vh;
   }

   .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
      transition: color 0.3s ease;
   }

   .close:hover,
   .close:focus {
      color: #000;
   }

   .cart-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 0.3fr));
      gap: 20px;
      max-height: 60vh;
      overflow-y: auto;
      padding-bottom: 10px;
   }

   .cart-item {
      background: #f9f9f9;
      padding: 15px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      border: 1px solid #e1e1e1;
   }

   .cart-title {
      margin: 0 0 10px;
      font-size: 16px;
      background-color: #8D080A;
      color: white;
      padding: 8px;
      border-radius: 4px;
      text-align: center;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }

   .expiration {
      margin: 5px 0;
      font-size: 14px;
      color: #555;
   }

   .progress-bar {
      width: 100%;
      background-color: #f0f0f0;
      height: 8px;
      border-radius: 5px;
      overflow: hidden;
      margin: 20px 0;
   }

   .progress {
      height: 100%;
      background-color: #8D080A;
      transition: width 0.3s ease;
   }

   .progress-text {
      font-size: 12px;
      text-align: center;
      margin: 5px 0;
      color: #666;
   }

   .products-list {
      margin: 5px 0 10px;
   }

   .products-container {
      max-height: 140px;
      min-height: 140px;
      overflow: hidden;
   }

   .product-item {
      display: grid;
      grid-template-columns: 60px 1fr 50px 70px;
      gap: 5px;
      align-items: center;
      padding: 4px 0;
      font-size: 13px;
      border-bottom: 1px solid #eee;
   }

   .product-code {
      font-weight: bold;
      color: #8D080A;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }

   .product-name {
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
   }

   .product-quantity {
      text-align: center;
   }

   .product-total {
      text-align: right;
      font-weight: bold;
   }

   .extra-items {
      margin-top: 5px;
      padding: 5px;
      background-color: #ffe6e6;
      color: #8D080A;
      font-size: 13px;
      text-align: center;
      border-radius: 4px;
      font-weight: bold;
   }

   .total {
      margin: 5px 0;
      font-size: 14px;
      color: #2c6e49;
      font-weight: bold;
      text-align: right;
   }

   .total-taxes {
      margin: 5px 0;
      font-size: 14px;
      color: #d90429;
      font-weight: bold;
      text-align: right;
   }

   .cart-actions {
      display: flex;
      justify-content: space-between;
      align-items: center;
      gap: 10px;
      margin-top: 10px;
   }

   .action-group {
      display: flex;
      gap: 10px;
   }

   .view-button,
   .finish-button,
   .delete-button {
      padding: 6px 15px;
      border-radius: 4px;
      cursor: pointer;
      transition: all 0.3s ease;
      font-size: 14px;
      min-width: 80px;
      text-align: center;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 5px;
   }

   .view-button {
      background-color: #fff;
      color: #8D080A;
      border: 2px solid #8D080A;
   }

   .view-button:hover {
      background-color: #8D080A;
      color: white;
   }

   .finish-button {
      background-color: #8D080A;
      color: white;
      border: none;
   }

   .finish-button:hover:not(:disabled) {
      background-color: #720607;
   }

   .finish-button:disabled {
      background-color: #cccccc;
      cursor: not-allowed;
      color: #666666;
   }

   .delete-button {
      background-color: #fff;
      color: #d90429;
      border: 2px solid #d90429;
   }

   .delete-button:hover {
      background-color: #d90429;
      color: white;
   }


   .cart-item.zero-total .cart-title {
      background-color: #666666;
      color: #ffffff;
   }

   .cart-item.zero-total .progress {
      background-color: #999999;

   }

   .cart-item.zero-total .total {
      color: #666666;

   }

   .cart-item.zero-total .view-button {
      border: 2px solid #b0a0a1;
   }

   .cart-item.zero-total .finish-button:hover:not(:disabled) {
      background-color: #777777;

   }

   .cart-item .cart-title {
      background-color: #8D080A;

      color: white;
   }

   .cart-item .progress {
      background-color: #8D080A;

   }

   .cart-item .total {
      color: #2c6e49;

   }

   .cart-item .finish-button {
      background-color: #8D080A;

   }

   .cart-item .finish-button:hover:not(:disabled) {
      background-color: #720607;

   }

   /* Media Queries */
   @media (max-width: 768px) {
      .navbar {
         height: 8vh;
         padding: 8px 20px;
      }

      .cart-counter {
         position: fixed;
         bottom: 70px;
         right: 15px;
         background-color: #8D080A;
         border-radius: 50%;
         width: 60px;
         height: 60px;
         box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
         z-index: 1000;

         display: flex;
         justify-content: center;
         align-items: center;
      }

      .cart-modal-content {
         margin: 25% auto;
         width: 95%;
         padding: 15px;
      }

      .notification-dropdown {
         top: 50px;
         /* Melhor posicionamento no mobile */
         right: 10px;
         width: 90%;
         max-width: 320px;
      }

      .cart-grid {
         grid-template-columns: 1fr;
         gap: 15px;
         margin-top: 15px;
      }

      .cart-item {
         padding: 10px;
         overflow-x: hidden;
         border: 1px solid #ddd;
         background: #fff;
         border: 1px solid #e1e1e1;
      }

      .cart-title {
         font-size: 14px;
         padding: 6px;
         max-width: 100%;
      }

      .expiration {
         display: none;
      }

      .products-container {
         max-height: 50px;
         min-height: 0;
      }

      .product-item {
         grid-template-columns: 50px 1fr 40px 60px;
         gap: 3px;
         font-size: 11px;
         padding: 3px 0;
      }

      .extra-items {
         font-size: 11px;
         margin-top: 3px;
         padding: 3px;
      }

      .total,
      .total-taxes {
         font-size: 12px;
         margin: 3px 0;
      }

      .cart-actions {
         gap: 5px;
      }

      .action-group {
         gap: 5px;
      }

      .view-button,
      .finish-button,
      .delete-button {
         padding: 5px 10px;
         min-width: 60px;
         font-size: 11px;
      }
   }

   @media (min-width: 769px) {
      .cart-counter {
         display: inline-flex;
         align-items: center;
         justify-content: center;
      }
   }
</style>

<nav class="navbar">

   <?php require __DIR__ . '/../template/toggle-menu.php'; ?>

   <div class="logo">

      <a href="<?php route('dashboard') ?>">
         <img src="\assets\img\Artboard-1.webp" alt="logo FIAP">
      </a>

   </div>
</nav>