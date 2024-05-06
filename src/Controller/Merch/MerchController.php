<?php

namespace App\Controller\Merch;

use App\Repository\CoursRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MerchController extends AbstractController
{
    
    public function index(Request $request , ProductsRepository $productsRepository): Response
    {
      
        $products = $productsRepository->findAll();
 
        return $this->render('home/merch/filter/index.html.twig', [
            'products'=>$products
        ]);
    }

    public function productPage($id, ProductsRepository $productsRepository): Response
    {
    
        $product = $productsRepository->find($id);
 
        return $this->render('home/merch/single/index.html.twig', [
            'product'=>$product
        ]);
    }
    

}
