<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Alias;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiteController extends Controller
{
    private function AliasValidation()
    {
        return [
            'domain' => [
                'required',
                'unique:aliases',
            ],
        ];
    }

    private function siteSettingsValidation($id = null)
    {
        if ($id) {
            return [
                'domain' => [
                    'required',
                    'unique:sites,domain,'.$id,
                ],
                'php' => [
                    'required',
                    Rule::in(config('cipi.php_versions')),
                ],
            ];
        }

        return [
            'username' => [
                'required',
                'unique:sites',
            ],
            'domain' => [
                'required',
                'unique:sites',
            ],
            'php' => [
                'required',
                Rule::in([
                    '8.1',
                ]),
            ],
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return datatables(
            Site::select(
                'domain',
                'username',
                'path',
                'php',
                'site'
            )->withCount('aliases')
             ->get()
        )->toJson();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sites.create', [
            'username' => config('cipi.username_prefix').uniqid(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->siteSettingsValidation());

        $site = Site::create([
            'site' => Str::uuid(),
            'username' => $request->username,
            'domain' => Str::lower($request->domain),
            'path' => Str::lower($request->path),
            'php' => $request->php,
        ]);

        $userPwd = Str::random(20);
        $dbPwd = Str::random(16);

        return redirect('/sites/'.$site->site.'/edit')->with([
            'siteCreated' => true,
            'userPwd' => $userPwd,
            'dbPwd' => $dbPwd,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($site)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($site, $section = 'settings')
    {
        $site = Site::where('site', $site)
                    ->with('aliases')
                    ->firstOrFail();

        switch ($section) {
            case 'delete':
                return view('sites.edit.delete', $site);

                break;

            case 'security':
                return view('sites.edit.security', $site);

                break;

            case 'queue':
                return view('sites.edit.queue', $site);

                break;

            case 'ssl':
                return view('sites.edit.ssl', $site);

                break;

            case 'deploy':
                return view('sites.edit.deploy', $site);

                break;

            case 'enviroment':
                return view('sites.edit.enviroment', $site);

                break;

            case 'packages':
                return view('sites.edit.packages', $site);

                break;

            case 'nginx':
                return view('sites.edit.nginx', $site);

                break;

            case 'aliases':
                return view('sites.edit.aliases', $site);

                break;

            default:
                return view('sites.edit.settings', $site);

                break;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $site, $section = 'settings')
    {
        $site = Site::where('site', $site)->firstOrFail();

        switch ($section) {

            case 'aliases':

                $request->validate($this->aliasValidation());

                Alias::create([
                    'domain' => $request->domain,
                    'site_id' => $site->id,
                ]);

                // TODO - Job Create Alias (with info)

                return redirect('/sites/'.$site->site.'/edit/aliases')->with([
                    'aliasCreated' => true,
                    'domain' => $request->domain,
                ]);

                break;

            case 'ssl':

                // TODO - Job SSL creation

                return redirect('/sites/'.$site->site.'/edit/ssl')->with([
                    'sslGenerated' => true,
                ]);

                break;

            case 'deploy':
                $site->repo = $request->repo;
                $site->branch = $request->branch;
                $site->deploy = $request->deploy;
                $site->save();

                // TODO - Job Site Update

                return redirect('/sites/'.$site->site.'/edit/deploy')->with([
                    'deployUpdated' => true,
                ]);

                break;

            case 'packages':
                $site->packages = $request->packages;
                $site->save();

                // TODO - Job Site Update

                return redirect('/sites/'.$site->site.'/edit/packages')->with([
                    'packagesUpdated' => true,
                ]);

                break;

            case 'enviroment':
                $site->enviroment = $request->enviroment;
                $site->save();

                // TODO - Job Site Update

                return redirect('/sites/'.$site->site.'/edit/enviroment')->with([
                    'enviromentUpdated' => true,
                ]);

                break;

            case 'nginx':

                // TODO - Attenzione... prima di salvare bisogna fare nginx -t e vedere se ci sono errori.
                // Si torna poi o con errore o con success!

                $site->nginx = $request->nginx;
                $site->save();

                // Ritorna o Updated o nginxError!!!
                return redirect('/sites/'.$site->site.'/edit/nginx')->with([
                    'nginxUpdated' => true,
                ]);
                // return redirect('/sites/'.$site->site.'/edit/nginx')->with([
                //     'nginxError' => true,
                // ]);

            break;

            case 'queue':
                $site->supervisord = $request->supervisord;
                $site->save();

                // TODO - Job Queue Update

                return redirect('/sites/'.$site->site.'/edit/queue')->with([
                    'queueUpdated' => true,
                ]);

                break;

            default:
                $request->validate($this->siteSettingsValidation($site->id));

                $site->domain = $request->domain;
                $site->path = $request->path;
                $site->php = $request->php;
                $site->save();

                // TODO - Job Site Update

                return redirect('/sites/'.$site->site.'/edit/settings')->with([
                    'siteUpdated' => true,
                ]);

                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($site)
    {
        $site = Site::where('site', $site)->firstOrFail();

        $domain = $site->domain;

        // TODO - Job Site Delete

        $site->delete();

        return redirect('/sites')->with([
            'siteDeleted' => true,
            'domain' => $domain,
        ]);
    }

    public function password($site)
    {
        $site = Site::where('site', $site)->firstOrFail();

        $userPwd = Str::random(20);

        // TODO - Job Password Change

        return redirect('/sites/'.$site->site.'/edit/security')->with([
            'passwordChanged' => true,
            'password' => $userPwd,
        ]);
    }

    public function database($site)
    {
        $site = Site::where('site', $site)->firstOrFail();

        $dbPwd = Str::random(16);

        // TODO - Job Database Pwd Change

        return redirect('/sites/'.$site->site.'/edit/security')->with([
            'databaseChanged' => true,
            'password' => $dbPwd,
        ]);
    }
}
