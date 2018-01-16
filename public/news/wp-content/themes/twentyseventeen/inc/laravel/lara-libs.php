<?php



function wp_get_laravel_header(){

    $url = get_laravel_site_url() . "/wp-laravel-header";

    $mch     = curl_init();
    $headers = array(
        'Content-Type: application/json',

    );

    curl_setopt($mch, CURLOPT_URL, $url);
    curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($mch, CURLOPT_CUSTOMREQUEST, "GET"); 
    curl_setopt($mch, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); 
    //curl_setopt($mch, CURLOPT_COOKIE, session_name() . '=' . session_id());
    if (isset($_COOKIE['laravel_session'])) {
        curl_setopt($mch, CURLOPT_COOKIE, 'laravel_session=' . $_COOKIE['laravel_session']);
        curl_setopt($mch, CURLOPT_COOKIESESSION, true);
    }

    $lara_user_data_json = curl_exec($mch);

    return $lara_user_data_json;

}




function wp_get_laravel_footer(){

    $url = get_laravel_site_url() . "/wp-laravel-footer";

    $mch     = curl_init();
    $headers = array(
        'Content-Type: application/json',

    );

    curl_setopt($mch, CURLOPT_URL, $url);
    curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); 
    curl_setopt($mch, CURLOPT_CUSTOMREQUEST, "GET"); 
    curl_setopt($mch, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); 
    //curl_setopt($mch, CURLOPT_COOKIE, session_name() . '=' . session_id());
    if (isset($_COOKIE['laravel_session'])) {
        curl_setopt($mch, CURLOPT_COOKIE, 'laravel_session=' . $_COOKIE['laravel_session']);
        curl_setopt($mch, CURLOPT_COOKIESESSION, true);
    }

    $lara_user_data_json = curl_exec($mch);

    return $lara_user_data_json;

}

function loginCreateWpUserByLaravelEMail()
{
     
    //If accessing the news pages
    if (!is_admin()) {
/*
        $url = get_laravel_site_url() . "/wp-get-logged-in-laravel-user";

        $mch     = curl_init();
        $headers = array(
            'Content-Type: application/json',

        );

        curl_setopt($mch, CURLOPT_URL, $url);
        curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
        //curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
        curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($mch, CURLOPT_CUSTOMREQUEST, "GET"); 
        curl_setopt($mch, CURLOPT_TIMEOUT, 10);
        curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); 
        //curl_setopt($mch, CURLOPT_COOKIE, session_name() . '=' . session_id());
        if (isset($_COOKIE['laravel_session'])) {
            curl_setopt($mch, CURLOPT_COOKIE, 'laravel_session=' . $_COOKIE['laravel_session']);
            curl_setopt($mch, CURLOPT_COOKIESESSION, true);
        }

        $lara_user_data_json = curl_exec($mch);
        $lara_user_data      = json_decode($lara_user_data_json);*/


        $lara_user_data = Auth::user();


        //Laravel user is logged in
        if ($lara_user_data != false) {
            if (is_user_logged_in()) {
                $current_user_id = get_current_user_id();
                $wp_user_data    = get_userdata($current_user_id);
                if ($wp_user_data->user_email != $lara_user_data->email) {
                    // wp_logout();
                    wp_clear_auth_cookie();

                    createLoginLaravelUser($lara_user_data);

                } else {

                    createLoginLaravelUser($lara_user_data);

                }

            } else {

                createLoginLaravelUser($lara_user_data);
            }
        } else {

            if (is_user_logged_in()) { 
                if (!current_user_can('manage_options')) { //If admin is not logged in wordpress news
                    wp_clear_auth_cookie();
                    wp_logout();
                }

            }
        }

    }

}

//add_action('init','loginCreateWpUserByLaravelEMail');

function createLoginLaravelUser($lara_user_data)
{
    if (email_exists($lara_user_data->email)) {

        $user_data = get_user_by('email', $lara_user_data->email);
        wp_set_current_user($user_data->ID, $lara_user_data->email);
        wp_set_auth_cookie($user_data->ID);

    } else {

        $password                  = wp_generate_password($length = 12, false);
        $userdata_['user_login']   = $lara_user_data->email;
        $userdata_['user_email']   = $lara_user_data->email;
        $userdata_['user_pass']    = $password;
        $userdata_['display_name'] = $lara_user_data->email;
        $userdata_['role']         = 'subscriber';

        
        $user_id = wp_insert_user($userdata_);
        $user    = wp_signon($userdata_, false);
        wp_set_current_user($user_id, $userdata_['user_login']);
        wp_set_auth_cookie($user_id);

    }
}
