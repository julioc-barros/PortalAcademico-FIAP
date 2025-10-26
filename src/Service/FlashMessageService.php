<?php
namespace PortalAcademicoFIAP\Service;

class FlashMessageService
{
   private static string $sessionKey = 'flash_messages';

   /**
    * Define uma mensagem flash.
    */
   public static function set(string $key, mixed $value): void
   {
      if (session_status() === PHP_SESSION_NONE) {
         session_start();
      }
      $_SESSION[self::$sessionKey][$key] = $value;
   }

   /**
    * Obtém uma mensagem flash e a remove da sessão.
    */
   public static function get(string $key): mixed
   {
      if (session_status() === PHP_SESSION_NONE) {
         session_start();
      }

      if (isset($_SESSION[self::$sessionKey][$key])) {
         $value = $_SESSION[self::$sessionKey][$key];
         unset($_SESSION[self::$sessionKey][$key]); // Remove após ler

         // Limpa a chave principal se estiver vazia
         if (empty($_SESSION[self::$sessionKey])) {
            unset($_SESSION[self::$sessionKey]);
         }
         return $value;
      }
      return null;
   }

   /**
    * Verifica se existe uma mensagem flash para uma chave.
    */
   public static function has(string $key): bool
   {
      if (session_status() === PHP_SESSION_NONE) {
         session_start();
      }
      return isset($_SESSION[self::$sessionKey][$key]);
   }
}