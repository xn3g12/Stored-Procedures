<div class="container">
    <h2>To-Do Liste:</h2>

    <?php $this->renderFeedbackMessages(); ?>

    <form method="post">
        <input type="text" name="todo" placeholder="Todo eingeben..." required>
        <input type="submit" name="hinzufuegen" value="Hinzufügen">
    </form>

<h2>Bestehende Todos:</h2>

<?php if (!empty($this->todos)): ?>

    <?php $i = 1; ?>
    <ul>
        <?php foreach ($this->todos as $todo): ?>
            <li>
                <?= $i++ ?>. <?= htmlspecialchars($todo->title); ?>
                <a href="<?= Config::get('URL'); ?>todolist/delete/<?= $todo->id; ?>">Löschen</a>
                <a href="<?= Config::get('URL'); ?>todolist/update/<?= $todo->id; ?>">Ändern</a>
            </li>
        <?php endforeach; ?>
    </ul>

<?php else: ?>
    <p>Keine Todos vorhanden</p>
<?php endif; ?>

</ul>

</div>
