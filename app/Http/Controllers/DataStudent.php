<?php

namespace App\Http\Controllers;
 use App\Models\DataStudent as ModelsDataStudent;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Session;

class DataStudent extends Controller
{
    function index(){
        $data = ModelsDataStudent::all();
        return view('data_student.index', ['data' => $data]);
    }
    function tambah(){
           return view('data_student.tamdah');


    }

    function edit($id){

     $data = ModelsDataStudent::find($id);
    //  return $data;
    $data = ModelsDataStudent::where('id', $id)->get();

        return view('data_student.edit', ['data' =>$data]);
    }

    function deleta( Request $request){

        ModelsDataStudent::where('id',$request->id)->delete();

        Session::flash('success', 'Delete success');

          return redirect('/datastudent');


    }

    function create(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'nim' => 'required|max:8',
            'force' => 'required|min:2|max:2',
            'major' => 'required',
        ], [
            'name.required' => 'Name is mandatory',
            'name.min' => 'The name field must be at least 3 characters long.',
            'email.required' => 'Email must be filled in',
            'email.email' => 'Format Email Invalid',
            'nim.required' => 'Must be filled in',
            'nim.max' => 'NIM max 8 Digit',
            'force.required' => 'Forces are required to be filled in',
            'force.min' => 'Enter 2 numbers at the end of the year, for example: 2022 (22)',
            'force.max' => 'Enter 2 numbers at the end of the year, for example: 2022 (22)',
            'major.required' => 'Majors are required to be filled in',
        ]);

        ModelsDataStudent::insert([
            'name' => $request->name,
            'email' => $request->email,
            'nim' => $request->nim,
            'force' => $request->force,
            'major' => $request->major,
        ]);

        Session::flash('success', 'Data added successfully');

        return redirect('/datastudent')->with('success', 'Successfully Added Data');
    }
    function change(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'nim' => 'required|min:8|max:8',
            'force' => 'required|min:2|max:2',
            'major' => 'required',
        ], [
            'name.required' => 'Name must be filled in',
            'name.min' => 'The name field must be at least 3 characters long.',
            'email.required' => 'Email must be filled in',
            'email.email' => 'Format Email Invalid',
            'nim.required' => 'Must be filled in',
            'nim.max' => 'NIM max 8 Digit',
            'nim.min' => 'NIM min 8 Digit',
            'force.required' => 'Forces are required to be filled in',
            'force.min' => 'Enter 2 numbers at the end of the year, for example: 2022 (22)',
            'force.max' => 'Enter 2 numbers at the end of the year, for example: 2022 (22)',
            'major.required' => 'Majors are required to be filled in',
        ]);

        $datastudent = ModelsDataStudent::find($request->id);

        $datastudent->name = $request->name;
        $datastudent->email = $request->email;
        $datastudent->nim = $request->nim;
        $datastudent->angkatan = $request->angkatan;
        $datastudent->jurusan = $request->jurusan;
        $datastudent->save();

        Session::flash('success', 'Successfully Changed Data');

        return redirect('/datastudent');
    }

}
