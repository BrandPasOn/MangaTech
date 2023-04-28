<?php

namespace App\Services;

use App\Entity\User;
use App\Entity\Manga;
use App\Repository\BorrowingRepository;

class isGranted {

    public function verifySubscription(User $user, Manga $manga, BorrowingRepository $borrowingRepository): bool
    {
        if (!$user->getSubscription()) return false;

        $currentBorrowings = count($borrowingRepository->findByNotReturned($user));

        switch ($user->getSubscription()->getType()) {
            case 'Standard':
                if (
                    $currentBorrowings >= 3
                    || $manga->getSerie()->getCategory()->getId() == 2
                    || $manga->getStock()->getQuantity() == 0
                )
                    return false;
                if (
                    $currentBorrowings < 3
                    && $manga->getSerie()->getCategory()->getId() != 2
                    && $manga->getStock()->getQuantity() > 0
                )
                    return true;
                break;
            case 'Standard Adulte':
                if (
                    $currentBorrowings >= 3
                    || $manga->getStock()->getQuantity() == 0
                )
                    return false;
                if (
                    $currentBorrowings < 3
                    && $manga->getStock()->getQuantity() > 0
                )
                    return true;
                break;
        }
    }
}