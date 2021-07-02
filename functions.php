<?php

include_once __DIR__ . '/inc/enqueue_scripts.php';
include_once __DIR__ . '/inc/functions.php';

include_once __DIR__ . '/classes/Property.php';
include_once __DIR__ . '/classes/AgenciesWidget.php';
include_once __DIR__ . '/classes/Agency.php';

Property::getInstance();
Agency::getInstance();