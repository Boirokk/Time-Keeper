<?php

function get_row($id)
{
    $db = Database::getDb();

    $query = "SELECT * FROM start INNER JOIN stop ON start.start_id=stop.start_id WHERE start.start_id=:id";
    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $time = $statement->fetch();
    $statement->closeCursor();
    return $time;
}

function get_start_id()
{
    $db = Database::getDb();

    $query = "SELECT * FROM start ORDER BY start_id DESC LIMIT 1";
    $statement = $db->prepare($query);
    $statement->execute();
    $start_id = $statement->fetch();
    $statement->closeCursor();
    return $start_id;
}

function start_time($initials, $part_number, $description, $dept_code, $task, $quantity)
{
    $db = Database::getDB();

    $query = 'INSERT INTO start(initials, part_number, description, dept_code, task, quantity) VALUES(:initials, :part_number, :description, :dept_code, :task, :quantity)';
    $statement = $db->prepare($query);
    $statement->bindValue(':initials', $initials);
    $statement->bindValue(':part_number', $part_number);
    $statement->bindValue(':description', $description);
    $statement->bindValue(':dept_code', $dept_code);
    $statement->bindValue(':task', $task);
    $statement->bindValue(':quantity', $quantity);
    $statement->execute();
    $statement->closeCursor();
}

function stop_time($start_id)
{
    $db = Database::getDB();

    $query = 'INSERT INTO stop(start_id) VALUES(:start_id)';
    $statement = $db->prepare($query);
    $statement->bindValue(':start_id', $start_id);
    $statement->execute();
    $statement->closeCursor();
}

function toggle($initials, $part_number, $description, $dept_code, $task, $quantity, $start_id = null)
{
    if (isset($_POST['submit'])) {
        if (($_SESSION['toggle'] == 'Timer Running') || (!isset($_SESSION['toggle']))) {
            stop_time($start_id['start_id']);
            $_SESSION['toggle'] = 'Timer Stopped';
            return $_SESSION['toggle'];
        } else {
            start_time($initials, $part_number, $description, $dept_code, $task, $quantity);
            $_SESSION['toggle'] = 'Timer Running';
            $_SESSION['initials'] = $initials;
            $_SESSION['part_number'] = $part_number;
            $_SESSION['description'] = $description;
            $_SESSION['dept_code'] = $dept_code;
            $_SESSION['task'] = $task;
            $_SESSION['quantity'] = $quantity;

            return $_SESSION['toggle'];
        }
    }
}
