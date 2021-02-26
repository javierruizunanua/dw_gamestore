<?php

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
use App\Entity\Games;
use \App\Entity\Categories;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("games")
 */
class GamesController extends AbstractController
{
    /**
   * Lists all game entities
   * @Route("/", name="games_index", methods={"GET"} )

   */
  public function indexAction(Request $request) {
      
    $em = $this->getDoctrine()->getManager();
    
    $games = $em->getRepository(Games::class)->findAll();
    $categories = $em->getRepository(Categories::class)->findAll();

    return $this->render('games/index.html.twig', [
      'games' => $games,
      'categories' => $categories,
    ]);
  }
  
  
  
  /**
   * Creates a new game entity.
   * @Route("/new", name="games_new", methods={"GET", "POST"} )
   */
  public function newAction(Request $request) {
    $game = new Games();
    $form = $this->createForm('App\Form\GamesType', $game);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();

      $em->persist($game);
      $em->flush();
      return $this->redirectToRoute('games_show', ['id' => $game->getId()]);
    }
    return $this->render('games/new.html.twig', [
      'game' => $game,
      'form' => $form->createView(),
    ]);
  }
  
  
  
  /**
   * Finds and displays a game entity.
   * @Route("/{id}", name="games_show", methods={"GET"} )
   */
  public function showAction(Request $request, $id) {
    $game = $this->getDoctrine()->getManager()->getRepository(Games::class)->find($id);
    $categories = $this->getDoctrine()->getManager()->getRepository(Categories::class)->findAll();
    
    $deleteForm = $this->createDeleteForm($game);

    return $this->render('games/show.html.twig', [
      'game' => $game,
      'categories' => $categories,
      'delete_form' => $deleteForm->createView(),
    ]);
  }
  
  
  
  /**
   * Displays a form to edit an existing game entity.
   * @Route("/{id}/edit", name="games_edit", methods={"GET", "POST"} )
   */
  public function editAction(Request $request, Games $game) {
    $deleteForm = $this->createDeleteForm($game);

    $editForm = $this->createForm('App\Form\GamesType', $game);
    $editForm->handleRequest($request);

    if ($editForm->isSubmitted() && $editForm->isValid()) {

      $this->getDoctrine()->getManager()->flush();
      return $this->redirectToRoute('games_show', ['id' => $game->getId()]);
    }

    return $this->render('games/edit.html.twig', [
      'game' => $game,
      'edit_form' => $editForm->createView(),
      'delete_form' => $deleteForm->createView(),
    ]);
  }
  
  
  
  /**
   * Deletes a game entity.
   * @Route("/{id}/delete", name="games_delete", methods={"DELETE"} )
   */
  public function deleteAction(Request $request, Games $game) {
    $form = $this->createDeleteForm($game);
    $form->handleRequest($request);

    if ($form->isSubmitted() && $form->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($game);
      $em->flush();
    }
    return $this->redirectToRoute('games_index');
  }
  
  
  /**
   * Creates a form to delete a game entity.
   * @param Games $game The game entity
   * @return Form The form
   */
  private function createDeleteForm(Games $game) {
    return $this->createFormBuilder()
      ->setAction($this->generateUrl('games_delete', ['id' => $game->getId()]))
      ->setMethod('DELETE')
      ->getForm();
  }
  
  
  
}
