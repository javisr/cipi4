<?php

namespace App\Http\Controllers;

use App\Models\Alias;
use App\Models\Site;
use phpseclib3\Net\SSH2;

class AjaxController extends Controller
{
    public function checkUniqueDomain($domain, $site = null)
    {
        if ($site &&
            (
                Site::where('domain', $domain)->whereNot('site', $site)->first() ||
                Alias::where('domain', $domain)->first()
            )
        ) {
            return response()->json([
                'domain' => $domain,
                'site' => $site,
                'checkUniqueDomain' => 'KO',
            ], 419);
        }

        if (! $site &&
            (
                Site::where('domain', $domain)->first() ||
                Alias::where('domain', $domain)->first()
            )
        ) {
            return response()->json([
                'domain' => $domain,
                'site' => $site,
                'checkUniqueDomain' => 'KO',
            ], 419);
        }

        return response()->json([
            'domain' => $domain,
            'site' => $site,
            'checkUniqueDomain' => 'OK',
        ]);
    }

    public function checkServerStatus()
    {
        try {
            $ssh = new SSH2(config('cipi.ssh_host'), config('cipi.ssh_port'));
            $ssh->login(config('cipi.ssh_user'), config('cipi.ssh_pass'));
            $ssh->setTimeout(360);
            $status = $ssh->exec('echo "`LC_ALL=C top -bn1 | grep "Cpu(s)" | sed "s/.*, *\([0-9.]*\)%* id.*/\1/" | awk \'{print 100 - $1}\'`%;`free -m | awk \'/Mem:/ { printf("%3.1f%%", $3/$2*100) }\'`;`df -h / | awk \'/\// {print $(NF-1)}\'`"');
            $ssh->exec('exit');
        } catch (\Throwable $th) {
            return response()->json([
                'message' => __('Something went wrong!'),
            ], 503);
        }

        $status = str_replace('%', '', $status);
        $status = str_replace("\n", '', $status);
        $status = explode(';', $status);

        return response()->json([
            'cpu' => $status[0],
            'ram' => $status[1],
            'hdd' => $status[2],
        ]);
    }

    public function getDeployKey($username)
    {
        try {
            $ssh = new SSH2(config('cipi.ssh_host'), config('cipi.ssh_port'));
            $ssh->login(config('cipi.ssh_user'), config('cipi.ssh_pass'));
            $ssh->setTimeout(360);
            $key = $ssh->exec('cat /home/'.$username.'/rsa/public.key');
            $ssh->exec('exit');
        } catch (\Throwable $th) {
            return 'Something went wrong!';
        }

        return $key;
    }
}
