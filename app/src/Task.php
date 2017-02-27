<?php
    class Task
    {
        private $description;
        private $id;
        private $category_id;
        private $date;

        function __construct($description, $id = null, $category_id, $date)
        {
            $this->description = $description;
            $this->id = $id;
            $this->category_id = $category_id;
            $this->date = $date;
        }

        function setDescription($new_description)
        {
            $this->description = (string) $new_description;
        }

        function getDescription()
        {
            return $this->description;
        }

        function getId()
        {
            return $this->id;
        }

        function getCategoryId()
        {
            return $this->category_id;
        }

        function setDate($new_date)
        {
            $this->date = (string) $new_date;
        }

        function getDate()
        {
            return $this->date;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO tasks (description, category_id, date) VALUES ('{$this->getDescription()}', {$this->getCategoryId()}, '{$this->getDate()}')");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_tasks = $GLOBALS['DB']->query("SELECT * FROM tasks;");
            $tasks = array();
            foreach($returned_tasks as $task) {
                $description = $task['description'];
                $id = $task['id'];
                $category_id = $task['category_id'];
                $date = $task['date'];
                $new_task = new Task($description, $id, $category_id, $date);
                array_push($tasks, $new_task);
            }
            return $tasks;
        }

        static function deleteAll()
        {
           $GLOBALS['DB']->exec("DELETE FROM tasks;");
        }

        static function find($search_id)
        {
            $found_task = null;
            $tasks = Task::getAll();
            foreach($tasks as $task) {
                $task_id = $task->getId();
                if ($task_id == $search_id) {
                    $found_task = $task;
                }
            }
            return $found_task;
        }
    }
?>