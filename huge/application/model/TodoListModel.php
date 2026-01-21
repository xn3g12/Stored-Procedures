<?php

class TodoListModel
{
    public static function getAllTodos()
    {
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "SELECT * FROM todos ORDER BY id ASC";
        $query = $db->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ); // Objekte zurückgeben
    }

    public static function addTodo($title)
    {
        if (empty($title)) return false;
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "INSERT INTO todos (title) VALUES (:title)";
        $query = $db->prepare($sql);
        return $query->execute([':title' => $title]);
    }

    public static function deleteTodo($id)
    {
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "DELETE FROM todos WHERE id = :id";
        $query = $db->prepare($sql);
        return $query->execute([':id' => $id]);
    }
        public static function updateTodo($id)
    {
        $db = DatabaseFactory::getFactory()->getConnection();
        $sql = "UPDATE FROM todos WHERE id = :id";
        $query = $db->prepare($sql);
        return $query->execute([':id' => $id]);
    }
}
