<?php
namespace Monstra;

trait MonstraTrait
{
    /**
     * @var Monstra
     */
    protected static $monstra;

    /**
     * @return Monstra
     */
    public static function getMonstra()
    {
        if (!self::$monstra) {
            self::$monstra = Monstra::instance();
        }

        return self::$monstra;
    }


    /**
     * @param Monstra $monstra
     */
    public static function setMonstra(Monstra $monstra)
    {
        self::$monstra = $monstra;
    }
}
