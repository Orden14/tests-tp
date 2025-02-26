<?php

namespace tests\exo1;

use Boumilmounir\TestUnitaire\TaskManager;
use OutOfBoundsException;
use PHPUnit\Framework\TestCase;

final class TaskManagerTest extends TestCase
{
    private TaskManager $taskManager;

    protected function setUp(): void
    {
        $this->taskManager = new TaskManager();
    }

    public function testAddTask(): void
    {
        $this->taskManager->addTask("Faire les courses");
        $tasks = $this->taskManager->getTasks();

        $this->assertCount(1, $tasks);
        $this->assertEquals("Faire les courses", $tasks[0]);
    }

    public function testRemoveTask(): void
    {
        $this->taskManager->addTask("Tâche 1");
        $this->taskManager->addTask("Tâche 2");
        $this->taskManager->removeTask(0);

        $tasks = $this->taskManager->getTasks();
        $this->assertCount(1, $tasks);
        $this->assertEquals("Tâche 2", $tasks[0]);
    }

    public function testGetTasks(): void
    {
        $this->taskManager->addTask("Tâche 1");
        $this->taskManager->addTask("Tâche 2");

        $tasks = $this->taskManager->getTasks();
        $this->assertCount(2, $tasks);
        $this->assertEquals(["Tâche 1", "Tâche 2"], $tasks);
    }

    public function testGetTask(): void
    {
        $this->taskManager->addTask("Tâche 1");
        $this->taskManager->addTask("Tâche 2");

        $task = $this->taskManager->getTask(1);
        $this->assertEquals("Tâche 2", $task);
    }

    public function testRemoveInvalidIndexThrowsException(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage("Index de tâche invalide: 0");

        $this->taskManager->removeTask(0);
    }

    public function testGetInvalidIndexThrowsException(): void
    {
        $this->expectException(OutOfBoundsException::class);
        $this->expectExceptionMessage("Index de tâche invalide: 99");

        $this->taskManager->getTask(99);
    }

    public function testTaskOrderAfterRemoval(): void
    {
        $this->taskManager->addTask("Tâche 1");
        $this->taskManager->addTask("Tâche 2");
        $this->taskManager->addTask("Tâche 3");

        $this->taskManager->removeTask(1);

        $tasks = $this->taskManager->getTasks();
        $this->assertCount(2, $tasks);
        $this->assertEquals(["Tâche 1", "Tâche 3"], $tasks);
        $this->assertEquals("Tâche 3", $this->taskManager->getTask(1));
    }
}
