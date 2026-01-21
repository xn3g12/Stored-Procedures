<h2>Choose a user to chat with:</h2>
<ul>
<?php foreach ($this->users as $user) { ?>
    <?php if ($user->user_id != Session::get('user_id')) { ?>
        <li>
            <a href="<?= Config::get('URL') ?>massage/chat/<?= $user->user_id ?>">
                <?= htmlentities($user->user_name) ?>
            </a>
        </li>
    <?php } ?>
<?php } ?>
</ul>
