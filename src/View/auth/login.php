<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login - Portal Acadêmico FIAP</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
   <style>
      html,
      body {
         height: 100%;
      }

      body {
         display: flex;
         align-items: center;
         justify-content: center;
         background-color: #f8f9fa;
      }

      .login-card {
         width: 100%;
         max-width: 400px;
      }
   </style>
</head>

<body>

   <main class="login-card">
      <div class="card shadow-sm">
         <div class="card-body p-5">
            <h1 class="h3 mb-3 fw-normal text-center">Login | FIAP</h1>

            <?php if (isset($_GET['error'])): ?>
               <div class="alert alert-danger" role="alert">
                  E-mail ou senha inválidos. Tente novamente.
                  <?php if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 5): ?>
                     <br><strong>Muitas tentativas. Tente novamente em 1 minuto.</strong>
                  <?php endif; ?>
               </div>
            <?php endif; ?>

            <form action="/login/auth" method="POST">

               <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">

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

</body>

</html>