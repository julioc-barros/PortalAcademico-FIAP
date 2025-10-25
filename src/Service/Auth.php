<?php
namespace PortalAcademicoFIAP\Service;

use PortalAcademicoFIAP\Repository\AdminRepository;
use PortalAcademicoFIAP\Service\AuditLogger; // Usaremos para realizar o log do login

class Auth
{
   /**
    * Tenta logar um administrador.
    */
   public static function login(string $email, string $password): bool
   {
      // 1. Verificar se o login está bloqueado (Rate Limit)
      if (self::isLoginBlocked()) {
         return false;
      }

      $repository = new AdminRepository();
      $admin = $repository->findByEmail($email);

      // 2. Verificar se o admin existe e se a senha está correta
      if ($admin && password_verify($password, $admin->senha)) {
         // Sucesso! A senha bate com o hash

         // 3. Regenerar o ID da sessão para evitar Session Fixation
         session_regenerate_id(true);

         // 4. Armazenar os dados na sessão
         $_SESSION['is_logged_in'] = true;
         $_SESSION['user_id'] = $admin->id;
         $_SESSION['user_name'] = $admin->nome;
         $_SESSION['is_super_admin'] = $admin->is_super_admin;

         // 5. Logar a ação (Melhoria de Auditoria)
         AuditLogger::log($admin->id, "Realizou login com sucesso.");

         return true;
      }

      // Falha no login
      self::addFailedLoginAttempt();
      return false;
   }

   /**
    * Desloga o usuário.
    */
   public static function logout(): void
   {
      session_unset();
      session_destroy();
   }

   /**
    * Verifica se o usuário está logado.
    */
   public static function check(): bool
   {
      return isset($_SESSION['is_logged_in']) && $_SESSION['is_logged_in'] === true;
   }

   /**
    * Retorna o ID do usuário logado.
    */
   public static function id(): ?int
   {
      return $_SESSION['user_id'] ?? null;
   }

   /**
    * Retorna o Nome do usuário logado.
    */
   public static function userName(): ?string
   {
      return $_SESSION['user_name'] ?? null;
   }

   /**
    * Verifica se o usuário logado é Super Admin.
    */
   public static function isSuperAdmin(): bool
   {
      return isset($_SESSION['is_super_admin']) && $_SESSION['is_super_admin'] === true;
   }

   public static function addFailedLoginAttempt(): void
   {
      if (!isset($_SESSION['login_attempts'])) {
         $_SESSION['login_attempts'] = 0;
      }
      $_SESSION['login_attempts']++;
      $_SESSION['last_login_attempt'] = time();
   }

   public static function isLoginBlocked(): bool
   {
      if (!isset($_SESSION['login_attempts']) || !isset($_SESSION['last_login_attempt'])) {
         return false;
      }

      $attempts = $_SESSION['login_attempts'];
      $lastAttemptTime = $_SESSION['last_login_attempt'];

      // Bloqueia por 60 segundos após 5 tentativas falhas
      if ($attempts >= 5 && (time() - $lastAttemptTime) < 60) {
         return true;
      }

      // Reseta a contagem após 60 segundos
      if ((time() - $lastAttemptTime) >= 60) {
         unset($_SESSION['login_attempts']);
         unset($_SESSION['last_login_attempt']);
      }

      return false;
   }

   public static function generateCsrfToken(): string
   {
      if (empty($_SESSION['csrf_token'])) {
         $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
      }
      return $_SESSION['csrf_token'];
   }

   public static function validateCsrfToken(string $token): bool
   {
      if (empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $token)) {
         // Token inválido ou não existe. Para a execução.
         http_response_code(403); // Forbidden
         die('Erro 403: Token CSRF inválido.');
      }
      // Token é válido, remove ele para que não seja reutilizado
      unset($_SESSION['csrf_token']);
      return true;
   }

}