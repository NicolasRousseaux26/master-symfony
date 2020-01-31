<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage(ProductRepository $productRepository)
    {

        $products = $productRepository ->findAllGreatherThanPrice(700);
        $favoriteProduct = $productRepository->findOneGreaterThanPrice(800);



        /*$product = new Product();
        $product->setName("iPhone");
        $product->setDescription("Mon produit");
        $product->setPrice(999);
        $entityManager = $this->getDoctrine()->getManager();
        //persist est le fait d'inserer/modiffier dans la pabase
        $entityManager->persist($product);
        // flush execute la requete
        // $entityManager->flush();
        */
        return $this->render('index/homepage.html.twig', [
            'products' => $products,
            'favorite_product' => $favoriteProduct,
        ]);
    }
}