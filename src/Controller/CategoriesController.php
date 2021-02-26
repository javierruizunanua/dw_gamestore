<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("categories")
 */
class CategoriesController extends AbstractController
{
    
    /**
   * Lists all category entities
   * @Route("/", name="categories_index", methods={"GET"} )

   */
    public function indexAction(Request $request) {
      
    $em = $this->getDoctrine()->getManager();
    
    $categories = $em->getRepository(Categories::class)->findAll();

    return $this->render('categories/index.html.twig', [
      'categories' => $categories,
    ]);
  }
  
  
  /**
   * Creates a new category entity.
   * @Route("/new", name="categories_new", methods={"GET", "POST"} )
   */
  public function newAction(Request $request) {
    $category = new Categories();
    $form = $this->createForm('App\Form\CategoriesType', $category);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();

      $em->persist($category);
      $em->flush();
      return $this->redirectToRoute('categories_index', ['id' => $category->getId()]);
    }
    return $this->render('categories/new.html.twig', [
      'category' => $category,
      'form' => $form->createView(),
    ]);
  } 
  
  
  /**
   * Displays a form to edit an existing category entity.
   * @Route("/{id}/edit", name="categories_edit", methods={"GET", "POST"} )
   */
  public function editAction(Request $request, Categories $category) {
    $deleteForm = $this->createDeleteForm($category);

    $editForm = $this->createForm('App\Form\CategoriesType', $category);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {

      $this->getDoctrine()->getManager()->flush();
      return $this->redirectToRoute('categories_index', ['id' => $category->getId()]);
    }

    return $this->render('categories/edit.html.twig', [
      'category' => $category,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ]);
  }
  
  
  
  /**
   * Deletes a category entity.
   * @Route("/{id}/delete", name="categories_delete", methods={"DELETE"} )
   */
  public function deleteAction(Request $request, Categories $category) {
    $form = $this->createDeleteForm($category);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($category);
      $em->flush();
    }
    return $this->redirectToRoute('categories_index');
  }
  
  
  /**
   * Creates a form to delete a category entity.
   * @param Categories $category The category entity
   * @return Form The form
   */
  private function createDeleteForm(Categories $category) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('categories_delete', ['id' => $category->getId()]))
      ->setMethod('DELETE')
      ->getForm();
  }
}
