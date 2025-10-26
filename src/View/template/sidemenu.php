<!-- sidemenu.php -->

<style>
   aside,
   main {
      /* height: 100vh; */
      /* min-height: 580px; */
   }

   aside {
      width: 250px;
      left: 0;
      z-index: 1001;
      position: fixed;
      -webkit-transform: translateX(-100%);
      -ms-transform: translateX(-100%);
      transform: translateX(-100%);
      background-color: #fff;
      -webkit-transition: 1s -webkit-transform cubic-bezier(0.23, 1, 0.32, 1);
      transition: 1s -webkit-transform cubic-bezier(0.23, 1, 0.32, 1);
      -o-transition: 1s transform cubic-bezier(0.23, 1, 0.32, 1);
      transition: 1s transform cubic-bezier(0.23, 1, 0.32, 1);
      transition: 1s transform cubic-bezier(0.23, 1, 0.32, 1), 1s -webkit-transform cubic-bezier(0.23, 1, 0.32, 1);
   }

   .show-sidebar aside {
      -webkit-transform: translateX(0%);
      -ms-transform: translateX(0%);
      transform: translateX(0%);
   }

   aside .toggle {
      padding-left: 30px;
      padding-top: 30px;
      position: absolute;
      right: 0;
      -webkit-transform: translateX(100%);
      -ms-transform: translateX(100%);
      transform: translateX(100%);
   }

   .show-sidebar aside .toggle .burger:before,
   .show-sidebar aside .toggle .burger span,
   .show-sidebar aside .toggle .burger:after {
      background: #000;
   }

   .show-sidebar aside {
      -webkit-box-shadow: 10px 0 30px 0 rgba(0, 0, 0, 0.1);
      box-shadow: 10px 0 30px 0 rgba(0, 0, 0, 0.1);
   }

   aside .side-inner {
      /* padding: 30px 0; */
      height: 100vh;
      -webkit-overflow-scrolling: touch;
      background-color: #8D080A;
      overflow: auto;
   }

   aside .side-inner .profile {
      margin-left: auto;
      margin-right: auto;
      text-align: center;
      margin-bottom: 30px;
      /* padding-bottom: 30px; */
      border-bottom: 1px solid #efefef;
   }

   aside .side-inner .profile img {
      /* Ajustar */
      /* margin-top: 20px; */
      /* background-color: white; */
      padding: 10px 0;
      width: 50px;
   }

   aside .side-inner .profile .name {
      font-size: 18px;
      margin-bottom: 0;
   }

   aside .side-inner .profile .country {
      font-size: 14px;
      color: #cfcfcf;
   }

   aside .side-inner .counter {
      margin-bottom: 30px;
      padding-bottom: 30px;
      border-bottom: 1px solid #efefef;
      text-align: center;
   }

   aside .side-inner .counter div .number {
      display: block;
      font-size: 20px;
      color: #000;
   }

   aside .side-inner .counter div .number-label {
      color: #cfcfcf;
   }

   aside .side-inner .nav-menu ul,
   aside .side-inner .nav-menu ul li {
      padding: 0;
      margin: 0px;
      list-style: none;
   }

   aside .side-inner .nav-menu ul li a {
      display: block;
      margin-left: 5px;
      padding-left: 15px;
      padding-right: 10px;
      padding-top: 7px;
      padding-bottom: 7px;
      color: white;
      position: relative;
      -webkit-transition: .3s padding-left ease;
      -o-transition: .3s padding-left ease;
      transition: .3s padding-left ease;
   }

   aside .side-inner .nav-menu ul li a:before {
      content: "";
      position: absolute;
      left: 0;
      top: 0;
      bottom: 0;
      width: 0px;
      background-color: #ff7315;
      opacity: 0;
      visibility: hidden;
      -webkit-transition: .3s opacity ease, .3s visibility ease, .3s width ease;
      -o-transition: .3s opacity ease, .3s visibility ease, .3s width ease;
      transition: .3s opacity ease, .3s visibility ease, .3s width ease;
   }

   aside .side-inner .nav-menu ul li a:active,
   aside .side-inner .nav-menu ul li a:focus,
   aside .side-inner .nav-menu ul li a:hover {
      outline: none;
   }

   aside .side-inner .nav-menu ul li a:hover {
      background: #fcfcfc;
      color: #000;
   }

   aside .side-inner .nav-menu ul li a:hover:before {
      width: 2px;
      opacity: 1;
      visibility: visible;
   }

   aside .side-inner .nav-menu ul li.active a {
      background: #fcfcfc;
      color: #000;
   }

   aside .side-inner .nav-menu ul li.active a:before {
      opacity: 1;
      visibility: visible;
      width: 4px;
   }

   aside .side-inner .nav-menu ul li .collapsible {
      position: relative;
   }

   aside .side-inner .nav-menu ul li .collapsible:after {
      content: "\e315";
      font-size: 18px;
      font-family: 'icomoon';
      position: absolute;
      right: 20px;
      width: 20px;
      height: 20px;
      line-height: 20px;
      bottom: 15px;
      -webkit-transition: .3s transform ease;
      -o-transition: .3s transform ease;
      transition: .3s transform ease;
   }

   aside .side-inner .nav-menu ul li .collapsible[aria-expanded="true"] {
      background: #fcfcfc;
      color: #000;
   }

   aside .side-inner .nav-menu ul li .collapsible[aria-expanded="true"]:before {
      opacity: 1;
      visibility: visible;
      width: 4px;
   }

   aside .side-inner .nav-menu ul li .collapsible[aria-expanded="true"]:after {
      -webkit-transform: rotate(90deg);
      -ms-transform: rotate(90deg);
      transform: rotate(90deg);
   }

   .nav-menu .accordion ul {
      padding-left: 20px !important;
   }

   @media (max-width:480px) {
      aside .side-inner .profile img {
         padding: 10px 0px !important;
         margin-top: 0;
         width: 60px;
      }

      aside .side-inner .profile {
         padding-bottom: 0;
      }

      aside .side-inner {
         padding-top: 0;
      }

      .profile a {
         display: flex;
         justify-content: center
      }


   }
