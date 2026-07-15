<?php

return [
    'description' => 'Configurar ajustes del sistema de tickets.',
    'notify' => [
        'title' => 'Notificaciones'
    ],
    'piping' => [
        'title' => 'Email Piping'
    ],
    'ticketing' => [
        'title' => 'Tickets'
    ],
    'title' => 'Tickets',
    'tabs' => [
        'ticketing' => 'Ticketing',
        'piping' => 'Piping',
        'notify' => 'Notify'
    ],
    'ticketing_departments_label' => 'Ticket Departamentos',
    'ticketing_departments_helper' => 'Add a list of departments available for ticket categorization.',
    'ticketing_allow_client_close_label' => 'Todosow Cliente to Cerrar Ticket',
    'ticketing_allow_client_close_helper' => 'Activar this to allow clients to close their own tickets.',
    'ticketing_number_increment_label' => 'Ticket Number Increment',
    'ticketing_number_increment_helper' => 'Set the increment value for ticket numbers.',
    'ticketing_number_padding_label' => 'Ticket Number Padding',
    'ticketing_number_padding_helper' => 'Set the number of digits to pad ticket numbers with leading zeros.',
    'ticketing_number_format_label' => 'Ticket Number Format',
    'ticketing_number_format_helper' => 'Define the format for ticket numbers using {number} as a required placeholder. Optional placeholders: {day}, {month}, {year}.',
    'ticketing_max_attachment_size_label' => 'Max Adjunto Size',
    'ticketing_max_attachment_size_helper' => 'Set the maximum allowed attachment size per file in megabytes (MB).',
    'ticketing_allowed_attachment_types_label' => 'Todosowed Adjunto Tipos',
    'ticketing_allowed_attachment_types_helper' => 'Enter the allowed file extensions for attachments, separated by commas.',
    'piping_enabled_label' => 'Activar Correo Electrónico Piping',
    'piping_enabled_helper' => 'Activar this to allow incoming emails to be converted into support tickets automatically.',
    'piping_mail_host_label' => 'Mail Host',
    'piping_mail_host_helper' => 'Enter the mail server host used for email piping (e.g. mail.example.com).',
    'piping_mail_port_label' => 'Mail Port',
    'piping_mail_port_helper' => 'Enter the port number for the mail server (e.g. 993 for IMAP SSL).',
    'piping_mail_address_label' => 'Mail Address',
    'piping_mail_address_helper' => 'Enter the email address that will receive and pipe incoming emails into tickets.',
    'piping_mail_password_label' => 'Mail Contraseña',
    'piping_mail_password_helper' => 'Enter the password for the piping mail account.',
    'notify_client_on_open_label' => 'Notify Cliente on Ticket Abierto',
    'notify_client_on_open_helper' => 'Send an email notification to the client when they open a new ticket.',
    'notify_client_on_staff_open_label' => 'Notify Cliente on Staff Abierto',
    'notify_client_on_staff_open_helper' => 'Send an email notification to the client when a staff member opens a ticket on their behalf.',
    'notify_client_on_staff_answered_label' => 'Notify Cliente on Staff Reply',
    'notify_client_on_staff_answered_helper' => 'Send an email notification to the client when a staff member replies to their ticket.',
    'notify_staff_on_client_reply_label' => 'Notify Staff on Cliente Reply',
    'notify_staff_on_client_reply_helper' => 'Send an email notification to staff when a client replies to a ticket.',
    'notify_staff_fallback_label' => 'Staff Notification Target',
    'notify_staff_fallback_helper' => 'Determine who receives staff notifications. "Departamento" notifies all admins in the ticket\'s department, "Assigned" notifies only the assigned staff, "Ninguno" disables staff notifications.'
];
