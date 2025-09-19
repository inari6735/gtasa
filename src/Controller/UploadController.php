<?php declare(strict_types=1);

namespace App\Controller;

use App\Media\Service\Handler\UploadHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UploadController extends AbstractController
{
    public function __construct(private readonly UploadHandler $handler)
    {}
    #[Route('/upload', name: 'app_upload')]
    public function upload(): Response
    {
        return $this->render('media/upload.html.twig');
    }

    #[Route('/upload/fingerprint', name: 'app_upload_fingerprint', methods: ['POST'])]
    public function fingerprint(Request $request): Response
    {
        $fingerprint = $this->handler->handleFingerprint($request);

        return $this->json(['fingerprint' => $fingerprint]);
    }

    #[Route('/upload/init', name: 'app_upload_init', methods: ['POST'])]
    public function init(Request $request): Response
    {
        $response = $this->handler->handleInit($request);

        return $this->json($response);
    }

    #[Route('/upload/chunk', name: 'app_upload_chunk', methods: ['POST'])]
    public function chunk(Request $request): Response
    {
        $success = $this->handler->handleChunk($request);

        return $this->json(['success' => $success]);
    }

    #[Route('/upload/complete', name: 'app_upload_complete', methods: ['POST'])]
    public function complete(Request $request): Response
    {
        $response = $this->handler->handleAssemble($request);

        return $this->json($response);
    }
}
