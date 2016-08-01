<?php

class UsersController extends AppController {

    public $name = 'Users';
    
    public $uses = array('User');

    public $components = array('Paginator');

    public function beforeFilter()
    {
        parent::beforeFilter();                     
    }

    public function admin_index()
    {
       
    }

    public function index()
    {
        if($this->Auth->user('role_id') == 2){
            return $this->redirect(array(
                  'controller' => 'users', 'action' => 'edit', $this->Auth->user('id'))
              );
        }
        $this->set('title_for_layout', __('Listagem de usuários'));
        $this->User->recursive = 0;
        $this->set('users', $this->Paginator->paginate());
    }

    public function add()
    {
      //  echo WWW_ROOT."..\Vendor\sendgrid\sendgrid\lib\SendGrid.php";
        if($this->Auth->user('role_id') == 2){
            return $this->redirect(array(
                  'controller' => 'users', 'action' => 'edit', $this->Auth->user('id'))
              );
        }
        $this->set('title_for_layout', __('Cadastrar um novo usuário'));
        if (!empty($this->request->data)) {
            $this->User->create();
            $this->request->data['User']['status'] = 1;
            if(!empty($this->request->data['User']['picture']['name']))
                 $this->request->data['User']['foto'] = $this->upload($this->request->data['User']['picture']); 
            else 
                 $this->request->data['User']['foto'] = "usuario_login.png";
            if ($this->User->save($this->request->data)) {
                $mail = new AppModel;
                try{
                   $mail->send($this->request->data['User']['email'], "Bem-vindo ao sistema de teste", "Olá, <strong>".$this->request->data['User']['nome']."</strong> . <br/><br/> Bem-vindo ao nosso sistema de teste");  
               }catch(Exception $e){

               }       
                $this->Session->setFlash(__('Usuario cadastrado com sucesso'), 'default', array('class' => 'success'));
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('Erro no cadastro, tente de novo.'), 'default', array('class' => 'error'));
            }
        }
    }

    public function edit($id = null) {
        $this->set('title_for_layout', __('Editar usuário'));
        if (!$this->User->exists($id)) {
            throw new NotFoundException(__('Invalid usle'));
        }

        if ($this->request->is(array('post', 'put'))) {
            if(!empty($this->request->data['User']['nova_senha']))
                $this->request->data['User']['password'] = $this->request->data['User']['nova_senha'];

            if(!empty($this->request->data['User']['picture']['name']))
                 $this->request->data['User']['foto'] = $this->upload($this->request->data['User']['picture']); 
            else 
                 $this->request->data['User']['foto'] = "";
            $this->request->data['User']['status'] = 1;
            if ($this->User->save($this->request->data)) {
                $this->Session->write('Auth', $this->User->read(null, $this->Auth->User('id')));
                return $this->redirect(array('action' => 'index'));
            } 
        } else {
            $options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
            $this->request->data = $this->User->find('first', $options);
            $this->set('ActiveUser',  $this->request->data);
        }
    }

    public function delete($id) {
        $this->User->id = $id;
        if ($this->User->delete()) {
               echo "success";
               die();
        }
        echo "error";
        die();  
    }

    public function inativar($id) {
        $usuario = $this->User->find('first', array('conditions' => array('id' => $id)));
        $usuario['User']['status'] = 0;
        $usuario['User']['password'] = "";
        if ($this->User->save($usuario['User'], false)) {
               echo "success";
               die();
        }
        echo "error";
        die();
    }

    public function ativar($id) {
        $usuario = $this->User->find('first', array('conditions' => array('id' => $id)));
        $usuario['User']['status'] = 1;
        $usuario['User']['password'] = "";
        if ($this->User->save($usuario['User'], false)) {
               echo "success";
               die();
        }
        echo "error";
        die();
    }

    public function esqueci_minha_senha($username) {
        $usuario = $this->User->find('first', array('conditions' => array('username' => $username)));
        if(!empty($usuario)){
            $novaSenha = AppModel::geraSenha();
            $usuario['User']['password'] = $novaSenha;
            if ($this->User->save($usuario['User'], false)) {
                 $mail = new AppModel;
                     try{
                        $mail->send($usuario['User']['email'], "Nova senha de acesso", "Olá, <strong>".$usuario['User']['nome']."</strong> . <br/><br/> Sua nova senha de acesso ao sistema de teste é: <strong> ".$novaSenha." </strong>");  
                    }catch(Exception $e){

                    }
                   echo "success";
                   die();
            }     
        }
        echo "not";
        die();
    }


    public function login()
    {
        $this->layout = "login";
        $this->set('title_for_layout', __('Log in'));
        if ($this->request->is('post')) {
            if ($this->Auth->login()) {
               // var_dump($this->Auth->redirect());
               // die();
                if($this->Auth->user('role_id') == 1){
                    return $this->redirect(array(
                          'controller' => 'users', 'action' => 'index'));
                }else{
                  return $this->redirect(array(
                        'controller' => 'users', 'action' => 'edit', $this->Auth->user('id'))
                    );
                }
            } else {
                $this->Session->setFlash(__('Usuário e/ou senha incorretos.'));
                $this->redirect($this->Auth->loginAction);
            }
        }
    }

    public function logout()
    {
        $this->redirect($this->Auth->logout());
    }


    public function upload($imagem = array(), $dir = 'img')
    {
        $dir = WWW_ROOT.$dir.DS;

        if(($imagem['error']!=0) and ($imagem['size']==0)) {
            throw new NotImplementedException('Alguma coisa deu errado, o upload retornou erro '.$imagem['error'].' e tamanho '.$imagem['size']);
        }

        $this->checa_dir($dir);

        $imagem = $this->checa_nome($imagem, $dir);

        $this->move_arquivos($imagem, $dir);

        return $imagem['name'];
    }

    /**
     * Verifica se o diretório existe, se não ele cria.
     * @access public
     * @param Array $imagem
     * @param String $data
    */ 
    public function checa_dir($dir)
    {
        App::uses('Folder', 'Utility');
        $folder = new Folder();
        if (!is_dir($dir)){
            $folder->create($dir);
        }
    }

    /**
     * Verifica se o nome do arquivo já existe, se existir adiciona um numero ao nome e verifica novamente
     * @access public
     * @param Array $imagem
     * @param String $data
     * @return nome da imagem
    */ 
    public function checa_nome($imagem, $dir)
    {
        $imagem_info = pathinfo($dir.$imagem['name']);
        $imagem_nome = $this->trata_nome($imagem_info['filename']).'.'.$imagem_info['extension'];
        //debug($imagem_nome);
        $conta = 2;
        while (file_exists($dir.$imagem_nome)) {
            $imagem_nome  = $this->trata_nome($imagem_info['filename']).'-'.$conta;
            $imagem_nome .= '.'.$imagem_info['extension'];
            $conta++;
          //  debug($imagem_nome);
        }
        $imagem['name'] = $imagem_nome;
        return $imagem;
    }

    /**
     * Trata o nome removendo espaços, acentos e caracteres em maiúsculo.
     * @access public
     * @param Array $imagem
     * @param String $data
    */ 
    public function trata_nome($imagem_nome)
    {
        $imagem_nome = strtolower(Inflector::slug($imagem_nome,'-'));
        return $imagem_nome;
    }

    /**
     * Move o arquivo para a pasta de destino.
     * @access public
     * @param Array $imagem
     * @param String $data
    */ 
    public function move_arquivos($imagem, $dir)
    {
        App::uses('File', 'Utility');
        $arquivo = new File($imagem['tmp_name']);
        $arquivo->copy($dir.$imagem['name']);
        $arquivo->close();
    }
    
 }

?>