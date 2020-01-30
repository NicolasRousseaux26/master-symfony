<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product_create")
     */
    public function create(Request $request)
    {
        $product = new Product();
        // on crée un formulaire avec 2 paramétre la class et l'objet a la db
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Ajoute le produit
            $entityManager = $this->getDoctrine()->getManager();

            // On demande à Doctrine de mettre l'objet en attente
            $entityManager->persist($product);

            // Exécute la(es) requête(s) (INSERT...)
            $entityManager->flush();
            
            $this->addFlash('success', 'Le produit a bien été ajouté.');
        }
        
        return $this->render('product/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
