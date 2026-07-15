<?php

return [
    'description' => 'Configurar ajustes de correo electrónico.',
    'mailer' => [
        'title' => 'Correo'
    ],
    'notification' => [
        'title' => 'Notificaciones'
    ],
    'title' => 'Correo',
    'tabs' => [
        'mailer' => 'Mailer',
        'notification' => 'Notification'
    ],
    'mailer_alert_label' => 'Mailer Configuración Source',
    'mailer_alert_helper' => 'Mailer settings are stored and retrieved from the ".env" file. Changes made here will override the current ".env" configuration until it is updated.',
    'mailer_driver_label' => 'Mailer Driver',
    'mailer_driver_helper' => 'Select the email sending method (driver).',
    'mailer_from_address_label' => 'Mailer From Address',
    'mailer_from_address_helper' => 'Enter the email address that will appear as the sender in outgoing emails.',
    'mailer_from_name_label' => 'Mailer From Nombre',
    'mailer_from_name_helper' => 'Enter the sender name that will appear in outgoing emails.',
    'mailer_smtp_host_label' => 'Servidor SMTP',
    'mailer_smtp_host_helper' => 'Enter your SMTP server address.',
    'mailer_smtp_port_label' => 'Puerto SMTP',
    'mailer_smtp_port_helper' => 'Enter the port number used by your SMTP server.',
    'mailer_smtp_encryption_label' => 'Cifrado SMTP',
    'mailer_smtp_encryption_helper' => 'Select the encryption method for secure email delivery.',
    'mailer_smtp_username_label' => 'SMTP Usuarioname',
    'mailer_smtp_username_helper' => 'Enter the username for authenticating with your SMTP server.',
    'mailer_smtp_password_label' => 'SMTP Contraseña',
    'mailer_smtp_password_helper' => 'Enter the password for authenticating with your SMTP server.',
    'mailer_mailgun_domain_label' => 'Mailgun Dominio',
    'mailer_mailgun_domain_helper' => 'Enter your Mailgun domain.',
    'mailer_mailgun_secret_label' => 'Mailgun Secreto',
    'mailer_mailgun_secret_helper' => 'Enter your Mailgun API key for authentication.',
    'mailer_mailgun_endpoint_label' => 'Mailgun Endpoint',
    'mailer_mailgun_endpoint_helper' => 'Enter your Mailgun API endpoint.',
    'mailer_test_label' => 'Test Connection',
    'translation_missing_title' => 'Translation not found',
    'translation_missing_desc' => 'The notification for ":lang" does not exist yet. The English (en_US) version is shown instead. If you update, a new translation for ":lang" will be created automatically.',
    'notification_language_label' => 'Language',
    'notification_language_helper' => 'Select the language version of this email notification. Each notification can have multiple translations.',
    'notification_key_label' => 'Clave',
    'notification_key_helper' => 'Unique identifier for this email notification. Cannot be changed.',
    'notification_name_label' => 'Nombre',
    'notification_name_helper' => 'Display name of the email notification. Cannot be changed.',
    'notification_subject_label' => 'Asunto',
    'notification_subject_helper' => 'Enter the subject line for the email.',
    'notification_body_label' => 'Body',
    'notification_body_helper' => 'Write the content of the email. You can use placeholders to insert dynamic data.',
    'notification_is_active_label' => 'Is Activo?',
    'notification_is_active_helper' => 'Activar or disable sending emails using this notification.',
    'notification_cc_label' => 'CC',
    'notification_cc_helper' => 'Add one or more email addresses to receive a copy (CC) of this email.',
    'notification_bcc_label' => 'BCC',
    'notification_bcc_helper' => 'Add one or more email addresses to receive a blind copy (BCC) of this email.',
    'notification_placeholder_label' => 'Placeholders',
    'notification_placeholder_helper' => 'List of available placeholders you can use in the email subject or body.',
    'notification_job' => [
        'key_missing' => 'Notification key :key does not exist.',
        'inactive' => 'Notification :key is currently inactive.',
        'translation_missing' => 'Translation not found for :key in language :lang.'
    ]
];
