<section>
    <h1>Users</h1>
    <a href="?r=/out">Reset</a>
</section>

<form action="?r=/list" method="POST">
    <label for="user">User: </label>
    <input type="text" name="usuario" id="usuario"/>
    <button>Send</button>
</form>

<small><?php echo count($vars['usuario']) ?> usuario.</small>
<ul>
    <?php foreach ($vars['usuario'] as $user): ?>
        <li><?php echo $user ?></li>
    <?php endforeach ?>
</ul>