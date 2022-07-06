<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Alias;

class AjaxController extends Controller
{
    public function checkUniqueDomain($domain, $site=null)
    {
        if($site &&
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

        if(!$site &&
            (
                Site::where('domain', $domain)->first() ||
                Alias::where('domain', $domain)->first()
            )
        ) {
            return response()->json([
                'domain' => $domain,
                'site' => $site,
                'checkUniqueDomain' => 'KO'
            ], 419);
        }

        return response()->json([
            'domain' => $domain,
            'site' => $site,
            'checkUniqueDomain' => 'OK'
        ]);
    }
}
