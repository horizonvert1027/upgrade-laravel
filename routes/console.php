<?php

use Illuminate\Foundation\Inspiring;



Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
});


Artisan::command('alllogs:clear', function() {
    exec('echo "" > ' . ('storage/logs/*.log'));
    exec('echo "" > ' . ('public/logs/*.log'));
    exec('rm -f ' . storage_path('logs/*.log'));
    exec('rm -f ' . base_path('*.log'));
    $this->comment('Logs have been cleared!');
})->describe('Clear log files');


Artisan::command('allsessions:clear', function() {
    exec('rm -f ' . ('storage/framework/sessions/*'));
    $this->comment('Sessions have been cleared!');
})->describe('Clear Sessions files');
