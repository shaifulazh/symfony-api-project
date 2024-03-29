<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Repository\NoteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Note;

class NoteController extends AbstractFOSRestController
{
    private $noteRepository;
    private $entityManager;

    public function __construct(NoteRepository $noteRepository, EntityManagerInterface $entityManager)
    {
        $this->noteRepository = $noteRepository;
        $this->entityManager = $entityManager;
    }

    public function getNoteAction(Note $note)
    {
        return $this->view($note, Response::HTTP_OK);
    }

    public function deleteNoteAction(Note $note)
    {

        if ($note) {
            $this->entityManager->remove($note);
            $this->entityManager->flush();

            return $this->view(null, Response::HTTP_NO_CONTENT);
        }

        return $this->view(['messagge ' => 'something went wrong'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
