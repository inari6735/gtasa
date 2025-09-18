<?php declare(strict_types=1);

namespace App\Media\Service\Handler;

use App\Media\Model\DTO\MediaInput;
use App\Media\Service\Uploader;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

readonly class MediaUploadHandler
{
    public function __construct(
        private Uploader $uploader,
    ) {}

    public function handle(FormInterface $form, Request $request, MediaInput $input): bool
    {
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$input->file instanceof UploadedFile) {
                return false;
            }

            $this->uploader->upload($input->file, $input->visibility);
        }

        return true;
    }
}
