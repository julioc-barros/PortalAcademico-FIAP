<?php
namespace PortalAcademicoFIAP\Controller;

use PortalAcademicoFIAP\Service\Auth;

class AuthController
{
   /**
    * Exibe o formulário de login (GET /login)
    */
   public function index()
   {
      // Se o usuário já está logado, redireciona para a tela inicial
      if (Auth::check()) {
         header('Location: /');
         exit;
      }

      // Passa o token CSRF para a view
      $csrfToken = Auth::generateCsrfToken();

      // Carrega a view do formulário de login
      require __DIR__ . '/../View/auth/login.php';
   }

   /**
    * Processa a tentativa de login (POST /login/auth)
    */
   public function auth()
   {
      $email = $_POST['email'] ?? null;
      $password = $_POST['password'] ?? null;
      $token = $_POST['csrf_token'] ?? null;

      // 1. Valida o Token CSRF
      Auth::validateCsrfToken($token);

      // 2. Tenta realizar o login
      if (Auth::login($email, $password)) {
         // Sucesso: Redireciona para o Dashboard
         header('Location: /');
         exit;
      } else {
         // Falha: Redireciona de volta para o login com uma msg de erro
         // (Vamos implementar um sistema de 'flash messages' depois)
         header('Location: /login?error=1');
         exit;
      }
   }

   /**
    * Realiza o logout do usuário (GET /logout)
    */
   public function logout()
   {
      Auth::logout();
      header('Location: /login');
      exit;
   }
}