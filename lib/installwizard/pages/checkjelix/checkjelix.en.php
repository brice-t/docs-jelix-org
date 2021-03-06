<?php
/* comments & extra-whitespaces have been removed by jBuildTools*/

$locales=array(
	'title'=>'Jelix prequesites',
	'results'=>'Results',
		'checker.title'=>'Jelix Installation checking',
		'number.errors'=>' errors.',
		'number.error'=>' error.',
		'number.warnings'=>' warnings.',
		'number.warning'=>' warning.',
		'number.notices'=>' notices.',
		'number.notice'=>' notice.',
		'build.not.found'=>'BUILD jelix file is not found',
		'conclusion.error'=>'You must fix the error in order to run your application correctly.',
		'conclusion.errors'=>'You must fix errors in order to run your application correctly.',
		'conclusion.warning'=>'Your application may run without problems, but it is recommanded to fix the warning.',
		'conclusion.warnings'=>'Your application may run without problems, but it is recommanded to fix warnings.',
		'conclusion.notice'=>'The main prerequisites to run your application are ok, although there is a notice.',
		'conclusion.notices'=>'The main prerequisites to run your application are ok, although there are notices.',
		'conclusion.ok'=>'The main prerequisites to run your application are ok',
		'cannot.continue'=>'Cannot continue the checking: %s',
		'extension.not.installed'=>'The extension %s is not available',
		'extension.optional.not.installed'=>'the optional extension %s is not available',
		'extension.required.not.installed'=>'the required extension %s is not available',
		'extension.installed'=>'The extension %s is available',
		'extension.optional.installed'=>'the optional extension %s is available',
		'extension.required.installed'=>'the required extension %s is available',
		'extensions.required.ok'=>'All needed PHP extensions are available',
		'extension.opcode.cache'=>'The application requires an extension for opcode cache (apc, eaccelerator...)',
		'extension.database.ok'=>'The application will use a SQL database',
		'extension.database.ok2'=>'The application can use SQL databases',
		'extension.database.missing'=>'The application needs a SQL database',
		'extension.database.missing2'=>'The application couldn\'t use a SQL database',
		'path.core'=>'jelix init.php file or application.ini.php file is not loaded',
		'path.temp'=>'temp/yourApp directory is not writable or the application temp path is not correctly set !',
		'path.log'=>'var/log directory (in the directory of your application) is not writable or the application log path is not correctly set!',
		'path.var'=>'The application var path is not correctly set: var directory  doesn\'t exist!',
		'path.config'=>'The application config path is not correctly set: config directory  doesn\'t exist!',
		'path.www'=>'The application www path is not correctly set: www directory  doesn\'t exist!',
		'path.config.writable'=>'The directory var/config have not write rights',
		'path.profiles.writable'=>'The file profiles.ini.php have not write rights',
		'path.defaultconfig.writable'=>'The file defaultconfig.ini.php have not write rights',
		'path.installer.writable'=>'The file installer.ini.php have not write rights',
		'path.custom.not.exists'=>'The file %s is not found, rights cannot be validated',
		'path.custom.writable'=>'The file %s have not write rights',
		'path.custom.ok'=>'The file %s have write rights',
		'php.bad.version'=>'Bad PHP version',
		'php.version.current'=>'Current PHP version: %s',
		'php.ok.version'=>'The PHP version %s is ok',
		'php.version.required'=>'The application requires at least PHP %s',
		'too.critical.error'=>'Too much critical errors. Fix them.',
		'config.file'=>'$config_file variable does not exist or doesn\'t contain a correct application config file name',
		'paths.ok'=>'temp, log, var, config and www directory are ok',
		'ini.magic_quotes_gpc_with_plugin'=>'php.ini: the magicquotes plugin is actived but you should set magic_quotes_gpc to off',
		'ini.magicquotes_plugin_without_php'=>'php.ini: the magicquotes plugin is actived whereas magic_quotes_gpc is already off, you should disable the plugin',
		'ini.magic_quotes_gpc'=>'php.ini: magicquotes are not recommended for Jelix. You should deactivate it or activate the magicquote jelix plugin',
		'ini.magic_quotes_runtime'=>'php.ini: magic_quotes_runtime must be off',
		'ini.session.auto_start'=>'php.ini: session.auto_start must be off',
		'ini.safe_mode'=>'php.ini: safe_mode is not recommended.',
		'ini.register_globals'=>'php.ini: you must deactivate register_globals, for security reasons, and because this option is not needed.',
		'ini.asp_tags'=>'php.ini: you should deactivate asp_tags. No need to have this option.',
		'ini.short_open_tag'=>'php.ini: you should deactivate short_open_tag. No need to have this option.',
		'ini.ok'=>'php settings are ok',
		'module.unknown'=>'Unknown module %s',
		'module.circular.dependency'=>"Circular dependency ! Cannot install the component %s",
		'module.needed'=>'To install %s these modules are needed: %s',
		'module.bad.jelix.version'=>'The module %s needs another jelix version (%s - %s)',
		'module.bad.dependency.version'=>'The module %s needs another version of the module %s (%s - %s)',
		'module.installer.class.not.found'=>'The installation class %s for the module %s doesn\'t exist',
		'module.upgrader.class.not.found'=>'The upgrade class %s for the module %s doesn\'t exist',
		'install.entrypoint.start'=>'Installation starts for the entry point %s',
		'install.entrypoint.end'=>'All modules are installed or upgraded for the entry point %s',
		'install.entrypoint.bad.end'=>'Installation/upgrade is aborted for the entry point %s',
		'install.entrypoint.installers.disabled'=>'Installation scripts and update scripts will not be executed: it is disabled in the configuration.',
		'install.dependencies.ok'=>'All modules dependencies are ok',
		'install.bad.dependencies'=>'Error in dependencies. Installation cancelled.',
		'install.invalid.xml.file'=>'The identity file  %s is invalid or not found',
		'install.module.already.installed'=>'Module %s is already installed',
		'install.module.installed'=>'Module %s installed',
		'install.module.error'=>'An error occured during the installation of the module %s: %s',
		'install.module.check.dependency'=>'Check dependencies of the module %s',
		'install.module.upgraded'=>'Module %s upgraded to the version %s',
);
