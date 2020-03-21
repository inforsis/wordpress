<?php
//CONEXÃO BD
global $wpdb;
$table_name = $wpdb->prefix . 'email'; 
 
ini_set("display_errors", 0 );
error_reporting(0); 


if ($_REQUEST['tipo'] == 'status') {
	$status = $_REQUEST['status'];
	$id     = $_REQUEST['id'];

	$wpdb->update( 
	    $table_name, 
	    array( 
	        'id' => $id
	    ), 
	    array( 'ativo' => $status ), 
	    array( 
	        '%d'   // value1
	    )
	);
}

?>
<style>
	table {
		width:100%;
		td,
		th {
			padding:5px;
		}
	}
</style>

<script>
	function mudarStatusEmail(elem,id) {
		var status = jQuery(elem).val();
		alert ('0')
		jQuery.ajax({
				url: '',
				type: 'GET',
				dataType: 'html',
				data: {tipo: 'status',status: status, id: id},
			})
			.done(function(data) {
				//escreve a mensagem de retorno
				alert('==================RETORNO============ '+data);
			})
			.fail(function(data) {
				var mensagem = 'Ocorreu um erro no envio da requisição. Tente novamente!';
				//escreve a mensagem de retorno
				alert(mensagem);
			})
			.always(function(data) {
				
		});
	}
</script>

<?php
	$wpdb->delete(
        $table_name,
        array(
            'id' => $_GET['email_id']
        ),
        array(
            '%d',
        )
    );
?>

<div style="padding:15px;">

	<h1 class="wp-heading-inline">
		E-MAILS CADASTRADOS NA NEWSLETTER
	</h1>
		
	<table class="wp-list-table widefat fixed striped pages">
		
		<thead>
			<tr>
				<th>
					ID
				</th>
				<td>
					NOME
				</td>
				<th>
					E-MAIL
				</th>
				<th>
					DATA
				</th>
				<th>
					EXCLUIR
				</th>
			</tr>
		</thead>

		<?php

		    $myrows = $wpdb->get_results( "SELECT nome, email, id, time, ativo FROM $table_name" );
		    echo "<tbody>";
		    if (count($myrows) > 0) {
			    for ($i = 0; $i<count($myrows); $i++) {
			    	$selected0 = '';
			    	$selected1 = '';
			    	if($myrows[$i]->ativo == 0) {
			    		$selected0 = 'selected';
			    	}
			    	if($myrows[$i]->ativo == 1) {
			    		$selected1 = 'selected';
			    	}
			        echo "<tr>".
			            "<td>".
			                 $i.
			             "</td>".
			             "<td>".
			             $myrows[$i]->nome.
			             "</td>".
			             "<td>".
			             $myrows[$i]->email.
			             "</td>".
			             "<td>".
			             $myrows[$i]->time.
			             "</td>".
			             "<td><a href='?page=wp-newsletter-register&email_id=".$myrows[$i]->id."' >excluir</a></td>".
			             "</tr>";   
			    }
			}
			else {
				echo "<tr><td colspan='6'>Nenhum e-mail cadastrado!</td></tr>";
			}
		    echo "</tbody>";

		?>

	</table>

</div><!--#wpcontent-->