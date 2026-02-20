<?php
$db = new PDO("sqlite:../database.sqlite");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

/* CRIA TABELAS SE NÃO EXISTIREM */

$db->exec("CREATE TABLE IF NOT EXISTS usuarios (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT,
    email TEXT UNIQUE,
    senha_hash TEXT,
    tipo_perfil TEXT,
    telefone TEXT,
    cpf TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS categorias (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    nome TEXT,
    ativa INTEGER DEFAULT 1
)");

$db->exec("CREATE TABLE IF NOT EXISTS produtos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    categoria_id INTEGER,
    nome TEXT,
    descricao TEXT,
    preco REAL,
    estoque_atual INTEGER,
    destaque INTEGER DEFAULT 0,
    imagem_principal_url TEXT
)");

$db->exec("CREATE TABLE IF NOT EXISTS pedidos (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    cliente_id INTEGER,
    data_criacao TEXT,
    status TEXT,
    tipo_entrega TEXT,
    valor_total REAL
)");

$db->exec("CREATE TABLE IF NOT EXISTS itens_pedido (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    pedido_id INTEGER,
    produto_id INTEGER,
    quantidade INTEGER,
    preco_unitario REAL
)");

$db->exec("CREATE TABLE IF NOT EXISTS configuracao_loja (
    id INTEGER PRIMARY KEY,
    chave_pix_destino TEXT,
    nome_beneficiario TEXT,
    cidade_beneficiario TEXT
)");

/* CRIA ADMIN PADRÃO */
$senha = password_hash("123456", PASSWORD_DEFAULT);

$db->exec("INSERT OR IGNORE INTO usuarios 
(id,nome,email,senha_hash,tipo_perfil)
VALUES (1,'Admin','admin@amor.com','$senha','ADMIN')");
?>
