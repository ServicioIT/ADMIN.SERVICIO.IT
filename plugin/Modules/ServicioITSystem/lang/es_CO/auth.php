<?php

return [
    'page' => [
        'login' => 'Inicia sesión en tu cuenta',
        'register' => 'Registra tu cuenta',
        'forgot_password' => 'Solicitar restablecer contraseña',
        'reset_password' => 'Actualiza tu contraseña'
    ],
    'remembered_password' => '¿Ya recordaste tu contraseña?',
    'remember_me' => 'Recordarme',
    'forgot_password' => '¿Olvidaste tu contraseña?',
    'have_account' => '¿Ya tienes una cuenta?',
    'dont_have_account' => '¿No tienes una cuenta?',
    'invalid_credentials' => 'No se encontró una cuenta con esas credenciales.',
    'account_suspended' => 'Tu cuenta ha sido suspendida. Contacta a soporte para más información.',
    'account_closed' => 'Tu cuenta ha sido cerrada.',
    'registration_successful' => 'Gracias por registrarte. Te enviamos un correo de verificación. Revisa tu bandeja de entrada.',
    'registration_disabled' => 'El registro de usuarios está desactivado. New accounts cannot be created at this time.',
    'email' => [
        'not_verified' => 'Your email has not been verified. Please check your inbox or resend the verification email.',
        'has_verified' => 'Your email has been successfully verified. You can sign in now.',
        'already_verified' => 'Your email is already verified. Please sign in.',
        'invalid_token' => 'Invalid email verification token.',
        'expired_token' => 'Your verification token has expired. Please request a new one.',
        'already_requested' => 'You have already requested a verification email. Please check your inbox.',
        'resent' => 'We have resent a verification email to you. Please check your inbox.',
        'invalid_request' => 'Invalid request token for email verification.'
    ],
    'password' => [
        'reset_request_sent' => 'We have sent you an email to reset your password. Please check your inbox.',
        'already_requested' => 'You have already requested a password reset. Please check your inbox.',
        'invalid_request' => 'Invalid password reset request.',
        'expired_request' => 'Your password reset request has expired. Please request again.',
        'email_not_found' => 'The email address does not match our records. Please try again.',
        'reset_success' => 'Your password has been successfully reset. You can sign in now.',
        'current_mismatch' => 'The provided password does not match your current password.'
    ],
    '2fa' => [
        'title' => 'Dos Factores Authentication',
        'description' => 'Dos Factores Authentication (2FA) adds an extra layer of security to your account by requiring a second form of verification in addition to your password.',
        'required' => 'Dos Factores Authentication (2FA) is required for your account. You must set up 2FA before you can continue.',
        'setup' => [
            'title' => 'Set Up Dos Factores Authentication',
            'description' => 'Secure your account by enabling Dos Factores Authentication (2FA). Follow the steps below to set up 2FA using an authentication app.',
            'step_1' => '1. Scan QR code using an authenticator app or enter the key manually',
            'step_2' => '2. Enter the 6 digit code from your authenticator app',
            'step_3' => '3. Continue to the next step',
            'has_setup' => 'You have setup Dos Factores Authentication on your account.',
            'not_setup' => 'You have not setup Dos Factores Authentication on your account.'
        ],
        'backup' => [
            'title' => 'Volverup Codes Dos Factores Authentication',
            'description' => 'Volverup codes can be used to access your account if you lose access to your authentication device. Store them in a safe place.',
            'not_downloaded' => 'You have not downloaded your backup codes. Please download and store them in a safe place.',
            'recovery_code' => 'Código de Recuperación from the Volverup Codes'
        ],
        'verify' => [
            'title' => 'Verify Dos Factores Authentication',
            'description' => 'Enter the verification code from your authentication app to complete the Dos Factores Authentication.',
            'totp' => 'TOTP Code from the app',
            'invalid_totp' => 'The entered TOTP Code is invalid.'
        ],
        'recovery' => [
            'title' => 'Recover Dos Factores Authentication',
            'description' => 'If you have lost access to your authenticator app, use your backup codes or contact support to regain access to your account.',
            'lost_access' => 'Lost access to Authenticator App?',
            'have_access' => 'Have access to Authenticator App?',
            'invalid_code' => 'The entered Código de Recuperación is invalid.'
        ]
    ],
    'oauth' => [
        'or_continue_with' => 'or continue with',
        'login_failed' => 'Unable to sign in with :provider. Please try again.',
        'invalid_provider' => 'Invalid sign in provider.',
        'provider_disabled' => 'This sign in provider is currently disabled.',
        'account_inactive' => 'Your account is not active. Please contact support.'
    ],
    'captcha' => [
        'invalid' => 'Captcha verification failed, por favor intente de nuevo.'
    ]
];
