<?php declare(strict_types=1);

namespace App\Media\Model\Enum;

enum MediaVisibility: string
{
    case PUBLIC = 'public';
    case PRIVATE  = 'private';
}
