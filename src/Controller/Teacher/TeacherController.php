<?php

namespace App\Controller\Teacher;

use App\Entity\Publications;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response; 
use Symfony\Component\HttpFoundation\Request;
use Omines\DataTablesBundle\Column\TextColumn;
use Omines\DataTablesBundle\DataTableFactory;
use Omines\DataTablesBundle\Adapter\ArrayAdapter;
use Omines\DataTablesBundle\Adapter\Doctrine\ORMAdapter;
use Doctrine\ORM\EntityManagerInterface;
class TeacherController extends AbstractController
{

    public function index(): Response
    {
        return $this->render('teacher/dashboard/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }

  

    public function students_page(): Response
    {
        return $this->render('teacher/students/index.html.twig', [
            'controller_name' => 'TeacherController',
        ]);
    }


    public function datatableData(Request $request, DataTableFactory $dataTableFactory, EntityManagerInterface $em)
    {

        $data = [
            [
                'id' => 1,
                'title' => 'tttt',
            ],
            [
                'id' => 2,
                'title' => 'qsfsdfsd',
            ],
  
        ];

        $dataTable = $dataTableFactory->create()
            ->add('id', TextColumn::class, ['label' => 'ID'])
            ->add('title', TextColumn::class, ['label' => 'Title'])
            ->createAdapter(ArrayAdapter::class, ['data' => $data]);
    $dataTable->handleRequest($request);
      
    if ($dataTable->isCallback()) {
        return $dataTable->getResponse();
    }

        return $this->json([
            'data' => [],  
            'recordsFiltered' => 0,  
            'recordsTotal' => 0,  
        ]);
    
    }
 
}
