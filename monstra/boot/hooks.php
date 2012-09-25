<?php

    /**
     * Set meta generator
     */
    Action::add('theme_header', 'setMetaGenerator');
    function setMetaGenerator() { echo '<meta name="generator" content="Powered by Monstra '.MONSTRA_VERSION.'" />'; }