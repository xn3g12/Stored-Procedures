<?php

class MassageController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        Auth::checkAuthentication();
    }

    // Userliste + Chat anzeigen
    public function index($receiver_id = null)
    {
        // Alle User laden (ohne mich)
        $users = UserModel::getPublicProfilesOfAllUsers();
        unset($users[Session::get('user_id')]);

        $messages = [];

        // Wenn ein Chat geöffnet ist
        if ($receiver_id !== null) {

            // Nachrichten als gelesen markieren
            MassageModel::markAsRead(
                Session::get('user_id'),
                $receiver_id
            );

            // Chatverlauf laden
            $messages = MassageModel::getConversation(
                Session::get('user_id'),
                $receiver_id
            );
        }

        // Ungelesene Nachrichten zählen
        $unreadCount = MassageModel::countUnreadMessages(
            Session::get('user_id')
        );
        $unreadBySender = MassageModel::getUnreadMessagesBySender(
    Session::get('user_id')
        );


        $this->View->render('massage/index', [
            'users'        => $users,
            'messages'     => $messages,
            'receiver_id'  => $receiver_id,
            'unreadCount'  => $unreadCount,
            'unreadBySender'   => $unreadBySender
        ]);
    }

    // Nachricht senden
    public function sendChat()
    {
        MassageModel::sendMessage(
            Session::get('user_id'),
            Request::post('receiver_id'),
            Request::post('massage_text')
        );

        Redirect::to('massage/index/' . Request::post('receiver_id'));
    }
}
