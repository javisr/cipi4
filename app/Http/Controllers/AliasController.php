<?php

namespace App\Http\Controllers;

use App\Models\Site;
use App\Models\Alias;
use Illuminate\Http\Request;

class AliasController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $site)
    {
        $request->validate($this->aliasValidation());

        $site = Site::findOrFail('site', $site);

        Alias::create([
            'domain' => $request->domain,
            'site_id' => $site->id,
        ]);

        // TODO - Job Create Alias (with info)

        return redirect('/sites/'.$site->site.'/edit/aliases')->with([
            'aliasCreated' => true,
            'domain' => $request->domain,
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($site, $id)
    {
        $alias = Alias::findOrFail($id);

        if (! $site != $alias->site->site) {
            abort(404);
        }

        $domain = $alias->domain;

        // TODO - Job Alias Delete

        $alias->delete();

        return redirect('/sites/'.$site.'/edit/aliases')->with([
            'aliasDeleted' => true,
            'domain' => $domain,
        ]);
    }
}
