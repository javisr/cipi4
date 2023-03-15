<?php

namespace App\Http\Controllers;

use App\Models\Alias;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class AliasController extends Controller
{
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $site)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($site, int $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($site, $section, int $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $site, $section, int $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($site, int $id): RedirectResponse
    {
        $alias = Alias::findOrFail($id);

        if ($site != $alias->site->site) {
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
