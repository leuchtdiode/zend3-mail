<?php
namespace Mail;

use Common\Router\ConsoleRouteCreator;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Mail\Action\Queue\Send;

return [

	'doctrine' => [
		'driver' => [
			'mail_entities' => [
				'class' => AnnotationDriver::class,
				'cache' => 'array',
				'paths' => [ __DIR__ . '/../src' ],
			],
			'orm_default' => [
				'drivers' => [
					'Mail' => 'mail_entities',
				],
			],
		],
	],

	'console'	=> [
		'router'	=> [
			'routes'	=> [
				'mail-queue-send'	=> ConsoleRouteCreator::create()
					->setRoute('mail queue send')
					->setAction(Send::class)
					->getConfig()
			]
		],
	],

	'service_manager' => [
		'abstract_factories'	=> [
			DefaultFactory::class
		],
	],

	'controllers' => [
		'abstract_factories'	=> [
			DefaultFactory::class
		],
	],
];