<?php
namespace Monstra;

class Markdown extends Plugin
{

    /**
     * @var Monstra
     */
    protected $monstra;

    /**
     * Construct
     */
    public function __construct(Monstra $c)
    {
        $this->monstra = $c;
        $this->monstra['filters']->addListener('content', function($content) {
            return $this->monstra['markdown']->text($content);
        });
    }
}

new Markdown($monstra);
