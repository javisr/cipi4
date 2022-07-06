<?php

namespace App\Http\Controllers;

class AjaxController extends Controller
{
    public function checkUniqueDomain($domain, $site_id = null)
    {
        if ($site_id &&
            (
                Site::where('domain', $domain)->whereNot('site_id', $site_id)->first() ||
                Alias::where('domain', $domain)->first()
            )
        ) {
            return true;
        }

        if (! $site_id &&
            (
                Site::where('domain', $domain)->first() ||
                Alias::where('domain', $domain)->first()
            )
        ) {
            return true;
        }

        return false;
    }
}
