<?php

namespace App\Controller;

use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\Constraints\DateTime;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function register(Request $request, UserPasswordEncoderInterface $encoder)
    {
        //Creando el Formulario
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        //Rellernar el Objeto con los Datos del Formulario
        $form->handleRequest($request);

        //Verificando si los Datos fueron fueron enviados
        if ($form->isSubmitted()) {

            //Modificando el objeto para guardarlo
            $user->setRole('ROLE_USER');
           // $date = (new \DateTime())->format('d-m-Y H:i:s');
            //$user->setCreatedAt($date);

            $user->setCreatedAt(new \DateTime());

            //Encriptando la Contraseña
            $encoded = $encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($encoded);

            //Guardar Usuario
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('task');

        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
