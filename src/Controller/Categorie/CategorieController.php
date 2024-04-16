<?php

namespace App\Controller\Categorie;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Categorie;
use App\Form\CategoryType;
use App\Entity\Souscategorie;
use App\Form\SousCategorieType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;



class CategorieController extends AbstractController
{

    public function category(EntityManagerInterface $entityManager): Response
    {
        $categoryRepository = $entityManager->getRepository(Categorie::class);
        $categories = $categoryRepository->findAll();
        return $this->render('admin/classification/category/index.html.twig',[
            'categories' => $categories,
        ]);
    }

    /*public function category_create(): Response
    {
        return $this->render('admin/classification/category/create.html.twig');
    }*/

    public function category_create(Request $request): Response
    {
        $category = new Categorie();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            return $this->category($entityManager);
        }
        return $this->render('admin/Categorie/category/create.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/category/{id}/edit", name="category_edit", methods={"GET", "POST"})
     */

    public function category_edit(Request $request, $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository(Categorie::class)->find($id);
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->category($entityManager);
        }
        return $this->render('admin/Categorie/category/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("admin/Category/{id}/delete", name="category_delete", methods={"GET"})
     */
    public function Category_delete(Request $request,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $subcategory = $entityManager->getRepository(Categorie::class)->find($id);
        $entityManager->remove($subcategory);
        $entityManager->flush();
        $this->getDoctrine()->getManager()->flush();
        return $this->category($entityManager);
    }


    public function subcategory(EntityManagerInterface $entityManager): Response
    {
        $SouscategorieRepository = $entityManager->getRepository(Souscategorie::class);
        $Souscategorie = $SouscategorieRepository->findAll();
        return $this->render('admin/Categorie/subcategory/index.html.twig',[
            'Souscategorie' => $Souscategorie,
        ]);
    }
    public function subcategory_create(Request $request): Response
    {
        $subcategory = new Souscategorie();
        $form = $this->createForm(SousCategorieType::class, $subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Handle category selection
            $selectedCategory = $form->get('categorieid')->getData();
            // Do something with the selected category
            $categorie = $subcategory->getCategorieid();
            // Increment nbsouscategorie
            $categorie->setNbsouscategorie($categorie->getNbsouscategorie() + 1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($subcategory);
            $entityManager->flush();
            return $this->subcategory($entityManager);
        }

        return $this->render('admin/Categorie/subcategory/create.html.twig', [
            'subcategory' => $subcategory,
            'form' => $form->createView(),
        ]);
        return $this->render('admin/Categorie/subcategory/create.html.twig');
    }
    /**
     * @Route("/subCategory/{id}/edit", name="subcategory_edit", methods={"GET", "POST"})
     */
    public function subcategory_edit(Request $request,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $subcategory = $entityManager->getRepository(Souscategorie::class)->find($id);
        $form = $this->createForm(SousCategorieType::class, $subcategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            return $this->subcategory($entityManager);
        }

        return $this->render('admin/Categorie/subcategory/create.html.twig', [
            'subcategory' => $subcategory,
            'form' => $form->createView(),
        ]);
        return $this->render('admin/Categorie/subcategory/create.html.twig');
    }

    /**
     * @Route("/admin/subCategory/{id}/delete", name="subcategory_delete", methods={"GET"})
     */
    public function subcategory_delete(Request $request,$id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $subcategory = $entityManager->getRepository(Souscategorie::class)->find($id);
        $categorie = $subcategory->getCategorieid();
        // Increment nbsouscategorie
        $categorie->setNbsouscategorie($categorie->getNbsouscategorie() - 1);
        $entityManager->remove($subcategory);
        $entityManager->flush();
        $this->getDoctrine()->getManager()->flush();
        return $this->subcategory($entityManager);
    }
}
