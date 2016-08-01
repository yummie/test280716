    <?php echo $this->Form->create('User', array('url' => array('controller' => 'users', 'action' => 'login')));?>
    <div class="form-group has-feedback">
      <?php
          echo $this->Form->input('username', array('class' => 'form-control', 'placeholder' => 'Email'));
      ?>
    </div>
    <div class="form-group has-feedback">
      <?php
          echo $this->Form->input('password', array('class' => 'form-control', 'placeholder' => 'Password'));
      ?>
    </div>

