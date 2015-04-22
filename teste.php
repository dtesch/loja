<?php
session_start();

require_once 'config.php';
require_once 'bd.class.php';
BD::conn();

$id_compl = $_POST['id_complemento'];
$id_prod = $_POST['id_produto'];
$acao = $_POST['acao'];

$id_sessao = $_SESSION['id_sessao'] = md5($id_prod);

$seleciona_complemento = BD::conn()->prepare("SELECT * FROM `complemento` WHERE id_compl = ?");
$seleciona_complemento->execute(array($id_compl));
if($seleciona_complemento->rowCount() != 0){
    while($complemento = $seleciona_complemento->fetchObject()){
        $preco_complemento = $complemento->preco;  
    }
}
$preco_atual_produto = BD::conn()->prepare("SELECT preco_prod FROM `produto` WHERE id_prod = ?");
$preco_atual_produto->execute(array($id_prod));
if($preco_atual_produto->rowCount() != 0){
    while($preco_atual = $preco_atual_produto->fetchObject()){
        $preco_produto = $preco_atual->preco_prod;
    }
}

switch ($acao){
    case 'add':
        $insere_pedido = BD::conn()->prepare("INSERT INTO `teste` (id_prod, id_compl, novo_preco, id_sessao) VALUES (?, ?, ?, ?)");
        if($insere_pedido->execute(array($id_prod, $id_compl, $preco_complemento,  $id_sessao))){
            $verifica_pedido = BD::conn()->prepare("SELECT novo_preco FROM `teste` WHERE id_sessao = ? AND id_prod = ? ");
            $verifica_pedido->execute(array($id_sessao, $id_prod));
            if($verifica_pedido->rowCount() != 0){
                while($pedido = $verifica_pedido->fetchObject()){
                    $preco_total_complementos  = $pedido->novo_preco;
                }
            $preco_tela = $preco_total_complementos + $preco_produto;
            echo $preco_tela;
            }
        }
        break;
    case 'sub':
        $deleta_pedido = BD::conn()->prepare("DELETE FROM `teste` WHERE id_sessao = ? AND id_compl = ?");
        $deleta_pedido->execute(array($id_sessao, $id_compl));
        $seleciona_pedido = BD::conn()->prepare("SELECT *FROM `teste` WHERE id_sessao = ? AND id_prod = ?");
        $seleciona_pedido->execute(array($id_sessao, $id_prod));
        if($seleciona_pedido->rowCount() != 0){
            while($pedido = $seleciona_pedido->fetchObject()){
                    $preco_total_complementos  = $pedido->novo_preco;
            }
            $sub_tela = $preco_total_complementos + $preco_produto;
            echo $sub_tela;
        }
        
        break;
}
