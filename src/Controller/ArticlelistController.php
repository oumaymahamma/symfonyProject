<?php
namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class ArticlelistController extends AbstractController
{
#[Route('/articlelist', name: 'articlelist')]
public function index(EntityManagerInterface $em): Response
{
// Fetch all articles from the database
$articles = $em->getRepository(Article::class)->findAll();

return $this->render('admin/productlist.html.twig', [
'articles' => $articles,  // Pass articles to the template
]);
}

#[Route('/article/delete/{id}', name: 'article_delete')]
public function delete($id, EntityManagerInterface $em): Response
{
// Find the article by ID
$article = $em->getRepository(Article::class)->find($id);

if ($article) {
// Remove the article from the database
$em->remove($article);
$em->flush();

// Add a flash message to confirm deletion
$this->addFlash('success', 'Article deleted successfully!');
} else {
$this->addFlash('danger', 'Article not found!');
}

return $this->redirectToRoute('articlelist');
}

#[Route('/article/update/{id}', name: 'article_update')]
public function update($id, Request $request, EntityManagerInterface $em): Response
{
// Fetch the article by its ID
$article = $em->getRepository(Article::class)->find($id);

if (!$article) {
// If the article is not found, redirect back to the list with an error message
$this->addFlash('danger', 'Article not found!');
return $this->redirectToRoute('articlelist');
}

// Create the form for updating the article
$form = $this->createForm(ArticleType::class, $article);

// Handle the form submission
$form->handleRequest($request);

if ($form->isSubmitted() && $form->isValid()) {
// Handle photo upload if a new photo is provided
$photo = $form->get('photo')->getData();
if ($photo) {
// Remove the old photo if it exists (optional)
if ($article->getPhoto()) {
$oldPhotoPath = $this->getParameter('photos_directory') . '/' . $article->getPhoto();
if (file_exists($oldPhotoPath)) {
unlink($oldPhotoPath);  // Delete the old photo
}
}

// Save the new photo
$photoName = uniqid() . '.' . $photo->guessExtension();

try {
// Move the uploaded file to the designated folder
$photo->move($this->getParameter('photos_directory'), $photoName);
$article->setPhoto($photoName);
} catch (FileException $e) {
// Handle errors that occur during file upload
$this->addFlash('danger', 'Error uploading the photo!');
return $this->redirectToRoute('article_update', ['id' => $article->getId()]);
}
}

// Persist the updated article
$em->flush();

// Add a success flash message
$this->addFlash('success', 'Article updated successfully!');

// Redirect to the article list page
return $this->redirectToRoute('articlelist');
}

// Render the update form
return $this->render('admin/article_update.html.twig', [
'form' => $form->createView(),
'article' => $article,
]);
}
}
