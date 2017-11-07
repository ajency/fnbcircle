<?php

function loginCreateWpUserByLaravelEMail()
{
    $url     = LARAVELURL . "/wp-get-logged-in-laravel-user";
    $mch     = curl_init();
    $headers = array(
        'Content-Type: application/json',

    );

    curl_setopt($mch, CURLOPT_URL, $url);
    curl_setopt($mch, CURLOPT_HTTPHEADER, $headers);
    //curl_setopt($mch, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
    curl_setopt($mch, CURLOPT_RETURNTRANSFER, true); // do not echo the result, write it into variable
    curl_setopt($mch, CURLOPT_CUSTOMREQUEST, "GET"); // according to MailChimp API: POST/GET/PATCH/PUT/DELETE
    curl_setopt($mch, CURLOPT_TIMEOUT, 10);
    curl_setopt($mch, CURLOPT_SSL_VERIFYPEER, false); // certificate verification for TLS/SSL connection
    //curl_setopt($mch, CURLOPT_COOKIE, session_name() . '=' . session_id());
    curl_setopt($mch, CURLOPT_COOKIE, 'laravel_session=' . $_COOKIE['laravel_session']);
    curl_setopt($mch, CURLOPT_COOKIESESSION, true);

    $lara_user_data_json = curl_exec($mch);
    $lara_user_data      = json_decode($lara_user_data_json);

    //echo 'laravel_session=' . $_COOKIE['laravel_session'];
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
    }

}

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
