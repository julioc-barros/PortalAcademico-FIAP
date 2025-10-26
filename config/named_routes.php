<?php

/**
 * Mapa de Rotas Nomeadas.
 * Associa um nome amigável a um path de URL.
 * Utilizado para evitar alterar rota em todos os lugares
 */
return [
   // Auth & Dashboard
   'dashboard' => '/',
   
   'login' => '/login',
   'login.auth' => '/login/auth',
   'logout' => '/logout',

   // Alunos
   'alunos.index' => '/alunos',
   'alunos.create' => '/alunos/novo',
   'alunos.store' => '/alunos/salvar',
   'alunos.edit' => '/alunos/editar',
   'alunos.update' => '/alunos/atualizar',
   'alunos.delete' => '/alunos/excluir',

   // Turmas
   'turmas.index' => '/turmas',
   'turmas.create' => '/turmas/novo',
   'turmas.store' => '/turmas/salvar',
   'turmas.edit' => '/turmas/editar',
   'turmas.update' => '/turmas/atualizar',
   'turmas.delete' => '/turmas/excluir',
   'turmas.show' => '/turmas/visualizar',

   // Matrículas
   'matriculas.index' => '/matriculas',
   'matriculas.store' => '/matriculas/salvar',
];