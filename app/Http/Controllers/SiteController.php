<?php

namespace App\Http\Controllers;

use App\Models\Site;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SiteController extends Controller
{

    private function siteSettingsValidation()
    {
        return [
            'username' => [
                'required',
                'unique:sites'
            ],
            'domain' => [
                'required',
                'unique:sites'
            ],
            'path' => [
                'required'
            ],
            'php' => [
                'required',
                Rule::in([
                    '8.1'
                ])
            ]
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

        // TODO - Job Create Site

        return redirect('/sites/edit/'.$site->site);
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
        $site = Site::where('site', $site)->first();

        switch ($section) {
            case 'aliases':
                return view('sites.edit.settings', $site);

                break;

            case 'deployment':
                return view('sites.edit.settings', $site);

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
    public function update(Request $request, $site)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($site)
    {
        //
    }
}
