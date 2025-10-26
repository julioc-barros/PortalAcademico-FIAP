<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login - Portal Acadêmico FIAP</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <link rel="shortcut icon" type="imagex/png" href="<?= APP_URL ?>/assets/img/favicon.ico">
   <link rel='stylesheet'
      href='https://fonts.googleapis.com/css?family=Roboto%3A400%2C100%2C100italic%2C300%2C300italic%2C400italic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic&#038;ver=4.9.15'
      type='text/css' media='all' />

   <style>
      /* Variáveis do Dark Theme (copiadas do header para esta página) */
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
         --dark-danger: #dc3545;
      }

      html,
      body {
         height: 100%;
      }

      body {
         display: flex;
         align-items: center;
         justify-content: center;
         background-color: var(--dark-bg-secondary);
         color: var(--dark-text-secondary);
         font-family: 'Roboto', sans-serif;
      }

      .login-card {
         width: 100%;
         max-width: 400px;
      }

      .card {
         background-color: var(--dark-bg-primary);
         border: 1px solid var(--dark-border);
         color: var(--dark-text-primary);
      }

      .form-control {
         background-color: var(--dark-bg-tertiary);
         border: 1px solid var(--dark-border);
         color: var(--dark-text-primary);
      }

      .form-control:focus {
         background-color: var(--dark-bg-tertiary);
         border-color: var(--dark-accent);
         box-shadow: 0 0 0 0.25rem rgba(141, 8, 10, 0.5);
         color: var(--dark-text-primary);
      }

      .form-control::placeholder {
         color: var(--dark-text-muted);
      }

      .form-floating>label {
         color: var(--dark-text-muted);
      }

      .form-floating>.form-control:focus~label,
      .form-floating>.form-control:not(:placeholder-shown)~label {
         color: var(--dark-text-secondary);
      }

      .btn-primary {
         background-color: var(--dark-accent);
         border-color: var(--dark-accent);
      }

      .btn-primary:hover {
         background-color: var(--dark-accent-hover);
         border-color: var(--dark-accent-hover);
      }

      .alert-danger {
         background-color: rgba(220, 53, 69, 0.2);
         color: #f8d7da;
         border-color: rgba(220, 53, 69, 0.5);
      }

      .login-logo {
         max-width: 150px;
         margin-bottom: 1.5rem;
      }
   </style>
</head>

<body>

   <main class="login-card">
      <div class="card shadow-sm">
         <div class="card-body p-5 text-center"> <img src="<?= APP_URL ?>/assets/img/fiap_logo.webp" alt="Logo FIAP"
               class="login-logo img-fluid">

            <h1 class="h3 mb-3 fw-normal">Portal Acadêmico</h1>

            <?php if (isset($_GET['error'])): ?>
               <div class="alert alert-danger text-start" role="alert"> E-mail ou senha inválidos.
                  <?php if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 5): ?>
                     <br><strong>Muitas tentativas. Tente novamente em 1 minuto.</strong>
                  <?php endif; ?>
               </div>
            <?php endif; ?>

            <form action="<?= route('login.auth') ?>" method="POST" class="text-start"> <input type="hidden"
                  name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">

               <div class="form-floating mb-3">
                  <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com"
                     required>
                  <label for="email">E-mail</label>
               </div>
               <div class="form-floating mb-3">
                  <input type="password" class="form-control" id="password" name="password" placeholder="Senha"
                     required>
                  <label for="password">Senha</label>
               </div>

               <button class="w-100 btn btn-lg btn-primary" type="submit">Entrar</button>
            </form>
         </div>
      </div>
   </main>

   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>