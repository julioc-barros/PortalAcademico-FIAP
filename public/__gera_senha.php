<?php

// Arquivo para geração de senhas dos usuarios 

$senhaEmTextoPuro = 'Admin@123';
$algoritmo = PASSWORD_BCRYPT;
$hash = password_hash($senhaEmTextoPuro, $algoritmo);

// 4. Exibir o hash gerado
echo $senhaEmTextoPuro;
echo "<br>";
echo $hash;
echo "<br>";

echo "<br>";

$senhaEmTextoPuro = 'Aluno@123';
$algoritmo = PASSWORD_BCRYPT;
$hash = password_hash($senhaEmTextoPuro, $algoritmo);

echo $senhaEmTextoPuro;
echo "<br>";
echo $hash;
echo "<br>";