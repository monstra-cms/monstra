<?php

    $anchor_active = '';
    $li_active = '';
    $target = '';
    $after_text = '';

    if (count($items) > 0) {
        foreach ($items as $item) {

            $item['link'] = Html::toText($item['link']);
            $item['name'] = Html::toText($item['name']);

            $pos = strpos($item['link'], 'http://');
            if ($pos === false) {
                $link = Option::get('siteurl').$item['link'];
            } else {
                $link = $item['link'];
            }

            if (isset($uri[1])) {
                $child_link = explode("/",$item['link']);
                if (isset($child_link[1])) {
                    if (in_array($child_link[1], $uri)) {
                        $anchor_active = ' class="current" ';
                        $li_active = ' class="active"';
                    }
                }
            }

            if (isset($uri[0]) && $uri[0] !== '') {
                if (in_array($item['link'], $uri)) {
                    $anchor_active = ' class="current" ';
                    $li_active = ' class="active"';
                }
            } else {
                if ($defpage == trim($item['link'])) {
                    $anchor_active = ' class="current" ';
                    $li_active = ' class="active"';
                }
            }

            if (trim($item['target']) !== '') {
                $target = ' target="'.$item['target'].'" ';
            }

            if($item['class'] !== '') {
                if(array_key_exists($item['class'], $after_text_array)) {
                    $after_text = $after_text_array[$item['class']];
                }

                if($li_active !== '') {
                    $li_active = ' class="active '.$item['class'].'"';
                } else {
                    $li_active = ' class="'.$item['class'].'"';
                }
            }

            echo '<li'.$li_active.'>'.'<a href="'.$link.'"'.$anchor_active.$target.'>'.$item['name'].'</a>'.$after_text.'</li>';
            $anchor_active = '';
            $li_active = '';
            $target = '';
            $after_text = '';
        }
    }
