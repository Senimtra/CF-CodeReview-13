<?php

namespace App\Controller;

// ### Add Classes to handle the create inputs ###

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

// ### Add IntegerType Component to handle event capacity ###

use Symfony\Component\Form\Extension\Core\Type\IntegerType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

// ### Add Request Component

use Symfony\Component\HttpFoundation\Request;

// ### Add Entity Todo ###

use App\Entity\Todo;

class TodoController extends AbstractController

{
    ###########################
    ## Route -> Home (index) ##
    ###########################

    #[Route('/', name: 'todo')]
    public function index(): Response
    {
        // ### fetch all records from the database ###

        $todos = $this->getDoctrine()->getRepository('App:Todo')->findAll();
        return $this->render('todo/index.html.twig', array('todos' => $todos));
    }

    ##############################
    ## Route -> Create (create) ##
    ##############################

    #[Route('/create', name: 'todo_create')]
    public function create(Request $request): Response
    {

        // ### Creating a new object from Todo ###

        $todo = new Todo;

        // ### Builing the form by using the createFormBuilder-function ###

        $form = $this->createFormBuilder($todo)
            ->add('name', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('image', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('description', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('capacity', IntegerType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('date', DateTimeType::class, array('attr' => array('style' => 'margin-bottom:15px')))
            ->add('email', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('phone', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('address', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('url', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('type', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Create Todo', 'attr' => array('class' => 'btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();
        $form->handleRequest($request);

        // ### Form-submit validation ###

        if ($form->isSubmitted() && $form->isValid()) {

            // ### Getting the data from the inputs ###

            $name = $form['name']->getData();
            $image = $form['image']->getData();
            $description = $form['description']->getData();
            $capacity = $form['capacity']->getData();
            $date = $form['date']->getData();
            $email = $form['email']->getData();
            $phone = $form['phone']->getData();
            $address = $form['address']->getData();
            $url = $form['url']->getData();
            $type = $form['type']->getData();

            // ### Setting the data in the Entity ###

            $todo->setName($name);
            $todo->setImage($image);
            $todo->setDescription($description);
            $todo->setCapacity($capacity);
            $todo->setDate($date);
            $todo->setEmail($email);
            $todo->setPhone($phone);
            $todo->setAddress($address);
            $todo->setUrl($url);
            $todo->setType($type);

            // ### Preparing the database query ###

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);

            // ### Performing the database query ###

            $em->flush();

            // ### Print notice ###

            $this->addFlash(
                'notice',
                'Todo Added'
            );

            // ### Redirect to Home (index) ###

            return $this->redirectToRoute('todo');
        }

        // ### Rendering the form in the view (create.html.twig) ###

        return $this->render('todo/create.html.twig', array('form' => $form->createView()));
    }

    ##########################
    ## Route -> Edit (edit) ##
    ##########################

    #[Route('/edit/{id}', name: 'todo_edit')]
    public function edit(): Response
    {
        return $this->render('todo/edit.html.twig');
    }

    ################################
    ## Route -> Details (details) ##
    ################################

    #[Route('/details/{id}', name: 'todo_details')]
    public function details($id): Response
    {

        // ### Finding the passed id and sending the record as an array ###

        $todo = $this->getDoctrine()->getRepository('App:Todo')->find($id);
        return $this->render('todo/details.html.twig', array('todo' => $todo));
    }
}
