<h1>Login</h1>
<?= $this->Form->create(); ?>
<?= $this->Form->input('email'); ?>
<?= $this->Form->input('password'); ?>
<?= $this->Form->button('Login'); ?>
<li><?= $this->Html->link(__('Nie masz konta? Zarejestruj się.'), ['controller' => 'Users', 'action' => 'register']) ?></li>
<?= $this->Form->end(); ?>
