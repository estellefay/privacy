<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\CategoryRepository;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig', [
            'controller_name' => 'CategoryController',
        ]);
    }

     /**
     * @Route("/category/1", name="create_category")
     */
    public function createCategory(): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $category = new Category();
        $category->setName("test");
        $entityManager->persist($category);
        $entityManager->flush();


        return new Response('Saved new category with id '.$category->getId());
    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show($id)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        return new Response('Check out this great category: '.$category->getName());

        // or render a template
        // in the template, print things with {{ category.name }}
        // return $this->render('category/show.html.twig', ['category' => $category]);
    }

    /**
     * @Route("/category/edit/{id}")
     */
    public function update($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        $category->setName('New category name!');
        $entityManager->flush();

        return $this->redirectToRoute('category_show', [
            'id' => $category->getId()
        ]);
    }

    /**
     * @Route("/category/delete/{id}")
     */
    public function delete($id)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);

        if (!$category) {
            throw $this->createNotFoundException(
                'No category found for id '.$id
            );
        }

        $entityManager->remove($category);
        $entityManager->flush();

        return new Response('Supression reussi');

    }
}
