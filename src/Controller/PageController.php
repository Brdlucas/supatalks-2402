<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PageController extends AbstractController
{
    #[Route('/posts', name: 'app_post', methods: ['GET'])] // Method get pour seulement récupérer les informations
    public function posts(PostRepository $pr): Response
    {

        $posts = $pr->findAll();
        return $this->render('page/posts.html.twig', [
            'posts' => $posts,
            5
        ]);
    }
}
