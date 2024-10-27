<?php
// Define a class named Task
class Task {
    public $title;
    public $description;
    public $dueDate;
    private $status; // Private property to store task status

    // Constructor method to initialize properties
    public function __construct($title, $description, $dueDate) {
        $this->title = $title;
        $this->description = $description;
        $this->dueDate = $dueDate;
        $this->status = 'Pending'; // Default status
    }

    // Method to mark the task as completed
    public function markAsCompleted() {
        $this->status = 'Completed';
    }

    // Method to display task details
    public function getTaskDetails() {
        return "Title: " . $this->title . "<br>" .
               "Description: " . $this->description . "<br>" .
               "Due Date: " . $this->dueDate . "<br>" .
               "Status: " . $this->status;
    }
}

// Create an instance of the Task class
$task = new Task("Complete PHP Project", "Finish the OOP examples", "2024-09-30");

// Display the task details
echo $task->getTaskDetails() . "<br>";

// Mark the task as completed
$task->markAsCompleted();

// Display the updated task details
echo $task->getTaskDetails();
?>
