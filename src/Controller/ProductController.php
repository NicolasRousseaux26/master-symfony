<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
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

    /**
    * @Route("/product/all", name="product_list")
    */

    public function list()
    {
        // on recupére le depot qui contient nos produit
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        // SELECT * FROM product
        $product = $productRepository->findAll();

        if (!$product) {
        	throw $this->createNotFoundException('Il n\'y a pas de produit enregistré');
        }

        return $this->render('product/list.html.twig', [
            'products' => $product,
        ]);
    }

    /**
    * @Route("/product/udapte/{id}", name="product_udapte")
    */
    public function udapte(Request $request, Product $product)
    {
        // on crée le formulaire
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_list');

            $this->addFlash('success', 'Le produit a bien été modifier.');

        }

        return $this->render('product/udapte.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/product/delete/{id}", name="product_deleted", methods={"POST"})
     */
    public function deleted(Request $request, Product $product, EntityManagerInterface $entityManager)
    {
        // on verifie la validité du token CSRF On se protége des faille CSRF
        if ($this->isCsrfTokenValid('delete', $request->get('token'))) {
        $entityManager->remove($product);
        $entityManager->flush();
        }

        $this->addFlash('success', 'Le produit a bien été supprimer.');

        return $this->redirectToRoute('product_list');
    }


    /**
    * @Route("/product/{id}", name="product_show")
    */

    public function show($id)
    {
        dump($id);
        // on recupére le depot qui contient nos produit
        $productRepository = $this->getDoctrine()->getRepository(Product::class);
        // SELECT * FROM product WHERE id = $id
        $product = $productRepository->find($id);

        if (!$product) {
        	throw $this->createNotFoundException('Le produit ' . $id . ' n\'existe pas.');
        }

        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    
}
