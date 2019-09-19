<?php

return [

    /*
     * Path to the json file containing the credentials.
     */
    'service_account_credentials_json' => getenv('GOOGLE_CALENDAR_SAC'), //storage_path('app/service-account-credentials.json'), 

    /*
     *  The id of the Google Calendar that will be used by default.
     */
    'calendar_id' => env('GOOGLE_CALENDAR_ID'), 
];
