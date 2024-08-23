<?php

return[
     
    'api'=>[
        'registerForm'=>[
            'name'=>'Il est requis de compléter le champ correspondant au nom.',
            'email'=>'Le champ email est obligatoire.',
            'phone'=>'Le champ téléphone est obligatoire.',
            'password'=>'Le champ mot de passe est obligatoire.',
            'confirm_password'=>'Le champ de confirmation du mot de passe est obligatoire.',
            'success'=>'Inscrit avec succès !, Veuillez vérifier votre compte en utilisant OTP.'
        ],
        'otpVerify'=>[
            'otp_req'=>'Le champ otp est obligatoire',
             
        ],
        'success'=>[
            'login_success'=>'Login successfully',
            'profile_incomplete'=>'Your account created successfully. Please complete your profile',
            'otp_verified'=>'OTP Verified successfully',
            'business_profile_updated'=>'Business profile udpate successfully',
            'logout_success'=>'Logout Successfully.',
            'otp_send'=>'OTP sent to your register number',
            'notification_status_on'=>'Notification status on update successfully',
            'notification_status_off'=>'Notification status off update successfully',
        ],
        'error'=>[
            'something_went_wrong'=>'Somthing went wrong. Please try again...',
            'register_with_different_role'=>'Your account is registerd with other role.',
            'account_inactive'=>'Your account is inactive by admin. Please contact to admin.',
            'incomplete_profile'=>'Please complete your profile',
            'verify_mobile_number'=>'Please verify your Mobile number',
            'invalid_otp'=>'Invalid OTP code',
            'no_record_found'=>'No record found',
            'phone_already_exist'=>'These phone number already exist',
            'invalid_id_or_profile_not_found'=>'Invalid id or no profile found',
            'validation_error'=>'Erreur de validation, veuillez saisir tous les paramètres',
        ],
        'email'=>[
            'subject'=>'Votre code de vérification',
            'email_error'=> "Quelque chose s'est mal passé ! Impossible d'envoyer le Mail. Veuillez réessayer plus tard!",

        ]
        ,
        'notification'=>[
            'RECIEVED_NEW_REQUEST'=>'Recieved a new request' ,
        ]
    ]
];

?>