<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

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
     * @Route("task/new", name="task_new")
     */
    public function createTarea(Request $request, UserInterface $user)
    {
        $task = new Task();
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $task->setCreatedAt(new \DateTime());
            $task->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('task_detail', ['id' => $task->getId()]));

        }
        return $this->render('task/create.html.twig', array(
            'form' => $form->createView()

        ));
    }

    /**
     * @Route("/my_task",name="my_task")
     */
    public function myTasks(UserInterface $user)
    {
        $task = $user->getTasks();

        return $this->render('task/my_task.html.twig', array(
            'task' => $task
        ));


    }

    /**
     *
     * @Route("task/edit/{id}",name="task_edit")
     */
    public function edit(Request $request, UserInterface $user, Task $task)
    {

        if (!$user || $user->getId() != $task->getUser()->getId()) {

            return $this->redirectToRoute('task');
        }
        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //$task->setCreatedAt(new \DateTime());
            // $task->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($task);
            $em->flush();

            return $this->redirect($this->generateUrl('task_detail', ['id' => $task->getId()]));

        }
        return $this->render('task/create.html.twig', array(
            'form' => $form->createView()

        ));

        return $this->render('task/create.html.twig', [
            'edit' => true,
            'form' => $form->createView()
        ]);
    }

    /**
     *
     * @Route("task/delete/{id}",name="task_delete")
     */
public function delete(Task $task, UserInterface $user){
    if (!$user || $user->getId() != $task->getUser()->getId()) {

        return $this->redirectToRoute('task');
    }
    if (!$task) {

        return $this->redirectToRoute('task');
    }
        $em = $this->getDoctrine()->getManager();
        $em->remove($task);
        $em->flush();

    return $this->redirectToRoute('task');

}

}
