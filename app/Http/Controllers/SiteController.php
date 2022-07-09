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
                    Rule::in([
                        '8.1',
                    ]),
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

        $userPwd = Str::random(28);
        $dbPwd = Str::random(20);

        // TODO - Job Create Site (with $site, $userPwd, $dbPwd)

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

            case 'ssl':
                return view('sites.edit.ssl', $site);

                break;

            case 'deploy':
                return view('sites.edit.deploy', $site);

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
}
