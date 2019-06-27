<?php

namespace App\Controller;

use App\Entity\Task;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TaskController extends AbstractController
{
    /**
     * @Route("/task", name="task")
     */
    public function index()
    {
        //prueba de Entidades y Relaciones
        $em = $this->getDoctrine()->getManager();
        $task_repo = $this->getDoctrine()->getRepository(Task::class);
        $tasks = $task_repo->findBy([], ['id' => 'DESC']);
        /*
        foreach ($tasks as $task) {
           echo $task->getUser()->getEmail() . ': ' . $task->getTitle() . "<br>";

        }        */

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
            'task' => $tasks
        ]);
    }

    /**
     *
     * @Route("detail/{id}", name="task_detail"))
     */
    public function details(Task $task)
    {
        if (!$task) {

            return $this->redirectToRoute('task');
        } else {

            return $this->render('task/detail.html.twig', [
                'task' => $task
            ]);

        }
    }
    /**
     * @Route("tarea/new", name="tarea_new")
     */
    public function createTarea(Request $request){

        return $this->render('task/creation.html.twig');

    }


}
