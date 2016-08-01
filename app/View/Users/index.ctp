
<!--<p><?php echo __('Logado como:') . ' ' . $this->Session->read('Auth.User.username'); ?></p>-->
<section class="content">
	<div class="row">
		<div class="col-md-12">
			<?php echo $this->Html->link(__('Novo'), array('action' => 'add'), array('class' => 'btn btn-primary btn-sm')); ?>
			<div class="box" style="margin-top: 10px;">
			  <div class="box-header">
			    <h3 class="box-title">Lista de usuários cadastrados</h3>
			  </div>
			  <!-- /.box-header -->
			  <div class="box-body">
			    <table id="example1" class="table table-bordered table-striped dataTable">
			      <thead>
			      <tr>
			      	<th>Foto</th>
			      	<th>Nome</th>
			      	<th>E-mail</th>
			        <th>Usuário</th>
			        <th>Descrição</th>
			        <th>Tipo</th>
			        <th>Ações</th>
			      </tr>
			      </thead>
			      <tbody>
			      		<?php foreach ($users as $users): ?>
			      		<tr>
			      			<td class=""><?php echo $this->Html->image('/img/'.h($users['User']['foto']), array('alt' => 'CakePHP', 'border' => '0', 'style' => 'width: 50px; height: 50px;')); ?></td>
			      			<td><?php echo h($users['User']['nome']); ?>&nbsp;</td>
			      			<td><?php echo h($users['User']['email']); ?>&nbsp;</td>
			      			<td><?php echo h($users['User']['username']); ?>&nbsp;</td>
			      			<td><?php echo h($users['User']['descricao']); ?>&nbsp;</td>
			      			<td><?php 
			      					  if($users['User']['role_id'] == 1)
			      						echo "Administrador";
			      					   else
			      					   	echo "Membro"; 
			      				 ?>
			      			</td>

			      			<td class="actions" style="width: 200px;">
			      				<?php if($users['User']['status'] == 0): ?>
			      				<a href="#" class='btn btn-info btn-sm btnAtivar' data-id="<?php echo h($users['User']['id']); ?>"> Ativar </a>
			      				<?php else: ?>
			      				<a href="#" class='btn btn-primary btn-sm btnInativar' data-id="<?php echo h($users['User']['id']); ?>"> Inativar </a>
			      				<?php endif?>
			      				<?php echo $this->Html->link(__('Editar'), array('action' => 'edit', $users['User']['id']), array('class' => 'btn btn-success  btn-sm btnDetalhes')); ?>
			      				<a href="#" class='btn btn-danger btn-sm btnRemover' data-id="<?php echo h($users['User']['id']); ?>"> Remover </a>
			      			</td>
			      		</tr>
			      	<?php endforeach; ?>
			      </tbody>
			    </table>
			  </div>
			  <!-- /.box-body -->
			</div>
			<!-- /.box -->
		</div>
	</div>
</section>

<script type="text/javascript">
	$(document).ready(function(){
		$('.dataTable').DataTable({
		        "language": {
		            "sEmptyTable": "Nenhum registro encontrado",
		            "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
		            "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
		            "sInfoFiltered": "(Filtrados de _MAX_ registros)",
		            "sInfoPostFix": "",
		            "sInfoThousands": ".",
		            "sLengthMenu": "_MENU_ resultados por página",
		            "sLoadingRecords": "Carregando...",
		            "sProcessing": "Processando...",
		            "sZeroRecords": "Nenhum registro encontrado",
		            "sSearch": "Pesquisar",
		            "oPaginate": {
		                "sNext": "Próximo",
		                "sPrevious": "Anterior",
		                "sFirst": "Primeiro",
		                "sLast": "Último"
		            },
		            "oAria": {
		                "sSortAscending": ": Ordenar colunas de forma ascendente",
		                "sSortDescending": ": Ordenar colunas de forma descendente"
		            }
		        }
		    });
		ativar();
		inativar();
		remover();
	});
function remover() {
	$(document).on('click', ".btnRemover", function(){
		var id = $(this).data('id');
		var button = $(this);
		swal({
			title: "Atenção",
		    text: "Você tem certeza que deseja remover este usuário?",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonColor: "#DD6B55",
		    confirmButtonText: "Sim",
		    cancelButtonText: "Não",
		    closeOnConfirm: false
		}, function(){
			    $.ajax({
			    	method: "post",
			    	url: myBaseUrl + '/users/delete/'+id,
			    }).done(function(retorno){
			    	if(retorno == "success"){
			    		button.closest('tr').remove();
			    		swal("Sucesso!", "Usuário foi removido com sucesso.", "success");
			    	}
			    }); 
		   });
	});
}

function ativar() {
	$(".btnAtivar").on('click', function(){
		var id = $(this).data('id');
		var button = $(this);
		swal({
			title: "Você tem certeza que deseja ativar este usuário?",
		    text: "Usuário voltará a ter acesso ao sistema",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonColor: "#DD6B55",
		    confirmButtonText: "Sim",
		    cancelButtonText: "Não",
		    closeOnConfirm: false
		}, function(){
			    $.ajax({
			    	method: "post",
			    	url: myBaseUrl + '/users/ativar/'+id,
			    }).done(function(retorno){
			    	if(retorno == "success"){
			    		if(retorno == "success"){
			    			swal("Sucesso!", "Usuário foi ativado com sucesso.", "success");
			    			location.reload();
			    		}else{
			    			swal("Error!", "Ocorreu um erro ao tentar ativar usuário", "error");
			    		}
			    	}
			    }); 
		   });
	});
}

function inativar() {
	$(document).on('click', ".btnInativar", function(){
		var id = $(this).data('id');
		var button = $(this);
		swal({
			title: "Você tem certeza que deseja inativar esse usuário?",
		    text: "Usuário não terá mais acesso ao sistema.",
		    type: "warning",
		    showCancelButton: true,
		    confirmButtonColor: "#DD6B55",
		    confirmButtonText: "Sim",
		    cancelButtonText: "Não",
		    closeOnConfirm: false
		}, function(){
			    $.ajax({
			    	method: "post",
			    	url: myBaseUrl + '/users/inativar/'+id,
			    }).done(function(retorno){
			    	if(retorno == "success"){
			    		swal("Sucesso!", "Usuário foi inativado com sucesso.", "success");
			    		location.reload();
			    	}else{
			    		swal("Error!", "Ocorreu um erro ao tentar inativar usuário", "error");
			    	}
			    }); 
		   });
	});
}
</script>