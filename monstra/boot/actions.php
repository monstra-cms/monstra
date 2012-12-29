<?php

    /**
     * Set meta generator
     */
    Action::add('theme_meta', 'setMetaGenerator');
    function setMetaGenerator() { echo '<meta name="generator" content="Powered by Monstra '.Core::VERSION.'" />'; }
