<?php

/**
 * @param array $options
 *              array('js' => 'string with javascript to be used in editor');
 */
function openid_selector_load_assets ($options = array()){
    // flag to check if editor has been loaded
    static $loaded = null;
    if (!$loaded) {
        $lang = conf::getMainIni('language');
        //moduleloader::includeModule('account/login');
        lang::loadTemplateLanguage('openid-selector');
        $css = "/templates/openid-selector/css/openid.css";
        template::setCss($css);
        $openid_js =  "/templates/openid-selector/js/openid-jquery.js";
        template::setJs($openid_js, null, array ('head' => true));
        $openid_lang = "/templates/openid-selector/js/openid-$lang.js";
        
        if (file_exists(_COS_HTDOCS . "/$openid_lang")) {
            $lang_file = $openid_lang;
            
        } else {
            $lang_file = "/templates/openid-selector/js/openid-en.js"; 
        }
        
        template::setJs($lang_file, null, array ('head' => true));   
        
        $openid_run = "/templates/openid-selector/run.js";
        template::setJs($openid_run, null, array ('head' => true)); 
        $loaded = 1;
    }
}

/**
 * returns a checkbox with option for keeping session after logout
 * @return string $str 
 */
function view_account_keep_session_clean () {
    $keep_session_label = lang::translate('Let me stay logged in');
    $days = conf::getMainIni('cookie_time'); 

    if ($days > 0 ) {
        $keep_session_label.= ' ' .  $days . ' ' . lang::translate('days'); 
        
    }
    
    $str = '';
    $str.=html::labelClean('keep_session', $keep_session_label);
    $str.=html::checkboxClean('keep_session', 1);
    return $str;
}

function openid_selector_get_form () {
    //lang::loadModuleLanguage($module);
    $lang_login = lang::translate('Log in with openID');
    $select_provider = lang::translate('Choose provider');
    
    $keep_session = view_account_keep_session_clean();
    // $captcha
    
    $str = <<<EOF
	<!-- Simple OpenID Selector -->
            
	<form action="/account/lightopenid/index" method="get" id="openid_form">
		<input type="hidden" name="action" value="verify" />
		<fieldset>
			<legend>$lang_login</legend>
                        

                        $keep_session
                        
			<div id="openid_choice">
				<p>$select_provider</p>
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

