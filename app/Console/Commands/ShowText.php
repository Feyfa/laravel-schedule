<?php

namespace App\Console\Commands;

use App\Models\Murid;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class ShowText extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'show-text';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hapus 2 lead di tabel murid setiap 10 detik';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $data = Murid::where('id', 1)
                     ->where('status', 'active')
                     ->first();

        if($data)
        {
            $dataDihapus = 3;
            $sisaData = $data->leads % $dataDihapus;
    
            if(($sisaData === 0) || ($sisaData !== 0 && $sisaData !== $data->leads))
            {
                $data->leads = $data->leads - $dataDihapus;
    
                if($data->leads === 0) 
                    $data->status = "stop";
    
                $data->save();
    
                $this->info("$dataDihapus leads telah dihapus");
            }
            else
            {
                $data->leads = $data->leads - $sisaData;
    
                if($data->leads === 0) 
                    $data->status = "stop";
                
                $data->save();
            
                $this->info("$sisaData leads telah dihapus");
            }
        }
        else
        {
            $this->info("campaign sudah stop");
        }
    }
}
