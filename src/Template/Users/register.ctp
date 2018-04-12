<h1>Register</h1>
<?php
echo $this->Form->create('User', array('url' => \Cake\Routing\Router::url(['controller' => 'Users', 'action' => 'register'])));
echo $this->Form->input('email');
echo $this->Form->input('password', array('type' => 'password'));
echo $this->Form->input('password_confirm', array('type' => 'password'));
echo $this->Form->submit();
echo $this->Form->end();
?>