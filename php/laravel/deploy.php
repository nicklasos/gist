<?php
/** @noinspection PhpIncludeInspection */
require 'recipe/common.php';

server('prod', '127.0.0.2')
    ->env('deploy_path', '/var/www/site')
    ->user('root')
    ->identityFile()
    ->stage('production');

set('repository', 'git@github.com:username/repository.git');

set('shared_dirs', [
    'storage/app',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
    'public/boxes',
    'public/items',
    'public/sitemap',
    'public/other'
]);

set('keep_releases', 25);

set('shared_files', ['.env']);

set('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/logs',
    'public/boxes',
    'public/sitemap',
]);

task('deploy:php:reload', function () {
    run('sudo service php7.0-fpm reload');
})->desc('Reload PHP-FPM');

task('artisan:config:clear', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan config:clear');
})->desc('Disable maintenance mode');

task('artisan:up', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan up');
})->desc('Disable maintenance mode');

task('artisan:down', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan down');
})->desc('Enable maintenance mode');

task('artisan:migrate', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan migrate --force');
})->desc('Execute artisan migrate');

task('artisan:migrate:rollback', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan migrate:rollback --force');
})->desc('Execute artisan migrate:rollback');

task('artisan:migrate:status', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan migrate:status');
})->desc('Execute artisan migrate:status');

task('artisan:db:seed', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan db:seed --force');
})->desc('Execute artisan db:seed');

task('artisan:cache:clear', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan cache:clear');
})->desc('Execute artisan cache:clear');

task('artisan:config:cache', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan config:cache');
})->desc('Execute artisan config:cache');

task('artisan:route:cache', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan route:cache');
})->desc('Execute artisan route:cache');

task('artisan:route:trans:cache', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan route:trans:cache');
})->desc('Execute artisan route:trans:cache');

task('artisan:view:clear', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan view:clear');
})->desc('Execute artisan route:trans:cache');

task('artisan:queue:restart', function () {
    run('{{bin/php}} {{deploy_path}}/current/artisan queue:restart');
})->desc('Execute artisan queue:restart');

task('deploy:public_disk', function () {
    run('if [ -d $(echo {{release_path}}/public/storage) ]; then rm -rf {{release_path}}/public/storage; fi');
    run('mkdir -p {{deploy_path}}/shared/storage/app/public');
    run('ln -nfs {{deploy_path}}/shared/storage/app/public {{release_path}}/public/storage');
})->desc('Make symlink for public disk');

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:vendors',
    'deploy:writable',
    'deploy:symlink',
    'cleanup',
    //    'artisan:cache:clear',
    'artisan:view:clear',
    'artisan:config:cache',
    'artisan:config:clear',
    'artisan:migrate',
    'artisan:route:trans:cache',
    'deploy:php:reload',
    'artisan:queue:restart',
])->desc('Deploy project');

after('deploy', 'success');

set('copy_dirs', ['vendor']);

before('deploy:vendors', 'deploy:copy_dirs');