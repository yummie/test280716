<?php

App::uses('AuthComponent', 'Controller/Component');

class User extends AppModel {
    
    public $name = 'User';

    public $validate = array(
           'username' => array(
               'alphaNumeric' => array(
                   'rule' => array('minLength', '6'),
                   'message' => 'Seu usuário deve conter no mínimo 6 caracteres'
               )
           ),
           'password' => array(
               'rule' => array('minLength', '6'),
               'message' => 'Sua senha deve conter no mínimo 6 caracteres'
           ),
           'nome' => array(
           	   'rule' => array('minLength', '1'),
               'message' => 'Campo nome é obrigatório'
           ),
           'email' => array(
                'email'
            ),
       );
    
    public function beforeSave($options = array()) {
        if (!empty($this->data['User']['password'])) {
            $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
        }else{
            unset($this->data['User']['password']);
        }
        if (empty($this->data['User']['foto'])) {
            unset($this->data['User']['foto']);
        }
       // $this->data['User']['status'] = 1;
        return true;
    }

    public function getCurrentUser()
    {
      return $usuario = $this->User->find('first', array('conditions' => array('id' => $this->Auth->user('id'))));
    }
}

?>