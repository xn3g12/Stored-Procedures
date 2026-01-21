<?php

class TodoListController extends Controller
{
    public function index()
    {
        // Todo hinzufügen
        if (Request::post('hinzufuegen')) {
            $title = trim(Request::post('todo'));
            if (!empty($title)) {
                TodoListModel::addTodo($title);
                Session::add('feedback_positive', 'Todo hinzugefügt');
            } else {
                Session::add('feedback_negative', 'Todo darf nicht leer sein');
            }

            Redirect::to('todolist/index');
        }

        // Todos laden
        $todos = TodoListModel::getAllTodos();

        $this->View->render('todolist/index', [
            'todos' => $todos
        ]);
    }

    public function delete($id)
    {
        TodoListModel::deleteTodo($id);
        Session::add('feedback_positive', 'Todo gelöscht');
        Redirect::to('todolist/index');
    }
    public function update($id)
    {
        TodoListModel::updateTodo($id);
        Session::add('feedback_positive', 'Todo geändert');
        Redirect::to('todolist/index');
    }
        public function read($id)
    {
        TodoListModel::readTodo($id);
        Session::add('feedback_positive', 'Todo lesen');
        Redirect::to('todolist/index');
    }
}
