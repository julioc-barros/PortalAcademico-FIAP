# Portal Acadêmico FIAP - Desafio PHP

[![FIAP Logo](https://raw.githubusercontent.com/julioc-barros/PortalAcademico-FIAP/refs/heads/main/public/assets/img/fiap_logo.webp)](https://www.fiap.com.br)

## 🌐 Live Demo

Uma versão funcional desta aplicação está disponível em:
**[portalfiap.cbarros.dev.br](https://portalfiap.cbarros.dev.br)** *(Pode levar alguns instantes para carregar inicialmente)*

## 📝 Descrição

Este projeto é uma aplicação web desenvolvida como parte do Desafio PHP da FIAP. O objetivo é criar um sistema administrativo para gerenciar Alunos, Turmas e Matrículas, utilizando PHP puro, MySQL e seguindo um conjunto de regras de negócio específicas.

A aplicação conta com funcionalidades de CRUD (Create, Read, Update, Delete) para Alunos e Turmas, gestão de Matrículas integrada ao perfil do aluno, sistema de autenticação para administradores, controle de acesso baseado em permissões (Super Admin), dashboard com estatísticas, e um tema escuro customizado.

## ✨ Funcionalidades Principais

* **Autenticação:** Sistema de login seguro para administradores com hash de senha (BCrypt) e proteção contra força bruta (Rate Limiting).
* **Controle de Acesso:** Distinção entre Administrador Padrão e Super Administrador.
* **CRUD de Alunos:** Cadastro, listagem (busca/paginação), edição e exclusão (soft delete).
* **CRUD de Turmas:** Cadastro, listagem (contagem de alunos/paginação), edição e exclusão (soft delete, com validação).
* **Gestão de Matrículas:** Interface no perfil do aluno para matricular/desmatricular em turmas (RN04).
* **Visualização de Turmas:** Tela para visualizar alunos matriculados em uma turma (RN15).
* **CRUD de Administradores:** Área restrita para Super Admins gerenciarem outras contas.
* **Dashboard:** Painel com estatísticas reais (alunos, turmas, matrículas, etc.).
* **Segurança:** Proteção contra CSRF, Rate Limiting.
* **Auditoria:** Log de ações importantes.
* **Interface:** Tema escuro, layout responsivo (Navbar/Sidemenu), Ícones Bootstrap, Notificações/Confirmações (SweetAlert2).
* **Páginas de Erro:** Páginas customizadas para 404 e 500.

## 🛠️ Tecnologias Utilizadas

* **Backend:** PHP >= 7.4 (Puro)
* **Banco de Dados:** MySQL
* **Servidor Web (Desenvolvimento):** Servidor Embutido do PHP (`php -S`)
* **Gerenciador de Dependências:** Composer
* **Frontend:** HTML5, CSS3, JavaScript (jQuery), Bootstrap 5, DataTables, SweetAlert2, Bootstrap Icons

## 🚀 Pré-requisitos

Antes de começar, certifique-se de ter instalado em sua máquina:

1.  **PHP:** Versão 7.4 ou superior, com a extensão `pdo_mysql` habilitada. [php.net](https://www.php.net/downloads).
2.  **MySQL Server:** Um servidor de banco de dados MySQL rodando (pode ser via XAMPP, Docker, WAMP, MAMP, ou instalação direta).
3.  **Composer:** O gerenciador de dependências para PHP. [getcomposer.org](https://getcomposer.org/download/).
4.  **Git:** (Opcional, mas recomendado) Para clonar o repositório. [git-scm.com](https://git-scm.com/).
5.  **Navegador Web:** Chrome, Firefox, Edge, etc.
6.  **(Opcional) Ferramenta de Banco de Dados:** phpMyAdmin, DBeaver, MySQL Workbench, etc., para gerenciar o banco.

## ⚙️ Instalação e Configuração (Usando Servidor PHP)

Siga estes passos para configurar o projeto localmente:

**1. Obtenha o Código:**

* **Via Git (Recomendado):**
    Abra seu terminal ou Git Bash, navegue até o diretório onde deseja guardar seus projetos (ex: `C:\Projetos`) e clone o repositório:
    ```bash
    cd C:\Projetos
    git clone https://github.com/julioc-barros/PortalAcademico-FIAP.git PortalAcademico-FIAP
    cd PortalAcademico-FIAP
    ```
    *(Substitua `https://github.com/julioc-barros/PortalAcademico-FIAP.git` pela URL do seu projeto).*
* **Manualmente:**
    Baixe o arquivo ZIP do projeto e extraia o conteúdo para uma pasta (ex: `C:\Projetos\PortalAcademico-FIAP`).

**2. Instale as Dependências (Composer):**

* Abra seu terminal **na raiz do projeto** (ex: `C:\Projetos\PortalAcademico-FIAP`).
* Execute o comando:
    ```bash
    composer install
    ```
    *(Isso criará a pasta `vendor` com o autoload).*

**3. Configure o Ambiente (`config.php`):**

* Abra o arquivo `config/config.php`.
* **Banco de Dados:** Ajuste as credenciais na seção `database` para conectar ao seu servidor MySQL:
    ```php
    'database' => [
        'host' => '127.0.0.1', // Ou o host do seu MySQL
        'port' => 3306,
        'name' => 'portal_academico_fiap', // Nome do banco que criaremos
        'user' => 'seu-usuario',                 // Seu usuário MySQL
        'pass' => 'sua-senha',                      // Sua senha MySQL
        'charset' => 'utf8mb4'
    ],
    ```
* **Modo de Ambiente:** Mantenha `APP_ENV` como `'production'`:
    ```php
    define('APP_ENV', 'production');
    ```

**4. Crie o Banco de Dados:**

* Conecte-se ao seu servidor MySQL usando sua ferramenta preferida (phpMyAdmin, DBeaver, linha de comando, etc.).
* Crie um novo banco de dados com o nome exato definido no `config.php` (padrão: `portal_academico_fiap`) e *collation* `utf8mb4_unicode_ci`.
    * Exemplo (linha de comando MySQL): `CREATE DATABASE portal_academico_fiap CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;`

**5. Importe os Dados Iniciais (`dump.sql`):**

* Usando sua ferramenta de banco de dados, selecione o banco `portal_academico_fiap`.
* Importe o conteúdo do arquivo `dump.sql` (localizado na raiz do projeto) para este banco.
    * Exemplo (linha de comando MySQL): `mysql -u root -p portal_academico_fiap < dump.sql` (será pedida a senha do MySQL).
* Isso criará as tabelas e inserirá os dados iniciais.

## ▶️ Executando a Aplicação (Servidor Embutido PHP)

1.  Abra seu terminal **na raiz do projeto** (ex: `C:\Projetos\PortalAcademico-FIAP`).
2.  Inicie o servidor embutido do PHP, apontando para a pasta `public` como raiz:
    ```bash
    php -S localhost:8000 -t public
    ```
    *(Você pode usar outra porta se a 8000 estiver ocupada, ex: `localhost:8080`)*.
3.  O terminal mostrará uma mensagem indicando que o servidor iniciou (ex: `Listening on http://localhost:8000`). **Mantenha este terminal aberto** enquanto usa a aplicação.
4.  Abra seu navegador web e acesse a URL: `http://localhost:8000`

* Você deverá ser redirecionado automaticamente para a tela de login (`http://localhost:8000/login`).

## 🔑 Acesso Padrão

* **Usuário:** `admin@fiap.com.br`
* **Senha:** `Admin@123`

*(Este usuário é um Super Administrador).*

---