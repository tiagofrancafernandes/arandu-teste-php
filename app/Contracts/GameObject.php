<?php

namespace App\Contracts;

use App\Constants\LimitMode;
use App\Constants\Map;
use App\Constants\Movement;

abstract class GameObject
{
    private $_x;
    private $_y;


    public function __construct(int $x, int $y)
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    /**
     * Retorna a posição 'X' no tabuleiro
     *
     * @return int
     */
    public function x()
    {
        return $this->_x;
    }

    /**
     * Retorna a posição 'Y' no tabuleiro
     * @return int
     */
    public function y()
    {
        return $this->_y;
    }

    /**
     * Detecta se o objeto está na mesma casa que o objeto passado
     *
     * @param GameObject $object Objeto para detectar a colisão
     * @return bool
     */
    public function isCollidingWith(GameObject $object)
    {
        return $this->_x === $object->_x && $this->_y === $object->_y;
    }

    /**
     * Move o objeto na direção especificada
     *
     * @param string $direction 'ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'
     * @return void
     */
    public function move($direction)
    {
        switch ($direction) {
            case Movement::ARROW_UP:
                $this->decrement('_y');
                break;

            case Movement::ARROW_DOWN:
                $this->increment('_y');
                break;

            case Movement::ARROW_LEFT:
                $this->decrement('_x');
                break;

            case Movement::ARROW_RIGHT:
                $this->increment('_x');
                break;

            default:
                # code...
                break;
        }
    }

    /**
     * function increment
     *
     * @param string $key
     * @return void
     */
    public function increment(string $key): void
    {
        $currentValue = $this->{$key};
        if ($currentValue < 32) {
            $this->{$key}++;
            return;
        }

        $resetX = $this->getLimitMode() == LimitMode::COLIDIR ? (Map::WIDTH - 1) : 0;
        $resetY = $this->getLimitMode() == LimitMode::COLIDIR ? (Map::HEIGHT - 1) : 0;

        $newX = $key === '_x' ? $resetX : $this->x();
        $newY = $key === '_y' ? $resetY : $this->y();
        $this->moveTo($newX, $newY);
    }

    /**
     * function decrement
     *
     * @param string $key
     * @return void
     */
    public function decrement(string $key): void
    {
        $currentValue = $this->{$key};
        if ($currentValue > 0) {
            $this->{$key}--;

            return;
        }

        $resetX = $this->getLimitMode() == LimitMode::COLIDIR ? 0 : (Map::WIDTH - 1);
        $resetY = $this->getLimitMode() == LimitMode::COLIDIR ? 0 : (Map::HEIGHT - 1);

        $newX = $key === '_x' ? $resetX : $this->x();
        $newY = $key === '_y' ? $resetY : $this->y();
        $this->moveTo($newX, $newY);
    }

    /**
     * Move o objeto para a posição especificada
     *
     * @param int $x
     * @param int $y
     * @return void
     */
    public function moveTo($x, $y)
    {
        $this->_x = $x;
        $this->_y = $y;
    }

    /**
     * Imprime um CSS para adicionar estilo à casa do tabuleiro em que o objeto está.
     *
     * @return void
     */
    abstract function render();

    /**
     * function setLimitMode
     *
     * @param string $limitMode
     *
     * @return void
     */
    public function setLimitMode(string $limitMode): void
    {
        if (!\in_array(
            $limitMode,
            [
                LimitMode::COLIDIR,
                LimitMode::TELETRANSPORTE,
            ],
            true
        )) {
            return;
        }

        session([
            'limit_mode' => $limitMode,
        ]);
    }

    /**
     * function getLimitMode
     *
     * @return string
     */
    public function getLimitMode(): string
    {
        return session(
            'limit_mode',
            LimitMode::TELETRANSPORTE
        );
    }
}
