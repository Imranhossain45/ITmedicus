<?php

namespace App\Http\Controllers\Backend;

use App\Models\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeCompany = Company::where('status', 'publish')->get();
        $draftCompany = Company::where('status', 'draft')->get();
        $trashCompany = Company::onlyTrashed()->orderBy('id', 'desc')->get();
        return view('backend.company.index', compact('activeCompany', 'draftCompany', 'trashCompany'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.company.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logo = $request->file('logo');
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'website' => 'required',
            'logo' => 'required|mimes:png,jpg,jpeg|max:2000',
        ]);
        if ($logo) {
            $logoName = uniqid() . '.' . $logo->getClientOriginalExtension();
            Image::make($logo)->save(public_path('storage/company/' . $logoName));
        }
        Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $logoName,

        ]);
        return back()->with('success', 'Company Added Successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company)
    {
        return view('backend.company.edit',compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company)
    {
        $logo = $request->file('logo');
        $request->validate([
            'name' => 'required|unique:companies,name',
            'email' => 'required',
            'website' => 'required',
            'logo' => 'required|mimes:png,jpg,jpeg|max:2000',
        ]);
        if ($logo) {
            $path = public_path('storage/company/' . $company->logo);
            if (file_exists($path)) {
                unlink($path);
            }

            $logoName = uniqid() . '.' . $logo->getClientOriginalExtension();
            Image::make($logo)->save(public_path('storage/company/' . $logoName));
        }
        $company->update([
            'name' => $request->name,
            'email' => $request->email,
            'website' => $request->website,
            'logo' => $logoName,

        ]);
        return redirect(route('backend.company.index'))->with('success', 'Company info Edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $company)
    {
        $company->status == 'draft';
        $company->save();
        $company->delete();
        return back()->with('success', 'Company info Trashed!');
    }
    public function status(Company $company)
    {
        if ($company->status == 'publish') {
            $company->status = 'draft';
            $company->save();
        } else {
            $company->status = 'publish';
            $company->save();
        }
        return back()->with('success', $company->status == 'publish' ? 'Company info Published' : 'Company info Drafted');
    }
    public function reStore($id)
    {
        $company = Company::onlyTrashed()->find($id);
        $company->restore();
        return back()->with('success', 'Company info Restored');
    }
    public function permDelete($id)
    {
        $company = Company::onlyTrashed()->find($id);
        $company->forceDelete();
        return back()->with('success', 'Company Item Deleted');
    }
}
