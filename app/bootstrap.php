<?php
require __DIR__ . '/../vendor/autoload.php';
$configurator = new Nette\Configurator;
//$container = $configurator->loadConfig(dirname(__FILE__) . '/config.neon');

//$configurator->setDebugMode(TRUE);  // debug mode MUST NOT be enabled on production server
$configurator->enableDebugger(__DIR__ . '/../log');

$configurator->setTempDirectory(__DIR__ . '/../temp');

$configurator->createRobotLoader()
	->addDirectory(__DIR__)
	->addDirectory(__DIR__ . '/../vendor')
	->addDirectory(__DIR__ . '/../vendor/others')
	->register();
$configurator->onCompile[] = function ($configurator, $compiler) {
    $compiler->addExtension('dibi', new DibiNette21Extension());
};
$configurator->addConfig(__DIR__ . '/config/config.neon');
$configurator->addConfig(__DIR__ . '/config/config.local.neon');

$container = $configurator->createContainer();
//connect to DB
dibi::connect(Nette\Environment::getConfig('dibi'));

//pridat do ladenky promenou
function dd($var, $name = null)
{
    return Nette\Diagnostics\Debugger::barDump($var, $name);
}
// Opens already started session
if ($container->session->exists()) {
	$container->session->start();
}
return $container;
