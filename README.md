# Portal Acadêmico FIAP - Desafio PHP

[![FIAP Logo](https://www.fiap.com.br/wp-content/themes/fiap/assets/images/logo-fiap.svg)](https://www.fiap.com.br)

## 🌐 Live Demo

Uma versão funcional desta aplicação está disponível em:
**[portalfiap.juliocbarros.tech](http://portalfiap.juliocbarros.tech)**

## 🔗 Repositório

O código fonte está disponível no GitHub:
**[https://github.com/julioc-barros/PortalAcademico-FIAP.git](https://github.com/julioc-barros/PortalAcademico-FIAP.git)**

## 📝 Descrição

Este projeto é uma aplicação web desenvolvida como parte do Desafio PHP da FIAP. O objetivo é criar um sistema administrativo para gerenciar Alunos, Turmas e Matrículas, utilizando PHP puro, MySQL e seguindo um conjunto de regras de negócio específicas.

A aplicação conta com funcionalidades de CRUD para Alunos e Turmas, gestão de Matrículas, autenticação, controle de acesso (Super Admin), dashboard com estatísticas, tema escuro, e diversas melhorias de segurança e usabilidade.

## ✨ Funcionalidades Principais

* Autenticação Segura (BCrypt, Rate Limiting)
* Controle de Acesso (Super Admin)
* CRUD Completo de Alunos e Turmas (com Soft Delete)
* Gestão de Matrículas (Matricular/Desmatricular)
* CRUD de Administradores (restrito a Super Admin)
* Dashboard com Estatísticas Reais
* Segurança (CSRF, Auditoria)
* Interface Moderna (Dark Theme, Navbar/Sidemenu, Ícones, Notificações Swal)
* Páginas de Erro Customizadas (404, 500)

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP >= 7.4 (Puro)
* **Banco de Dados:** MySQL
* **Servidor Web:** Apache ou Nginx (recomendado)
* **Gerenciador de Dependências:** Composer
* **Frontend:** HTML5, CSS3, JavaScript (jQuery), Bootstrap 5, DataTables, SweetAlert2, Bootstrap Icons

## 🚀 Pré-requisitos de Servidor (Produção)

* Servidor Web (Apache ou Nginx) com suporte a PHP >= 7.4
* PHP com extensões: `pdo_mysql`, `mbstring`, `openssl` (geralmente padrão)
* MySQL Server (versão 5.7 ou superior recomendada)
* Composer instalado no servidor
* Acesso SSH ou similar ao servidor para executar comandos

## ⚙️ Deploy em Produção

Siga estes passos para implantar a aplicação em um servidor de produção:

**1. Clone o Repositório:**

* Conecte-se ao seu servidor via SSH.
* Navegue até o diretório onde suas aplicações web são hospedadas (ex: `/var/www/html` ou `/home/user/public_html`).
* Clone o projeto usando o link do repositório:
    ```bash
    git clone [https://github.com/julioc-barros/PortalAcademico-FIAP.git](https://github.com/julioc-barros/PortalAcademico-FIAP.git) nome_da_pasta_app
    cd nome_da_pasta_app
    ```
    *(Substitua `nome_da_pasta_app` pelo nome desejado para a pasta da aplicação, ex: `portal-fiap`)*.

**2. Instale as Dependências (Composer):**

* Na raiz do projeto (`nome_da_pasta_app`), execute o Composer para instalar as dependências otimizadas para produção:
    ```bash
    composer install --no-dev --optimize-autoloader
    ```
    * `--no-dev`: Ignora pacotes de desenvolvimento (não usamos, mas é boa prática).
    * `--optimize-autoloader`: Cria um *autoloader* mais rápido para produção.

**3. Configure o Ambiente (`config.php`):**

* Abra o arquivo `config/config.php`.
* **Banco de Dados:** Configure as credenciais **de produção** na seção `database`:
    ```php
    'database' => [
        'host' => 'localhost', // Ou o host do seu DB de produção
        'port' => 3306,
        'name' => 'nome_banco_producao', // Nome do banco de produção
        'user' => 'usuario_banco_producao',
        'pass' => 'senha_banco_producao',
        'charset' => 'utf8mb4'
    ],
    ```
* **Modo de Ambiente:** **MUITO IMPORTANTE:** Mude `APP_ENV` para `'production'` para desativar a exibição de erros detalhados:
    ```php
    define('APP_ENV', 'production');
    ```
* **URL da Aplicação:** Certifique-se de que a `app_url` para o ambiente de produção está correta (com `https://` se aplicável):
    ```php
     'app_url' => (APP_ENV === 'development') 
                    ? 'http://localhost:8000' 
                    : '[https://portalfiap.juliocbarros.tech](https://portalfiap.juliocbarros.tech)' // Sua URL de produção
    ```

**4. Crie e Configure o Banco de Dados:**

* No seu servidor MySQL de produção, crie o banco de dados (`nome_banco_producao`) com *collation* `utf8mb4_unicode_ci`.
* Crie o usuário (`usuario_banco_producao`) e conceda as permissões necessárias para este banco de dados.
* Importe **apenas a estrutura** do banco de dados (sem os dados *mock*) ou o `dump.sql` completo se desejar os dados iniciais. Recomenda-se usar um dump apenas com a estrutura em produção e criar o primeiro admin manualmente ou via *seeder*.
    * Se for usar o dump completo: `mysql -u usuario_banco_producao -p nome_banco_producao < dump.sql`

**5. Configure o Servidor Web (Apache/Nginx):**

* **O ponto mais crítico:** Configure o seu servidor web (Apache VirtualHost ou Nginx Server Block) para que o **DocumentRoot** (a raiz do site) aponte **DIRETAMENTE para a pasta `public`** dentro do seu projeto.
    * Exemplo (Caminho do DocumentRoot): `/var/www/html/nome_da_pasta_app/public`
* **Apache (`.htaccess`):** Certifique-se de que o Apache está configurado para permitir `AllowOverride All` no diretório da sua aplicação, para que o arquivo `.htaccess` dentro da pasta `public` possa funcionar (ele é necessário para reescrever as URLs para o `index.php`). O arquivo `.htaccess` na raiz do projeto **não é necessário** se o DocumentRoot estiver correto.
    * Conteúdo necessário em `/var/www/html/nome_da_pasta_app/public/.htaccess`:
        ```apache
        <IfModule mod_rewrite.c>
            RewriteEngine On
            RewriteBase / 
            RewriteCond %{REQUEST_FILENAME} !-f
            RewriteCond %{REQUEST_FILENAME} !-d
            RewriteRule . index.php [L]
        </IfModule>
        ```
* **Nginx:** Configure um `location /` para tentar servir arquivos estáticos e, caso não encontre, enviar a requisição para `index.php?$query_string`. Exemplo básico:
    ```nginx
    server {
        listen 80;
        server_name portalfiap.juliocbarros.tech;
        root /var/www/html/nome_da_pasta_app/public; # Aponta para a pasta public

        index index.php index.html;

        location / {
            try_files $uri $uri/ /index.php?$query_string;
        }

        location ~ \.php$ {
            include snippets/fastcgi-php.conf;
            fastcgi_pass unix:/var/run/php/php8.1-fpm.sock; # Ajuste a versão/caminho do PHP-FPM
        }

        # Impede acesso a arquivos ocultos
        location ~ /\.ht {
            deny all;
        }
    }
    ```
* **Reinicie o Servidor Web:** Após a configuração, reinicie o Apache (`sudo systemctl restart apache2`) ou Nginx (`sudo systemctl restart nginx`).

**6. Defina as Permissões:**

* Certifique-se de que o servidor web (usuário `www-data`, `apache`, `nginx`, etc.) tenha permissão de escrita em diretórios que possam precisar (ex: `logs`, `cache`, se você adicionar no futuro). Para este projeto, geralmente permissões de leitura são suficientes para o código PHP. Ajuste as permissões das pastas e arquivos conforme necessário (ex: `chown -R www-data:www-data nome_da_pasta_app` e `chmod -R 755 nome_da_pasta_app`).

## ▶️ Acessando a Aplicação em Produção

* Após seguir todos os passos, acesse a URL configurada no seu servidor web (ex: `https://portalfiap.juliocbarros.tech`).
* Você deverá ver a tela de login.

## 🔑 Acesso Padrão (Se usou o dump.sql)

* **Usuário:** `admin@fiap.com.br`
* **Senha:** `Admin@123`

---