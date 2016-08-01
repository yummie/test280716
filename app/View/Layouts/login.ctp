<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('/AdminLTE/bootstrap/css/bootstrap.min.css');
		echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css');
		echo $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css');
		echo $this->Html->css('/AdminLTE/dist/css/AdminLTE.min.css');
		echo $this->Html->css('/AdminLTE/dist/css/skins/_all-skins.min.css');
		echo $this->Html->css('/AdminLTE/plugins/iCheck/flat/blue.css');
		echo $this->Html->css('/AdminLTE/plugins/morris/morris.css');
		echo $this->Html->css('/AdminLTE/plugins/morris/morris.css');
		echo $this->Html->css('/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.css');
		echo $this->Html->css('/AdminLTE/plugins/datepicker/datepicker3.css');
		echo $this->Html->css('/AdminLTE/plugins/daterangepicker/daterangepicker.css');
		echo $this->Html->css('/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
		echo $this->Html->css('/AdminLTE/plugins/sweetalert-master/dist/sweetalert.css');
		
		echo $this->Html->script('/AdminLTE/plugins/jQuery/jquery-2.2.3.min.js');
		echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js');
		echo $this->Html->script('/AdminLTE/plugins/morris/morris.min.js');
		echo $this->Html->script('/AdminLTE/plugins/sparkline/jquery.sparkline.min.js');
		echo $this->Html->script('/AdminLTE/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js');
		echo $this->Html->script('/AdminLTE/plugins/jvectormap/jquery-jvectormap-world-mill-en.js');
		echo $this->Html->script('/AdminLTE/plugins/knob/jquery.knob.js');
		echo $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js');
		echo $this->Html->script('/AdminLTE/plugins/daterangepicker/daterangepicker.js');
		echo $this->Html->script('/AdminLTE/plugins/datepicker/bootstrap-datepicker.js');
		echo $this->Html->script('/AdminLTE/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
		echo $this->Html->script('/AdminLTE/plugins/slimScroll/jquery.slimscroll.min.js');
		echo $this->Html->script('/AdminLTE/dist/js/demo.js');
		echo $this->Html->script('/AdminLTE/plugins/sweetalert-master/dist/sweetalert.min.js');
	?>
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->

  
  <div class="login-box-body">
    <p class="login-box-msg">Digite seu login e senha para acessar o sistema</p>
    <p style="color: red !important;"> <?php echo $this->Session->flash(); ?> </p>
    <?php echo $this->fetch('content'); ?>

    <div class="row">
      <!-- /.col -->
      <div class="col-xs-4">
         <?php echo $this->Form->submit('Entrar', array('class' => 'btn btn-primary btn-block btn-flat'));?>
         <?php echo $this->Form->end();?>
      </div>
      <!-- /.col -->
    </div>
    <br/>
    <!-- /.social-auth-links -->
    <a href="#" id="senha">Esqueci minha senha</a><br>

  </div>
  <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

</script>
</body>
<script type="text/javascript">
	var myBaseUrl = '<?php echo $this->request->base ?>';
	$(document).ready(function(){
		$("#senha").on('click', function(){
			swal({
			   title: "Esqueceu sua senha?",
			   type: "input",
			   showCancelButton: true,
			   closeOnConfirm: false,
			   animation: "slide-from-top",
			   cancelButtonText: "Cancelar",
			   showLoaderOnConfirm: true,
			   inputPlaceholder: "Digite seu nome de usuário"
		    }, function(inputValue){
		       if (inputValue === false) 
		       		return false;  
		       if (inputValue === "") { 
		           swal.showInputError("Campo usuário é obrigatório!");
		               return false; 
		        }  
		        $.ajax({
		        	method: "GET",
		        	url: myBaseUrl + '/users/esqueci_minha_senha/'+inputValue,
		        }).done(function(retorno){
		        	if(retorno == "not"){
		        		swal("Atenção!", "Usuário não encontrado", "error"); 
		        	}else if(retorno == "success"){
		        		swal("Sucesso", "Sua nova senha foi enviada para o e-mail cadastrado", "success"); 
		        	}
		        })    
		 	});
		});
	});
</script>
</html>
