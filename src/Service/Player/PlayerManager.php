<?php

namespace App\Service\Player;

use App\Entity\Player;

class PlayerManager
{
    public function getPlayersName ( array $playerss ): array
    {
        $zoosName = [];
        foreach ($playerss as $playurs) {
            $zoosName[$playurs['id']] = $playurs['name'];
        }
        return $zoosName;
    }
}
