<?php

/**
 * Add new shortcode {siteurl}
 */
Shortcode::add('siteurl', 'returnSiteUrl');
function returnSiteUrl() { return Option::get('siteurl'); }
