<?php

namespace App\Controller;

// ### Add Classes to handle the create inputs ###

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

// ### ChoiceType not yet used in the project ###
// use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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

        $todos = $this->getDoctrine()->getRepository('App:Todo')->findAll('type');
        // $todos = $this->getDoctrine()->getRepository('App:Todo')->findBy(array(), array('type' => 'DESC'));
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
            ->add('price', IntegerType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
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
            $price = $form['price']->getData();

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
            $todo->setPrice($price);

            // ### Preparing the database query ###

            $em = $this->getDoctrine()->getManager();
            $em->persist($todo);

            // ### Performing the database query ###

            $em->flush();

            // ### Print notice ###

            $this->addFlash(
                'notice',
                'Event Added'
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
    public function edit(Request $request, $id): Response
    {
        // ### Find the requested record by given id ###

        $todo = $this->getDoctrine()->getRepository('App:Todo')->find($id);

        // ### Setting the record values that already exist ###

        $todo->setName($todo->getName());
        $todo->setImage($todo->getImage());
        $todo->setDescription($todo->getDescription());
        $todo->setCapacity($todo->getCapacity());
        $todo->setDate($todo->getDate());
        $todo->setEmail($todo->getEmail());
        $todo->setPhone($todo->getPhone());
        $todo->setAddress($todo->getAddress());
        $todo->setUrl($todo->getUrl());
        $todo->setType($todo->getType());
        $todo->setPrice($todo->getPrice());

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
            ->add('price', IntegerType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Update Todo', 'attr' => array('class' => 'btn-primary', 'style' => 'margin-botton:15px')))
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
            $price = $form['price']->getData();

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
            $todo->setPrice($price);

            // ### Preparing the database query ###

            $em = $this->getDoctrine()->getManager();
            $todo = $em->getRepository('App:Todo')->find($id);

            // ### Performing the database query ###

            $em->flush();

            // ### Print notice ###

            $this->addFlash(
                'notice',
                'Event Updated'
            );

            // ### Redirect to Home (index) ###

            return $this->redirectToRoute('todo');
        }

        // ### Rendering the form in the view (edit.html.twig) ###

        return $this->render('todo/edit.html.twig', array('todo' => $todo, 'form' => $form->createView()));
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

    ##############################
    ## Route -> Delete (delete) ##
    ##############################

    #[Route('/delete/{id}', name: 'todo_delete')]
    public function delete($id)
    {

        // ### Find the record in the database ###

        $em = $this->getDoctrine()->getManager();
        $todo = $em->getRepository('App:Todo')->find($id);

        // ### Remove the record from the Entity ###

        $em->remove($todo);

        // ### Perform the database query ###

        $em->flush();

        // ### Print notice ###

        $this->addFlash(
            'notice',
            'Event Removed'
        );

        // ### Redirect to Home (index) ###

        return $this->redirectToRoute('todo');
    }

    #############################
    ## Route -> Movies (index) ##
    #############################

    #[Route('/movies', name: 'todo_movies')]
    public function movies(): Response
    {
        // ### fetch all records from the database (type = "movie") ###

        $todos = $this->getDoctrine()->getRepository('App:Todo')->findBy(array('type' => 'movie'));
        return $this->render('todo/index.html.twig', array('todos' => $todos));
    }

    #############################
    ## Route -> Sports (index) ##
    #############################

    #[Route('/sports', name: 'todo_sports')]
    public function sports(): Response
    {
        // ### fetch all records from the database (type = "sport") ###

        $todos = $this->getDoctrine()->getRepository('App:Todo')->findBy(array('type' => 'sport'));
        return $this->render('todo/index.html.twig', array('todos' => $todos));
    }
    ############################
    ## Route -> Music (index) ##
    ############################

    #[Route('/music', name: 'todo_music')]
    public function music(): Response
    {
        // ### fetch all records from the database (type = "music") ###

        $todos = $this->getDoctrine()->getRepository('App:Todo')->findBy(array('type' => 'music'));
        return $this->render('todo/index.html.twig', array('todos' => $todos));
    }
    ############################
    ## Route -> Shows (index) ##
    ############################

    #[Route('/shows', name: 'todo_shows')]
    public function shows(): Response
    {
        // ### fetch all records from the database (type = "show") ###

        $todos = $this->getDoctrine()->getRepository('App:Todo')->findBy(array('type' => 'show'));
        return $this->render('todo/index.html.twig', array('todos' => $todos));
    }
}
