<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

use Symfony\Component\HttpFoundation\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //Deactivate
    public function deactivate(Request $request)
    {
        try {
            $table   = $request->table;
            $id      = $request->id;
            if (!empty($id)) {
                updateData($table, $id, ['status' => '0', 'updated_at' => Carbon::now()]);
                return myReturn('success', 'Successfully Deactivated');
            }
        } catch (\Throwable $th) {
            dd($th);
            return myReturn('success', 'Failed Deactivation');
        }
    }

    //Activate
    public function activate(Request $request)
    {
        try {
            $table   = $request->table;
            $id   = $request->id;
            if (!empty($id)) {
                updateData($table, $id, ['status' => '1', 'updated_at' => Carbon::now()]);
                return myReturn('success', 'Successfully Activated');
            }
        } catch (\Throwable $th) {
            dd($th);
            return myReturn('success', 'Failed Activation');
        }
    }

    // Add 
    public function add(Request $request)
    {
        try {
            $table   = $request->table;
            $data = [
                'status' => ($request->has('status') ? $request->status : '1'),
                'created_at' => date('Y-m-d H:i:s')
            ];
            insertForm($table, $request->all(), $data);

            return myReturn('success', 'Successfully Created.');
        } catch (\Throwable $th) {
            dd($th);
            return myReturn('error', 'Creation Failed.');
        }
    }

    // Edit
    public function edit(Request $request)
    {
        try {
            $table   = $request->table;
            $id      = $request->id;
            $request->request->remove('id');

            updateForm($table, $id, $request->all(), ['updated_at' => Carbon::now()]);
            return myReturn('success', 'Successfully Updated');
        } catch (\Throwable $th) {
            return myReturn('error', 'Failed Update.');
        }
    }

    // DELETE
    public function delete(Request $request)
    {
        try {
            $table   = $request->table;
            $id      = $request->id;
            deleteData($table, ['id' => $id]);

            return myReturn('success', 'Successfully Deleted');
        } catch (\Throwable $th) {
            return myReturn('error', 'Failed Update.');
        }
    }

 
}
