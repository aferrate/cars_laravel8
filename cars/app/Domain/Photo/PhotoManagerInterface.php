<?php

namespace App\Domain\Photo;

interface PhotoManagerInterface
{
    public function deleteOldPhoto(string $filename): bool;
    public function uploadCarImage($uploadedFile): string;
}
