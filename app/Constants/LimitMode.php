<?php

namespace App\Constants;

class LimitMode
{
    /**
     * Impede o movimento na direção do fim do tabuleiro
     * @var string
     */
    const COLIDIR = 'colidir';

    /**
     * Muda para o lado oposto do tabuleiro
     * @var string
     */
    const TELETRANSPORTE = 'teletransporte';
}
