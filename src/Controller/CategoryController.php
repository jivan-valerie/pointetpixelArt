<?php

namespace App\Controller;
use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;


class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index(CategoryRepository $categoryRepository, Request $request, EntityManagerInterface $manager): Response
    {
        $category = new Category();
        $form=$this->createForm(CategoryType::class,$category);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($category);
            $manager->flush();
            return $this->redirectToRoute('category');
        }
    
    $liste_category=$categoryRepository->findAll();
        
        return $this->render('category/category.html.twig', [
            'liste_category' => $liste_category,
            'form'=>$form->createView(),
        ]);
    }
    

}