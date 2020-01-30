<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function homepage()
    {

        $product = new Product();
        $product->setName("iPhone");
        $product->setDescription("Mon produit");
        $product->setPrice(999);
        $entityManager = $this->getDoctrine()->getManager();
        //persist est le fait d'inserer/modiffier dans la pabase
        $entityManager->persist($product);
        // flush execute la requete
        // $entityManager->flush();

        return $this->render('index/homepage.html.twig');
    }
}