<?php

namespace App\Console\Commands;

use App\Events\RealTimeTranning;
use App\Events\WinnerNumberGenerted;
use Illuminate\Console\Command;

class GameExcutor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'game:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start excuting the game';
    private $time = 15;
    public function __construct(){
        parent::__construct();
    }
    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->info('Bắt đầu chạy vui lòng xem hiển thị hệ thống bên trong laravel log');
        while (true){
            broadcast( new RealTimeTranning($this->time . 's'));
            $this->time--;
            sleep(1);
            if ($this->time === 0){
                $this->time = "watting to start";
                broadcast( new RealTimeTranning($this->time));
                broadcast( new WinnerNumberGenerted(mt_rand(1,12)));
                sleep(5);
                $this->time = 15;
            }
        }
    }
}
