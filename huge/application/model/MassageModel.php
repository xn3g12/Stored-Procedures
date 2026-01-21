<?php

class MassageModel
{
    // Chatverlauf zwischen zwei Usern
    /**public static function getConversation($user1, $user2)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT *
                FROM massage
                WHERE (user_id = :u1 AND receiver_id = :u2)
                   OR (user_id = :u2 AND receiver_id = :u1)
                ORDER BY created_at ASC";

        $query = $db->prepare($sql);
        $query->execute([
            ':u1' => $user1,
            ':u2' => $user2
        ]);

        return $query->fetchAll();
    }**/
        // Chatverlauf zwischen zwei Usern PROCEDURE
    public static function getConversation($user1, $user2){
    $db = DatabaseFactory::getFactory()->getConnection();

    $sql = "CALL spGetConversation(:u1, :u2);";
    $query = $db->prepare($sql);
    $query->execute([
        ':u1' => $user1,
        ':u2' => $user2
    ]);
    return $query->fetchAll();
    }


    // Nachricht senden
    /**public static function sendMessage($sender, $receiver, $text)
    {
        if (empty($text)) {
            return false;
        }

        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "INSERT INTO massage (user_id, receiver_id, massage_text, is_read)
                VALUES (:sender, :receiver, :text, 0)";

        $query = $db->prepare($sql);
        return $query->execute([
            ':sender'   => $sender,
            ':receiver' => $receiver,
            ':text'     => $text
        ]);
    }**/

    // Nachricht senden PROCEDURE
    public static function sendMessage($sender, $receiver, $text)
    {
    if (empty($text)) return false;

    $db = DatabaseFactory::getFactory()->getConnection();

    $sql = "CALL spSendMessage(:sender, :receiver, :text);";
    $query = $db->prepare($sql);
    return $query->execute([
        ':sender'   => $sender,
        ':receiver' => $receiver,
        ':text'     => $text
    ]);
    }

    // Ungelesene Nachrichten zählen
    /**public static function countUnreadMessages($userId)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "SELECT COUNT(*) AS unread
                FROM massage
                WHERE receiver_id = :uid
                  AND is_read = 0";

        $query = $db->prepare($sql);
        $query->execute([':uid' => $userId]);

        return (int)$query->fetch()->unread;
    }**/
    // Ungelesene Nachrichten zählen PROCEDURE
    public static function countUnreadMessages($userId){
    $db = DatabaseFactory::getFactory()->getConnection();

    // Stored Procedure mit OUT Parameter aufrufen
    $query = $db->prepare("CALL spCountUnreadMessages(:uid, @unread);");
    $query->execute([':uid' => $userId]);

    // OUT Parameter abfragen
    $result = $db->query("SELECT @unread AS unread;")->fetch();
    return (int)$result->unread;
    }

    /**public static function getUnreadMessagesBySender($userId){
        $db = DatabaseFactory::getFactory()->getConnection();
        
        $sql = "SELECT 
                m.user_id AS sender_id,
                u.user_name AS sender_name,
                COUNT(*) AS unread_count
            FROM massage m
            JOIN users u ON u.user_id = m.user_id
            WHERE m.receiver_id = :uid
              AND m.is_read = 0
            GROUP BY m.user_id, u.user_name";

    $query = $db->prepare($sql);
    $query->execute([':uid' => $userId]);

    return $query->fetchAll();
    }**/
    //PROCEDURE
    public static function getUnreadMessagesBySender($userId){
    $db = DatabaseFactory::getFactory()->getConnection();

    $sql = "CALL spGetUnreadMessagesBySender(:uid);";
    $query = $db->prepare($sql);
    $query->execute([':uid' => $userId]);

    return $query->fetchAll();
    }
    // Nachrichten als gelesen markieren
    /**public static function markAsRead($receiverId, $senderId)
    {
        $db = DatabaseFactory::getFactory()->getConnection();

        $sql = "UPDATE massage
                SET is_read = 1
                WHERE receiver_id = :receiver
                  AND user_id = :sender";

        $query = $db->prepare($sql);
        $query->execute([
            ':receiver' => $receiverId,
            ':sender'   => $senderId
        ]);
    }**/
    // Nachrichten als gelesen markieren PROCEDURE
    public static function markAsRead($receiverId, $senderId){
    $db = DatabaseFactory::getFactory()->getConnection();

    $sql = "CALL spMarkAsRead(:receiver, :sender);";
    $query = $db->prepare($sql);
    $query->execute([
        ':receiver' => $receiverId,
        ':sender'   => $senderId
    ]);
    }
}
