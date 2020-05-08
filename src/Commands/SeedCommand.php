<?php
/**
 * Created by PhpStorm.
 * UserParam: dyangalih
 * Date: 2019-01-25
 * Time: 11:54
 */

namespace WebAppId\Member\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SeedCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'webappid:member:seed';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed Member database';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Artisan::call('db:seed', ['--class' => 'WebAppId\Member\Seeds\DatabaseSeeder']);
        $this->info('Seeded: WebAppId\Member\Seeds\MemberSeeder');
    }
}
