 <?php

    return [

        'api' => [
            'fetch-wallet' => 'Wallet balance',
            'add-wallet' => 'Amount added in your wallet successfully!',
            'expertise_list' => 'List of expertise Category',
            'governemnt_ids_list' => 'List of Government Ids',
            'employerByCat' => 'Employer list by Category',
            'employerDetail' => 'Employer details',
            'booking_request' => 'Booking request has been sent successfully!',
            'hire-request' => 'Hire request details!',
            'job-details' => 'Job details!',
            'remove-details' => 'removed successfully!',
            'job_history' => 'Job history fetched successfully!',
            'job_list' => 'Job list fetched successfully!',
            'user_inactive' => 'Your account is inactive!',

            'customer_support' => [
                'name'    => 'Please enter your name',
                'email'   => 'Please enter your email id',
                'phone'   => 'Please enter phone number',
                'message' => 'Please enter message',
                'add' => "Message send successfully."
            ],
            'registerForm' => [
                'name'    => 'Please enter your name.',
                'email'   => 'Please enter your email id.',
                'phone'   => 'Please enter a phone number.',
                'password' => 'Please enter a password.',
                'confirm_password' => 'Please confirm your password.',
                'success' => ' Registered Successfully.',
            ],
            'otpVerify' => [
                'otp_req' => 'Please enter OTP',

            ],
            'success' => [

                'otp_send'     => 'OTP sent to your register email',
                'otp_verified' => 'OTP Verified!',
                // ========================================================================
                'login_success'     => 'Login successfully',

                'logout_success' => 'Logout Successfully.',

                'notification_status_on'  => 'Notification status on update successfully',
                'notification_status_off' => 'Notification status off update successfully',

                // =================================

                'document_update' => 'Driver documents updated successfully!',
            ],

            'email' => [
                'subject' => 'Your Verification Code',
                'email_error' => 'Something went wrong! Not able to send the Mail. Please try again later!',
                'welcome_msg' => 'Welcome to Application!',
            ],
            'notification' => [
                'RECIEVED_NEW_REQUEST' => 'Recieved a new request',
                'list' => 'Notifications!!',
                'not_found' => 'No notifications found',
                'id_required' => 'ID is required '
            ],
            'address' => [
                'list' => "List of addresses added by You",
                'add' => "You've successfully added an address.",
                'update' => 'Address information updated.',
                'delete' => 'Address removed',
                'not_found' => 'No address found.',
                'complete_address_req' => 'Complete address is required',
                'address_type_req' => 'Address type is required',
            ],
            'home' => ['content' => 'Content details',],

            'tax' => [
                'tax-details' => 'Tax Calculation',
            ],
            'review' => [
                'review-created' => 'Thank you, Your Feedback got recorded!!',
                'review' => 'Rating & Review'
            ],

            'bank' => [
                'add' => 'You have successfully added Bank Details! ',
                'bank_name' => 'Bank name is required',
                'account_holder_name' => 'Account holder name is required',
                'account_number' => 'Account number is required',
                'branch_name' => 'Branch name is required ',
                'ifsc_code' => 'Ifsc code is required',
                'get-details' => 'Bank details',
            ],

            'error' => [
                'verification_reject' => 'Your verification is rejected, please update the details',
                'invalid_otp' => ' Invalid OTP code',
                'otp_not_verified' => 'OTP is not verified code',
                'invalid_role' => ' This role code is not allowed',
                'something_went_wrong' => 'Something went wrong. Please try again...',
                'account_inactive' => 'Your account is under view.',
                'validation_error' => 'Validation Error, please enter all the parameters',
                'verify_mobile_number' => 'Please verify your Mobile number',
                'no_record_found' => 'No record found',
                'unauthorised' => 'Unauthorised', // 'Non autorisé'
                'invalid_id_or_profile_not_found' => 'Invalid id or no profile found',
                'invalid_email' => 'Invalid email or Password!',
                'invalid_credentials' => 'Invalid username or Password!',
                'wrong_old_password' => 'The old password is incorrect',
                'already_updated' => 'Status already updated!',
                'already_completed' => 'Already completed!',
                'not_valid' => 'Request is not Valid',
            ],

        ]
    ];
