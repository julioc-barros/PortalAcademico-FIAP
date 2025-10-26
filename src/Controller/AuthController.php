<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Service\Auth;

class AuthController
{
   /**
    * Exibe o formulário de login
    */
   public function index()
   {
      // Se o usuário já está logado, redireciona para a tela inicial
      if (Auth::check()) {
         redirect(route("dashboard", []));
         exit;
      }

      // Passa o token CSRF para a view
      $csrfToken = Auth::generateCsrfToken();
      view("auth.login", ["csrfToken" => $csrfToken]);
   }

   /**
    * Processa a tentativa de login
    */
   public function auth()
   {
      $email = $_POST['email'] ?? null;
      $password = $_POST['password'] ?? null;
      $token = $_POST['csrf_token'] ?? null;

      // Valida o Token CSRF
      Auth::validateCsrfToken($token);

      // Tenta realizar o login
      if (Auth::login($email, $password)) {
         redirect(route("dashboard", []));
         exit;
      } else {
         redirect(route("login", ["error" => 1]));
         exit;
      }
   }

   /**
    * Realiza o logout do usuário
    */
   public function logout()
   {
      Auth::logout();
      redirect(route("login", []));
      exit;
   }
}