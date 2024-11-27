<?php
namespace App\Controller;

use App\Entity\Contact;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactlistController extends AbstractController
{
#[Route('/contactlist', name: 'contactlist')]
public function index(EntityManagerInterface $em): Response
{
$contacts = $em->getRepository(Contact::class)->findAll();
return $this->render('admin/contactlist.html.twig', [
'contacts' => $contacts,
]);
}

#[Route('/delete_contacts', name: 'delete_contacts', methods: ['POST'])]
public function deleteSelectedContacts(Request $request, EntityManagerInterface $em): Response
{
$selectedContacts = $request->request->get('selected_contacts');

if (is_array($selectedContacts) && !empty($selectedContacts)) {
// Filtrer les valeurs pour s'assurer qu'elles sont scalaires
$selectedContacts = array_filter($selectedContacts, function ($value) {
return is_scalar($value);
});

// Convertir en entiers
$selectedContacts = array_map('intval', $selectedContacts);

// Vérifier si le tableau est non vide après le filtrage
if (!empty($selectedContacts)) {
// Récupérer les contacts à supprimer
$contactsToDelete = $em->getRepository(Contact::class)->findBy(['id' => $selectedContacts]);

foreach ($contactsToDelete as $contact) {
$em->remove($contact);
}

$em->flush();

$this->addFlash('success', 'Contacts sélectionnés supprimés avec succès.');
} else {
$this->addFlash('warning', 'Aucun contact valide sélectionné.');
}
} else {
$this->addFlash('warning', 'Aucun contact sélectionné pour la suppression.');
}

return $this->redirectToRoute('contactlist');
}
}
