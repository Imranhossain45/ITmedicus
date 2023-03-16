<?php

namespace App\Http\Controllers\Backend;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activeEmployee = Employee::where('status', 'publish')->get();
        $draftEmployee = Employee::where('status', 'draft')->get();
        $trashEmployee = Employee::onlyTrashed()->orderBy('id', 'desc')->get();
        return view('backend.employee.index', compact('activeEmployee', 'draftEmployee', 'trashEmployee'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companies = Company::all();
        return view('backend.employee.create',compact('companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $photo = $request->file('photo');
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'company' => 'required',
            'phone' => 'required|integer',
            'photo' => 'required|mimes:png,jpg,jpeg|max:2000',
        ]);
        if ($photo) {
            $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->save(public_path('storage/employee/' . $photoName));
        }
        Employee::create([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company,
            'phone' => $request->phone,
            'photo' => $photoName,

        ]);
        return back()->with('success', 'Employee info Added Successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        $companies = Company::all();
        return view('backend.employee.edit',compact('employee', 'companies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        $photo = $request->file('photo');
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'company' => 'required',
            'phone' => 'required|integer',
            'photo' => 'required|mimes:png,jpg,jpeg|max:2000',
        ]);
        if ($photo) {
            $path=public_path('storage/employee/' . $employee->photo);
            if(file_exists($path)){
                unlink($path);
            }

            $photoName = uniqid() . '.' . $photo->getClientOriginalExtension();
            Image::make($photo)->save(public_path('storage/employee/' . $photoName));
        }
        $employee->update([
            'name' => $request->name,
            'email' => $request->email,
            'company_id' => $request->company,
            'phone' => $request->phone,
            'photo' => $photoName,

        ]);
        return redirect(route('backend.employee.index'))->with('success', 'Employee info Edited!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        $employee->status == 'draft';
        $employee->save();
        $employee->delete();
        return back()->with('success', 'Employee info Trashed!');
    }
    public function status(Employee $employee){
        if($employee->status == 'publish'){
            $employee->status = 'draft';
            $employee->save();
        }else{
            $employee->status = 'publish';
            $employee->save();
        }
        return back()->with('success', $employee->status == 'publish' ? 'Employee info Published' : 'Employee Info Drafted');
    }

    public function reStore($id){
        $employee = Employee::onlyTrashed()->find($id);
        $employee->restore();
        return back()->with('success', 'Employee info Restored');
    }
    public function permDelete($id){
        $employee = Employee::onlyTrashed()->find($id);
        $employee->forceDelete();
        return back()->with('success', 'Employee info Deleted');
    }
}
