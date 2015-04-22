$(function($){
        $('.add-complemento').on('change', function(){
            var state = $(this).is(':checked');
            if(state === true){
                console.log(state);
                var id_compl = $(this).val();
                var id_prod = $('.id').val();
                var acao = 'add';
                $.ajax({
			url: 'teste2.php',
			type: 'POST',
			data: 'id_complemento='+ id_compl + '&id_produto='+id_prod+'&acao='+acao,
			success: function(data){
				$('#preco').val(data);
                                console.log(data);
			}
		});
            }else{
                console.log(state);
                var id_compl = $(this).val();
                var id_prod = $('.id').val();
                var acao = 'sub';
                $.ajax({
			url: 'teste2.php',
			type: 'POST',
			data: 'id_complemento='+ id_compl + '&id_produto='+id_prod+'&acao='+acao,
			success: function(data){
				$('#preco').val(data);
                                console.log(data);
			}
		});
            }
            console.log(acao);
        });
});
        
    
	
