<?php


namespace App\Controller;

use App\Entity\Author;
use App\Form\AddEditAuthorType;
use App\Repository\AuthorRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class AuthorController extends AbstractController
{
    public $authors = array(
        array('id' => 1, 'picture' => '/images/Victor-Hugo.jpg','username' => 'Victor Hugo', 'email' =>
        'victor.hugo@gmail.com ', 'nb_books' => 100),
        array('id' => 2, 'picture' => '/images/william-shakespeare.jpg','username' => ' William Shakespeare', 'email' =>
        ' william.shakespeare@gmail.com', 'nb_books' => 200 ),
        array('id' => 3, 'picture' => '/images/Taha_Hussein.jpg','username' => 'Taha Hussein', 'email' =>
        'taha.hussein@gmail.com', 'nb_books' => 300),
    );

    #[Route('/author', name: 'app_author')]
    public function index(): Response
    {
        return $this->render('author/index.html.twig', [
            'controller_name' => 'AuthorController',
        ]);
    }

    #[Route('/author/list', name:'app_author_list')]
    public function authorList(AuthorRepository $authorRepository): Response
    {
        $authors = $authorRepository->findAll();
        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }

    #[Route('/author/details/{id}', name:'app_author_details')]
    public function authorDetails($id, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);
        return $this->render('author/details.html.twig',[
            'title' => 'Author Details',
            'author' => $author,
        ]);
    }

    #[Route('/author/search/{username}', name:'app_author_search')]
    public function authorSearch($username, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->findOneByUsername($username);
        return $this->render('author/details.html.twig',[
            'title'=> 'Search Result',
            'author' => $author,
        ]);
    }

    #[Route('/author/add', name:'app_author_add')]
    public function authorAdd(EntityManagerInterface $em): Response
    {
        $author = new Author();
        $author->setUsername('Taha Hussein');
        $author->setEmail('taha.hussein@gmail.com');
        $author->setPicture('/images/Taha_Hussein.jpg');
        $author->setNbBooks(300);
        $em->persist($author);
        $em->flush();
        dd($author);
    }

    #[Route('/author/create', name:'app_author_create')]
    public function authorCreate(Request $request, EntityManagerInterface $em): Response
    {
        $author = new Author();
        $form = $this->createForm(AddEditAuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $em->persist($author);
           $em->flush();
           return $this->redirectToRoute('app_author_list');
        }

        return $this->render('author/form.html.twig', [
            'title'=> 'Create Author',
            'form' => $form->createView()
        ]);
    }

    #[Route('/author/update/{id}', name:'app_author_update')]
    public function updateCreate($id, Request $request, EntityManagerInterface $em, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);
        $form = $this->createForm(AddEditAuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $em->flush();
           return $this->redirectToRoute('app_author_list');
        }

        return $this->render('author/form.html.twig', [
            'title'=> 'Update Author',
            'form' => $form->createView()
        ]);
    }

    #[Route('/author/edit/{id}', name:'app_author_edit')]
    public function authorEdit($id, EntityManagerInterface $em, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);
        $author->setNbBooks(450);
        $em->flush();
        dd($author);
    }

    #[Route('/author/delete/{id}', name:'app_author_delete')]
    public function authorDelete($id, EntityManagerInterface $em, AuthorRepository $authorRepository): Response
    {
        $author = $authorRepository->find($id);
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('app_author_list');
    }
}
