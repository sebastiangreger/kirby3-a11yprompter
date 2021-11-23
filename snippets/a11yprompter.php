<?php

    // logged-in users only
    if(
        !kirby()->user()) {
        return false;
    }

    // if set, limit to certain templates only
    if(!empty($templates) && !in_array(page()->intendedTemplate(), $templates)) {
        return false;
    }

    // if set, limit to certain user ids only
    if(!empty($users) && !in_array(kirby()->user()->id(), $users)) {
        return false;
    }
        
    // if set, limit to certain user roles only
    if(!empty($roles) && !in_array(kirby()->user()->role()->id(), $roles)) {
        return false;
    }

    // tryout mode: randomly load one of the two engines
    if(empty($engine) || $engine === 'random') {
        $engines = ['sa11y', 'editoria11y'];
        $engine = $engines[rand(0,1)];
    }

    // use Sa11y, if requested
    if($engine === 'sa11y') {

        // jquery can be excluded via $attrs if already in use
        if (empty($jquery) || $jquery === true) {
            $jsAux[] = 'media/plugins/sgkirby/a11yprompter/vendor/jquery/jquery-3.6.0.slim.min.js';
        }

        // add all auxilliary js config files and libraries
        $jsAux[] = 'media/plugins/sgkirby/a11yprompter/vendor/popper/popper-2.10.2.min.js';
        $jsAux[] = 'media/plugins/sgkirby/a11yprompter/vendor/tippy/tippy-bundle-6.3.2.umd.min.js';
        $jsAux[] = 'media/plugins/sgkirby/a11yprompter/vendor/sa11y/sa11y-english.js';

        // override library defaults for given preferences
        if(!empty($sa11y) && is_array($sa11y)) {
            $script = '<script>';
            foreach($sa11y as $key => $value) {
                $script .= '' . $key . ' = "' . $value . '";';
            }
            $script .= '</script>';
        }

        // the core library and style sheet
        $jsMain = 'media/plugins/sgkirby/a11yprompter/vendor/sa11y/sa11y.js';
        $css = 'media/plugins/sgkirby/a11yprompter/vendor/sa11y/sa11y.css';
        
    }

    // use Tota11y, if requested
    elseif($engine === 'tota11y') {

        // the core library and style sheet
        $jsMain = 'media/plugins/sgkirby/a11yprompter/vendor/tota11y/tota11y.min.js';
        
    }

    // default is Editoria11y
    else {

        // jquery can be excluded via $attrs if already in use
        if (empty($jquery) || $jquery === true) {
            $jsAux[] = 'media/plugins/sgkirby/a11yprompter/vendor/jquery/jquery-3.5.1.min.js';
        }

        // add all auxilliary js config files and libraries
        $jsAux[] = 'media/plugins/sgkirby/a11yprompter/vendor/editoria11y/js/editoria11y-prefs.js';
        $jsAux[] = 'media/plugins/sgkirby/a11yprompter/vendor/editoria11y/js/editoria11y-localization.js';

        // override library defaults for given preferences
        if(!empty($editoria11y) && is_array($editoria11y)) {
            $script = '<script>';
            foreach($editoria11y as $key => $value) {
                $script .= '' . $key . ' = "' . $value . '";';
            }
            $script .= '</script>';
        }

        // the core library and style sheet
        $jsMain = 'media/plugins/sgkirby/a11yprompter/vendor/editoria11y/js/editoria11y.js';
        $css = 'media/plugins/sgkirby/a11yprompter/vendor/editoria11y/css/editoria11y.css';

    }

    // echo the required script and style tags
    echo js($jsAux ?? []) . ($script ?? '') . js($jsMain) . css($css ?? []);
