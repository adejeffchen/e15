<?php
class Student
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $id;
    }
}

$student = new Student(99);
$id = $student->getId();
echo $id;