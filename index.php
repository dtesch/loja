<?php
session_start();
require_once 'config.php';
require_once 'bd.class.php';
BD::conn();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<title></title>
		<script src="js/jquery.js"></script>
		<script src="js/funcoes.js"></script>
	</head>
        <body>
            <div >
                <div >
						<form name="teste" action="" method="post" >
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        <h3 id="myModalLabel">
                        <div id="id"></div>
                        </h3>
                </div>
                <div class="modal-body1 itens_padrao">
                        <h4>Ingredientes</h4>
                        <?php
                        $prod_id = 10;
                        echo '<input class="id" type="hidden" value="'.$prod_id.'" name="id_produto"/>';
                        //echo $prod_id;
                        $add_produto_carrinho = BD::conn()->prepare("SELECT * FROM `produto` WHERE id_prod = ?");
                        $add_produto_carrinho->execute(array($prod_id));
                        if($add_produto_carrinho->rowCount() != 0){
                            while($produto = $add_produto_carrinho->fetchObject()){
                               $ingr = $produto->desc_prod;
                                $ingr_exp = explode(', ', $ingr);
                                $ult_ingr = array_pop($ingr_exp);
                                $ult_exp = explode(' e ', $ult_ingr, 2);
                                $ingredientes = array_merge($ingr_exp, $ult_exp);
                                for($i = 0; $i < count($ingredientes); $i++){
									echo '<span id="item"><input type="checkbox" name="ingrediente" checked="checked" value="'.$ingredientes[$i].'">'.$ingredientes[$i].'</span>';    
                                } 
                            }
                        }
                        ?>
                </div>
                
						<div class="modal-body2 complementos">
                        <h4>Complementos</h4>
						<div class="modal-header linha"></div>
                        <?php
                        $seleciona_complemento = BD::conn()->prepare("SELECT * FROM `complemento`");
                        $seleciona_complemento->execute();
                        if($seleciona_complemento->rowCount() == 0){
                                echo '<p>Não existem complementos para o lanche</p>';
                        }else{
                                while($complemento = $seleciona_complemento->fetchObject()){
                                        echo '<span id="item"><input class="add-complemento" type="checkbox" name="complemento" data-id="'.$complemento->id_compl.'" value="'.$complemento->id_compl.'">'.$complemento->nome_compl.' R$<span id="preco_produto">'.$complemento->preco.'</span></span>';
                                }
								?>
                                                
                                                                <?php
								$preco_carrinho = BD::conn()->prepare("SELECT preco_prod FROM `produto` WHERE id_prod = ?");
								$preco_carrinho->execute(array($prod_id));
								if($preco_carrinho->rowCount() != 0){
									while($preco_produto = $preco_carrinho->fetchObject()){
										$preco = $preco_produto->preco_prod;
										$preco = str_replace('.', ',', $preco);
                                                                                echo 'R$<input type="text" id="preco" value="'.$preco.'" />';
									
									}
								}
								?>
                                                                
								
								
								<span id="qtd"><input type="number" min="1" name="qtd" value="1" /></span>
								<?php
                        }
                        ?>
						</div>
                <div class="modal-footer rodape-modal">
                        <button class="btn" data-dismiss="modal" aria-hidden="true">Fechar</button>
                        <button class="btn btn-primary">Salvar mudanças</button>
                </div>
				</form>
        </div>
        </body>
</html>
