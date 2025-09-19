<?php declare(strict_types=1);

namespace App\Media\Service\Creator;

use App\Media\Config\FilenameProcessor;
use App\Media\Config\UploadPath;
use App\Media\Model\Enum\MediaVisibility;
use App\Media\Model\ValueObject\Extension;
use App\Media\Model\ValueObject\Filename;
use App\Media\Model\ValueObject\Filesize;
use App\Media\Model\ValueObject\MimeType;
use App\Media\Model\ValueObject\Path;
use App\Media\Model\ValueObject\Url;
use App\Shared\Context;
use App\Shared\Entity\Media;
use App\Shared\Entity\UploadSession;
use App\Shared\Repository\MediaRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

readonly class MediaCreator
{
    public function __construct(
        private MediaEntityBuilder $builder,
        private FilenameProcessor $filenameProcessor,
        private MediaRepository $mediaRepository,
        private Context $context
    ) {}

    public function create(
        UploadedFile $file,
        MediaVisibility $visibility,
    ): Media
    {
        $extension = Extension::create($file->guessExtension());
        $filename = Filename::create(FilenameProcessor::create($extension->value()));
        $safeFilename = $this->filenameProcessor->safeFilename($file->getClientOriginalName());
        $originalFilename = Filename::create($safeFilename);
        $user = $this->context->getUser();
        $path = Path::create(UploadPath::userMediaPath($user->getId(), $filename->value()));
        $mimeType = MimeType::create($file->getMimeType());
        $filesize = Filesize::create($file->getSize());

        $url = Url::create(null);
        if ($visibility === MediaVisibility::PUBLIC) {
            $url = Url::create('http://localhost/uploads');
        }

        $media = $this->builder->build(
            $url,
            $filename,
            $originalFilename,
            $path,
            $mimeType,
            $extension,
            $filesize,
            $visibility,
            $user
        );

        $this->mediaRepository->save($media);

        return $media;
    }

    public function createFromUploadSession(
        UploadSession $uploadSession,
        MediaVisibility $visibility,
    ): Media
    {
        $extension = Extension::create($uploadSession->getExtension());
        $filename = Filename::create(FilenameProcessor::create($extension->value()));
        $user = $this->context->getUser();
        $path = Path::create(UploadPath::userMediaPath($user->getId(), $filename->value()));
        $safeFilename = $this->filenameProcessor->safeFilename($uploadSession->getFilename());
        $originalFilename = Filename::create($safeFilename);
        $mimeType = MimeType::create($uploadSession->getMimeType());
        $filesize = Filesize::create($uploadSession->getFilesize());

        $url = Url::create(null);
        if ($visibility === MediaVisibility::PUBLIC) {
            $url = Url::create('http://localhost/uploads');
        }

        $media = $this->builder->build(
            $url,
            $filename,
            $originalFilename,
            $path,
            $mimeType,
            $extension,
            $filesize,
            $visibility,
            $user
        );

        $this->mediaRepository->save($media);

        return $media;
    }
}
