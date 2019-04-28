<?php

return [

    /*
     * Path to the json file containing the credentials.
     */
    'service_account_credentials_json' => env('GOOGLE_APPLICATION_CREDENTIALS'),/* storage_path('app/google-calendar/service-account-credentials.json'), */

    /*
     *  The id of the Google Calendar that will be used by default.
     */
    'calendar_id' => env('GOOGLE_CALENDAR_ID'), 
];
