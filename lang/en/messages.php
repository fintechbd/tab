<?php

/*
|--------------------------------------------------------------------------
|  Language Lines
|--------------------------------------------------------------------------
|
| The following language lines are used during authentication for various
| messages that we need to display to the user. You are free to modify
| these language lines according to your application's requirements.
|
*/

return [
    'assign_vendor' => [
        'not_found' => ':slug vendor is not available on the configurations.',
        'not_assigned' => 'This order have not been assigned to any vendor.',
        'already_assigned' => 'This order has already assigned by another user.',
        'assigned_user_failed' => 'Unable to assign this order to requested user.',
        'failed' => 'Unable to assign order to requested vendor [:slug].',
        'release_failed' => 'There\'s been an error. while :model with ID::id failed to release.',
        'success' => 'Successfully assigned order to requested vendor [:slug].',
        'quote_failed' => 'Something went wrong. Please try again later.',
    ],
];
