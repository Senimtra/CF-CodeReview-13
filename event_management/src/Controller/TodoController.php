<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TodoController extends AbstractController
{
    #[Route('/', name: 'todo')]
    public function index(): Response
    {
        return $this->render('todo/index.html.twig');
    }
    #[Route('/create', name: 'todo_create')]
    public function create(): Response
    {
        return $this->render('todo/create.html.twig');
    }
    #[Route('/edit/{id}', name: 'todo_edit')]
    public function edit(): Response
    {
        return $this->render('todo/edit.html.twig');
    }
    #[Route('/details/{id}', name: 'todo_details')]
    public function details($id): Response
    {
        return $this->render('todo/details.html.twig');
    }
}
