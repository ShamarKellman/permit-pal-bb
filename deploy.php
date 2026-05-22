<?php

declare(strict_types=1);

namespace Deployer;

require 'recipe/laravel.php';

set('application', 'Permit Pal BB');
set('repository', 'git@github.com:ShamarKellman/permit-pal-bb.git');
set('git_tty', false);
set('keep_releases', 3);
set('composer_options', '--prefer-dist --no-interaction --optimize-autoloader --no-dev');

host('production')
    ->setHostname(getenv('DEPLOY_HOST') ?: '')
    ->setRemoteUser(getenv('DEPLOY_USER') ?: '')
    ->set('http_user', getenv('DEPLOY_HTTP_USER') ?: '')
    ->setPort((int) (getenv('DEPLOY_SSH_PORT') ?: 22))
    ->setDeployPath(getenv('DEPLOY_PATH') ?: '/var/www/bhc');

set('shared_files', ['.env']);
set('shared_dirs', ['storage']);
set('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

task('deploy:assets', function (): void {
    runLocally('npm ci');
    runLocally('npm run build');
    upload(__DIR__.'/public/build/', '{{release_path}}/public/build/');
});

after('deploy:update_code', 'deploy:assets');
after('deploy:failed', 'deploy:unlock');