</style>

<aside class="sidebar">

   <div class="side-inner">

      <div class="profile">
         <a href="/">
            <svg class="components-menu-svg" viewBox="0 0 574.206 155.976" style="fill: #ed145b;">
               <use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#logo-fiap"></use>
            </svg>
         </a>
      </div>

      <div class="nav-menu">
         <ul>

            <li class="accordion">
               <a href="#" data-toggle="collapse" data-target="#area-admin" aria-expanded="false"
                  aria-controls="area-admin" class="collapsible">
                  <span class="bi bi-person-lock mr-3"></span>Administração
               </a>

               <div id="area-admin" class="collapse" aria-labelledby="headingOne">
                  <div>
                     <ul>
                        @can('gerenciar_usuarios')
                        <li><a href="{{ route('consulta.usuario') }}"><span class="bi bi-people  mr-2"></span>
                              Usuarios
                           </a>
                        </li>
                        <li><a href="{{ route('consulta.grupos') }}"><span class="bi bi-lock-fill  mr-2"></span>
                              Permissoes
                           </a>
                        </li>
                        @endcan
                     </ul>
                  </div>
               </div>
            </li>

            <li class="accordion">
               <a href="#" data-toggle="collapse" data-target="#area-cadastro" aria-expanded="false"
                  aria-controls="area-cadastro" class="collapsible">
                  <span class="bi bi-clipboard-plus mr-3"></span>Cadastros
               </a>

               <div id="area-cadastro" class="collapse" aria-labelledby="headingOne">
                  <div>
                     <ul>
                        <li><a href="{{ route('consulta.clientes') }}"><span
                                 class="bi bi-people mr-2"></span>Cliente</a></li>
                        <li class="accordion">

                        <li><a href="{{ route('consulta.transportadoras') }}"><span
                                 class="bi bi-truck mr-2"></span>Transportadora</a></li>
                        <li class="accordion">

                        <li><a href="{{ route('consulta.produtos') }}"><span
                                 class="bi bi-box-seam mr-2"></span>Produtos</a>
                        </li>
                        <li><a href="{{ route('consulta.veiculos') }}"><span
                                 class="bi bi-car-front mr-2"></span>Veículos</a>
                        </li>
                        <li class="accordion">
                     </ul>
                  </div>
               </div>
            </li>

            <li class="accordion">
               <a href="#" data-toggle="collapse" data-target="#area-faturamento" aria-expanded="false"
                  aria-controls="area-faturamento" class="collapsible">
                  <span class="bi bi-cash-coin mr-3"></span>Faturamento
               </a>

               <div id="area-faturamento" class="collapse" aria-labelledby="headingTwo">
                  <div>
                     <ul>
                        <li>
                           <a href="{{ route('consulta.vendas') }}"><span class="bi bi-cart-plus  mr-2"></span>Venda</a>
                        </li>
                     </ul>
                  </div>
               </div>

            </li>

            <li class="accordion">
               <a href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false"
                  aria-controls="collapseTwo" class="collapsible">
                  <span class="bi bi-file-text mr-3"></span>Relatório
               </a>

               <div id="collapseTwo" class="collapse" aria-labelledby="headingOne">
                  <div>

                  </div>
               </div>

            </li>

            <li class="accordion">
               <a href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false"
                  aria-controls="collapseThree" class="collapsible">
                  <span class="bi bi-card-checklist mr-3"></span>Garantia
               </a>

               <div id="collapseThree" class="collapse" aria-labelledby="headingOne">
                  <div>
                     <ul>

                        @can('incluir_laudo_garantia')
                        <li>
                           <a href="{{ route('consulta.analise.tecnico.garantia') }}">
                              <span class="bi bi-file-earmark-plus  mr-2"></span>
                              Analise de garantia
                           </a>
                        </li>
                        @endcan


                        @can('consulta_garantia')
                        <li>
                           <a href="{{ route('consulta.garantia.usuario') }}">
                              <span class="bi bi-patch-check  mr-2"></span>
                              Consultar Garantia
                           </a>
                        </li>
                        @endcan
                     </ul>
                  </div>
               </div>

            </li>

         </ul>
      </div>
   </div>

</aside>