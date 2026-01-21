<div class="container">
    <h1>Massage Chat</h1>

    <div class="box">
        <?php $this->renderFeedbackMessages(); ?>

        <h3>Choose a user to chat with:</h3>

        <table class="overview-table">
            <thead>
            <tr>
                <td>Id</td>
                <td>Avatar</td>
                <td>Username</td>
                <td>Email</td>
                <td>Active?</td>
                <td>Action</td>
            </tr>
            </thead>
            <tbody>
                <?php if (!empty($this->unreadBySender)) { ?>
                <div class="notification">
                    You have 🔔 New messages from:
                    <ul>
                        <?php foreach ($this->unreadBySender as $msg) { ?>
                        <li>
                            <?= htmlentities($msg->sender_name) ?>
                            (<?= $msg->unread_count ?>)
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <?php } ?>                
                <table class="overview-table">
            <?php foreach ($this->users as $user) { ?>
                <tr class="<?= ($user->user_active == 0 ? 'inactive' : 'active'); ?>">
                    <td><?= $user->user_id; ?></td>
                    <td class="avatar">
                        <?php if (isset($user->user_avatar_link)) { ?>
                            <img src="<?= $user->user_avatar_link; ?>" width="40" height="40"/>
                        <?php } ?>
                    </td>
                    <td><?= htmlentities($user->user_name); ?></td>
                    <td><?= htmlentities($user->user_email); ?></td>
                    <td><?= ($user->user_active == 0 ? 'No' : 'Yes'); ?></td>
                    <td>
                        <a class="btn" href="<?= Config::get('URL') ?>massage/index/<?= $user->user_id ?>">
                            Chat
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <?php if (!empty($this->receiver_id)) { ?>
        <div class="box chat-box">
            <h3>Chat with <?= htmlentities($this->users[$this->receiver_id]->user_name); ?></h3>

            <div class="messages" id="chatMessages">
                <?php foreach ($this->messages as $msg) { ?>
                    <p>
                        <strong><?= $msg->user_id == Session::get('user_id') ? 'You' : htmlentities($this->users[$msg->user_id]->user_name) ?>:</strong>
                        <?= htmlentities($msg->massage_text); ?>
                    </p>
                <?php } ?>
            </div>

            <form method="post" action="<?= Config::get('URL') ?>massage/sendChat">
                <input type="hidden" name="receiver_id" value="<?= $this->receiver_id ?>">
                <input type="text" name="massage_text" placeholder="Type your message..." required>
                <button type="submit">Send</button>
            </form>
        </div>
    <?php } ?>
</div>

<!-- Scroll automatisch zum Ende des Chats -->
<script>
    var chatDiv = document.getElementById("chatMessages");
    if (chatDiv) {
        chatDiv.scrollTop = chatDiv.scrollHeight;
    }
</script>
