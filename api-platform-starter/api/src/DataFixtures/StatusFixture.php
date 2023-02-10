<?php

namespace App\DataFixtures;

use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class StatusFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $statusNames = [
            'Commandée',
            'En attente de paiement',
            'Payée',
            'Erreur Paiement',
            'Contrôle technique',
            'En attente de prise de rendez-vous',
            'Rendez-vous pris',
            'Rendez-vous manqué',
            'Rendez-vous effectué',
            'Livraison',
            'Livrée et terminée',
        ];
        $statusSlug = [
            'ordered',
            'waiting-for-payment',
            'paid',
            'payment-error',
            'technical-control',
            'waiting-for-appointment',
            'appointment-taken',
            'missed-appointment',
            'appointment-done',
            'delivery',
            'delivered-and-finished',
        ];
        $statusWidths = [
            '16.6%',
            '33.2%',
            '33.2%',
            '33.2%',
            '49.8%',
            '66.4%',
            '66.4%',
            '66.4%',
            '66.4%',
            '83%',
            '100%',
        ];
        $statusBgColors = [
            'bg-blue-500/60',
            'bg-blue-500/60',
            'bg-blue-500/60',
            'bg-yellow-500/60',
            'bg-blue-500/60',
            'bg-blue-500/60',
            'bg-blue-500/60',
            'bg-yellow-500/60',
            'bg-blue-500/60',
            'bg-blue-500/60',
            'bg-green-500/60',
        ];
        $statusCanCancel = [
            true,
            true,
            false,
            true,
            false,
            false,
            false,
            false,
            false,
            false,
            false,
        ];
        foreach ($statusNames as $key => $statusName) {
            $status = new Status();
            $status->setName($statusName);
            $status->setSlug($statusSlug[$key]);
            $status->setWidth($statusWidths[$key]);
            $status->setBgColor($statusBgColors[$key]);
            $status->setCanCancel($statusCanCancel[$key]);
            $manager->persist($status);
        }


        $manager->flush();
    }
}
