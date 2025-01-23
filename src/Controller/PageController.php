<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PageController extends AbstractController
{
    #[Route('/posts', name: 'app_posts', methods: ['GET'])] // Method get pour seulement récupérer les informations
    public function posts(PostRepository $pr, PaginatorInterface $paginator, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $pr->findAll(), /* query NOT result */
            $request->query->getInt('page', 1), /* page number */
            10 /* limit per page */
        );

        $posts = $pr->findAll();
        return $this->render('page/posts.html.twig', [
            'posts' => $pagination,
            'pagination' => $pagination
        ]);
    }

    #[Route('/post/{id}', name: 'app_post_id', methods: ['GET'])] // Method get pour seulement récupérer les informations
    public function postsId(PostRepository $pr, string $id): Response
    {

        $post = $pr->findOneBy(['id' => $id]);
        return $this->render('page/post.html.twig', [
            'post' => $post,

        ]);
    }
}