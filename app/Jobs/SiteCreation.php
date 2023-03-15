<?php

namespace App\Jobs;

use phpseclib3\Net\SSH2;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SiteCreation implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $site;
    protected $userPwd;
    protected $dbPwd;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($site, $userPwd, $dbPwd)
    {
        $this->site = $site;
        $this->userPwd = $userPwd;
        $this->dbPwd = $dbPwd;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $ssh = new SSH2(config('cipi.ssh_host'), config('cipi.ssh_port'));
        $ssh->login(config('cipi.ssh_user'), config('cipi.ssh_pass'));
        $ssh->setTimeout(360);
        $ssh->exec('echo '.config('cipi.ssh_pass').' | sudo -S sudo unlink newsite');
        $ssh->exec('echo '.config('cipi.ssh_pass').' | sudo -S sudo wget '.config('app.url').'/sh/newsite');
        $ssh->exec('echo '.config('cipi.ssh_pass').' | sudo -S sudo dos2unix newsite');
        $ssh->exec('echo '.config('cipi.ssh_pass').' | sudo -S sudo bash newsite -dbr '.$this->dbPwd.' -u '.$this->site->username.' -p '.$this->userPwd.' -dbp '.$this->dbPwd.' -php '.$this->site->php.' -id '.$this->site->site_id.' -r '.config('app.url').' -b '.$this->site->basepath);
        $ssh->exec('echo '.config('cipi.ssh_pass').' | sudo -S sudo unlink newsite');
        $ssh->exec('exit');
    }
}
