<?php

declare(strict_types=1);

namespace App\Controller;

use App\Media\Model\DTO\MediaInput;
use App\Media\Service\Form\MediaType;
use App\Media\Service\Handler\UploadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class MediaController extends AbstractController
{
    #[Route('/media', name: 'app_media')]
    public function media(Request $request, UploadHandler $handler): Response
    {
        $input = new MediaInput();
        $form = $this->createForm(MediaType::class, $input);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $handler->handleUpload($request);
        }


        return $this->render('media/media.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
