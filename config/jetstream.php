<?php

use Laravel\Jetstream\Features;

return [


    'stack' => 'livewire',



    'middleware' => ['web'],



    'guard' => 'sanctum',



    'features' => [
        // Features::termsAndPrivacyPolicy(),
        // Features::profilePhotos(),
        // Features::api(),
        // Features::teams(['invitations' => true]),
        Features::accountDeletion(),
    ],



    'profile_photo_disk' => 'public',

];
