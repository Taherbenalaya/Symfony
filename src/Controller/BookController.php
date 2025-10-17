<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/book')]
class BookController extends AbstractController
{
    #[Route('/list', name: 'app_book_list', methods: ['GET'])]
    public function list(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        return $this->render('book/list.html.twig', [
            'books' => $books,
        ]);
    }

    #[Route('/details/{id}', name: 'app_book_details', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function details(int $id, BookRepository $bookRepository): Response
    {
        $book = $bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('Livre introuvable.');
        }

        return $this->render('book/details.html.twig', [
            'book' => $book,
        ]);
    }

    #[Route('/create', name: 'app_book_create', methods: ['GET','POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($book);
            $em->flush();

            return $this->redirectToRoute('app_book_list');
        }

        return $this->render('book/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Créer un livre',
        ]);
    }

    #[Route('/edit/{id}', name: 'app_book_edit', requirements: ['id' => '\d+'], methods: ['GET','POST'])]
    public function edit(int $id, Request $request, BookRepository $bookRepository, EntityManagerInterface $em): Response
    {
        $book = $bookRepository->find($id);
        if (!$book) {
            throw $this->createNotFoundException('Livre introuvable.');
        }

        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('app_book_list');
        }

        return $this->render('book/form.html.twig', [
            'form' => $form->createView(),
            'title' => 'Modifier le livre',
        ]);
    }

    #[Route('/delete/{id}', name: 'app_book_delete', requirements: ['id' => '\d+'], methods: ['POST','GET'])]
    public function delete(int $id, BookRepository $bookRepository, EntityManagerInterface $em): Response
    {
        $book = $bookRepository->find($id);
        if ($book) {
            $em->remove($book);
            $em->flush();
        }

        return $this->redirectToRoute('app_book_list');
    }
}