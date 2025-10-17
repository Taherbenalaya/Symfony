<?php

namespace App\Controller;

use App\Entity\UsineTaherBenAlaya;
use App\Form\AddEditUsineTaherBenAlayaType;
use App\Repository\UsineTaherBenAlayaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class UsineTaherBenAlayaController extends AbstractController
{
    public $items = array(
        array('id' => 1, 'nom' => 'Dupont', 'prenom' => 'Jean', 'email' => 'jean.dupont@example.com'),
        array('id' => 2, 'nom' => 'Martin', 'prenom' => 'Marie', 'email' => 'marie.martin@example.com'),
        array('id' => 3, 'nom' => 'Durand', 'prenom' => 'Paul', 'email' => 'paul.durand@example.com'),
    );

    #[Route('/usine', name: 'app_usine')]
    public function index(): Response
    {
        return $this->render('usine_taher_ben_alaya/index.html.twig', [
            'controller_name' => 'UsineTaherBenAlayaController',
        ]);
    }

    #[Route('/usine/list', name:'app_usine_list')]
    public function list(UsineTaherBenAlayaRepository $repo): Response
    {
        $items = $repo->findAll();
        return $this->render('usine_taher_ben_alaya/list.html.twig', [
            'items' => $items,
        ]);
    }

    #[Route('/usine/details/{id}', name:'app_usine_details')]
    public function details($id, UsineTaherBenAlayaRepository $repo): Response
    {
        $item = $repo->find($id);
        return $this->render('usine_taher_ben_alaya/details.html.twig',[
            'title' => 'Détails',
            'item' => $item,
        ]);
    }

    #[Route('/usine/search/{term}', name:'app_usine_search')]
    public function search($term, UsineTaherBenAlayaRepository $repo): Response
    {
        $item = $repo->findOneBy(['nom' => $term]);
        return $this->render('usine_taher_ben_alaya/details.html.twig',[
            'title'=> 'Search Result',
            'item' => $item,
        ]);
    }

    #[Route('/usine/add', name:'app_usine_add')]
    public function add(EntityManagerInterface $em): Response
    {
        $item = new UsineTaherBenAlaya();
        if (method_exists($item, 'setNom')) $item->setNom('Exemple');
        if (method_exists($item, 'setPrenom')) $item->setPrenom('Test');
        if (method_exists($item, 'setEmail')) $item->setEmail('exemple@test.local');

        $em->persist($item);
        $em->flush();
        dd($item);
    }

    #[Route('/usine/create', name:'app_usine_create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $item = new UsineTaherBenAlaya();
        $form = $this->createForm(AddEditUsineTaherBenAlayaType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $em->persist($item);
           $em->flush();
           return $this->redirectToRoute('app_usine_list');
        }

        return $this->render('usine_taher_ben_alaya/form.html.twig', [
            'title'=> 'Create',
            'form' => $form->createView()
        ]);
    }

    #[Route('/usine/update/{id}', name:'app_usine_update')]
    public function update($id, Request $request, EntityManagerInterface $em, UsineTaherBenAlayaRepository $repo): Response
    {
        $item = $repo->find($id);
        $form = $this->createForm(AddEditUsineTaherBenAlayaType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $em->flush();
           return $this->redirectToRoute('app_usine_list');
        }

        return $this->render('usine_taher_ben_alaya/form.html.twig', [
            'title'=> 'Update',
            'form' => $form->createView()
        ]);
    }

    #[Route('/usine/edit/{id}', name:'app_usine_edit')]
    public function edit($id, EntityManagerInterface $em, UsineTaherBenAlayaRepository $repo): Response
    {
        $item = $repo->find($id);
        if ($item && method_exists($item, 'setNom')) $item->setNom('Modifié');
        $em->flush();
        dd($item);
    }

    #[Route('/usine/delete/{id}', name:'app_usine_delete')]
    public function delete($id, EntityManagerInterface $em, UsineTaherBenAlayaRepository $repo): Response
    {
        $item = $repo->find($id);
        if ($item) {
            $em->remove($item);
            $em->flush();
        }
        return $this->redirectToRoute('app_usine_list');
    }
}