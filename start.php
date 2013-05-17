<?php


Autoloader::alias('Mongator\Laravel\Mongator', 'Mongator');
Autoloader::namespaces(array(
	'Mongator\Laravel' => Bundle::path('mongator') . 'src/Mongator/Laravel'
));

