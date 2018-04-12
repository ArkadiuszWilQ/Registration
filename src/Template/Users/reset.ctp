<h1>Reset</h1>
<?php
echo $this->Form->create('User', array('url' => \Cake\Routing\Router::url(['controller' => 'Users', 'action' => 'reset'])));
echo $this->Form->input('password');
echo $this->Form->submit();
echo $this->Form->end();
?>