<?php

namespace App\Controller\Categorie;

use App\Repository\CategorieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    public function index(CategorieRepository $rep): Response
    {
        $categories = $this->findAllCategories($rep);
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    public function addCategorie(): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    public function deleteCategorie(): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    public function updateCategorie(): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    public function single(): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }
    public function categoriePage($slug): Response
    {
        return $this->render('admin/categorie/index.html.twig', [
            'controller_name' => 'CategorieController',
        ]);
    }

    public function sousCategoriePage(): Response
    {

        return $this->render('admin/categorie/index.html.twig', []);
    }

    public function findAllCategories(CategorieRepository $rep)
    {

        return $rep->findAllCategories();
    }
}
