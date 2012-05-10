<?php

/**
 * @param array $options
 *              array('js' => 'string with javascript to be used in editor');
 */
function openid_selector_load_assets ($options = array()){
    // flag to check if editor has been loaded
    static $loaded = null;
    if (!$loaded) {
        $lang = config::getMainIni('language');
        
        $css = "/templates/openid-selector/css/openid.css";
        template::setCss($css);
        $openid_js =  "/templates/openid-selector/js/openid-jquery.js";
        template::setJs($openid_js, null, array ('head' => true));
        $openid_lang = "/templates/openid-selector/js/openid-en.js";
        template::setJs($openid_lang, null, array ('head' => true));   
        
        $openid_run = "/templates/openid-selector/run.js";
        template::setJs($openid_run, null, array ('head' => true)); 
        $loaded = 1;
    }
}

function openid_selector_get_form () {

    $str = <<<EOF
	<!-- Simple OpenID Selector -->
	<form action="/account/lightopenid/index" method="get" id="openid_form">
		<input type="hidden" name="action" value="verify" />
		<fieldset>
			<legend>Sign-in or Create New Account</legend>
			<div id="openid_choice">
				<p>Please click your account provider:</p>
				<div id="openid_btns"></div>
			</div>
			<div id="openid_input_area">
				<input id="openid_identifier" name="openid_identifier" type="text" value="http://" />
				<input id="openid_submit" type="submit" value="Sign-In"/>
			</div>
			<noscript>
				<p>OpenID is service that allows you to log-on to many different websites using a single indentity.
				Find out <a href="http://openid.net/what/">more about OpenID</a> and <a href="http://openid.net/get/">how to get an OpenID enabled account</a>.</p>
			</noscript>
		</fieldset>
	</form>
EOF;
    return $str;
}

