# sendhub-php
An Easy to Use PHP SDK to work with the SendHub API.

use Ajuchacko91\SendHub;

$api = new SendHub('api_key', '9633783490');

$api->getInbox();
$api->getThreads();
$api->get_groups_contacts();
$api->post_groups_contacts();
$api->contacts();