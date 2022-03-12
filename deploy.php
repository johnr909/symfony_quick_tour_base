<?php
namespace Deployer;

require 'recipe/symfony.php';

// Project name
set('application', 'symfony_quick_tour_base');

// Project repository
set('repository', 'git@github.com:johnr909/symfony_quick_tour_base.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

set('clear_paths_use_sudo', true);
set('clear_paths', [
    '.git',
    '.gitignore',
    'var',
    'symfony_quick_tour_base.sublime-project',
    'symfony_quick_tour_base.sublime-workspace',
]);

// Writable dirs by web server 
add('writable_dirs', ['/var/www/html/symfony-skel']);

// Hosts

host('symfony.skel')
    ->set('deploy_path', '/var/www/html/symfony-skel');    
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
    run("chown -R www-data:web-dev /var/www/html/symfony-skel");
    writeln('<info>Deployment is done.</info>');

});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

