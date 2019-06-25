<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index()
    {
        //prueba de Entidades y Relaciones
        //prueba de Entidades y Relaciones
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findAll();

        foreach ($tasks as $task){
            echo $task->getUser()->getEmail().': '.$task->getTitle()."<br>";

        }

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}
