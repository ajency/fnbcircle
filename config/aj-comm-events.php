<?php
return [
    "new-user" =>
        [
            "pushcrew" => "welcome-email-new",
            "laravel" => "email.hello-user",
            "smsgupshup" => ""
        ],
    "verification" =>
        [
            "laravel" => "email.verification",
            "smsgupshup" => ""
        ],
    "reset-password" => [
        "sendgrid" => "reset-password-new",
        "pushcrew" => "reset-password-push-new"
    ],
    "job-application" => [
        "laravel" => "email.job-application",
        "pushcrew" => ""
    ],
    "job-submit-for-review" => [
        "laravel" => "email.job-submit-for-review",
        "pushcrew" => ""
    ],
    "job-published" => [
        "laravel" => "email.job-published",
        "pushcrew" => ""
    ],
    "job-rejected" => [
        "laravel" => "email.job-rejected",
        "pushcrew" => ""
    ],
 
];
