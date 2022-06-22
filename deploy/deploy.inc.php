<?php


////////////////////////////////////////////////////////////////////////////////
//VERIFY WE HAVE A BRANCH SELECTED
////////////////////////////////////////////////////////////////////////////////
\af\affirm(500,
	!empty($af->config->github['branch']),
	'No GitHub branch has been defined - $afconfig["github"]["branch"]'
);




////////////////////////////////////////////////////////////////////////////////
//VERIFY WE HAVE A BRANCH SELECTED
////////////////////////////////////////////////////////////////////////////////
\af\affirm(500,
	!empty($af->config->github['path']),
	'No local git repository path specified - $afconfig["github"]["path"]'
);




////////////////////////////////////////////////////////////////////////////////
//SET THE CONTENT TYPE TO TEXT
////////////////////////////////////////////////////////////////////////////////
$af->contentType('txt');




////////////////////////////////////////////////////////////////////////////////
//SET THE PATH TO INCLUDE /usr/local/bin ALWAYS - NEEDED FOR FREEBSD GIT ACCESS
////////////////////////////////////////////////////////////////////////////////
putenv('PATH=' .  trim(`echo \$PATH`) . ':/usr/local/bin');




////////////////////////////////////////////////////////////////////////////////
//PULL THE BRANCH AND SUBMODULES
////////////////////////////////////////////////////////////////////////////////
chdir($af->config->github['path']);

$commands = [
	'uname -norsm',
	'pwd',
	'whoami',
	'which git',
	'git version',
	'git stash',
	'git pull origin ' . $af->config->github['branch'],
	'git status',
	'git submodule init',
	'git submodule update',
	'git submodule status',
];

foreach ($commands as $command) {
	echo '> ' . $command . "\n";
	echo rtrim((string)shell_exec($command . ' 2>&1')) . "\n\n";
}
