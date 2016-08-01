    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cadastrar um novo usuário</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                     <?php echo $this->Form->create('User', array('enctype' => 'multipart/form-data'));?>
                        <div class="form-horizontal">
                            <div class="box-body">
                                
                            	<div class="form-group">
                            	    <label class="col-xs-2 control-label" for="nome">Nome</label>
                            	    <div class="col-xs-8">
                            	        <?php echo $this->Form->input('nome', array('class' => 'form-control', 'label' => false)); ?>
                            	    </div>
                            	</div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="nome">E-mail</label>
                                    <div class="col-xs-8">
                                        <?php echo $this->Form->input('email', array('class' => 'form-control', 'label' => false)); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="username">Login</label>
                                    <div class="col-xs-8">
                                        <?php echo $this->Form->input('username', array('class' => 'form-control', 'label' => false)); ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="password">Senha</label>
                                    <div class="col-xs-8">
                                        <?php echo $this->Form->input('password', array('class' => 'form-control','value' => '','label' => false));  ?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="role_id">Tipo</label>
                                    <div class="col-xs-8">
                                        <?php echo $this->Form->input('role_id', array(
												    'options' => array(1 => 'Administrador', 2 => 'Membro'), 'label' => false, 'class' => 'form-control'
												));  ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="descricao">Descrição</label>
                                    <div class="col-xs-8">
                                        <?php echo $this->Form->input('descricao', array('class' => 'form-control','value' => '','label' => false, 'type' => 'textarea'));  ?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-2 control-label" for="picture">Foto</label>
                                    <div class="col-xs-8">
                                        <?php echo $this->Form->file('picture', array('class' => 'form-control', 'label' => false
                                            ));  ?>
                                    </div>
                                </div>


                            </div>
                            <!-- /.box - body-->
                            <div class="box-footer">
                                <button type="submit" class="btn btn-success">Cadastrar</button>
                                <input type="button" value="Voltar" class="btn btn-default" onclick="history.go(-1); return false;" />
                            </div>

                            <?php echo $this->Form->end();?>
                            <!-- /.box-footer -->
                        </div>
                </div>
            </div>
        </div>
    </section>
