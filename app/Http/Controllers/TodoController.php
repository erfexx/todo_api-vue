<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Todo as TodoResource;
use Carbon\Carbon;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $todos = new TodoResource(Todo::orderBy('is_finish', 'asc')->get());

        return $todos;
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
    public function store(Request $request)
    {
        //
        DB::beginTransaction();
        try {
            $task = $request->task;
            $created_at = Carbon::now();

            $todo = new Todo();
            $todo->task = $task;
            $todo->is_finish = false;
            $todo->created_at = Carbon::now();

            if ($todo->save()) {
                DB::commit();
                $status = 'success';
                $message = 'Insert Success';
            }
        } catch (\Exception $e) {
            $status = 'fail';
            $message = $e->getMessage();
            DB::rollback();
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $todo = new TodoResource(Todo::findOrFail($id));

        return $todo;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    public function update(Request $request, $id)
    {
        //
        DB::beginTransaction();
        try {
            $task = $request->task;
            $updated_at = Carbon::now();
            $status = $request->is_finish;

            $todo = Todo::findOrFail($id);
            $todo->task = $task;
            $todo->is_finish = $status;
            $todo->updated_at = Carbon::now();

            if ($todo->save()) {
                DB::commit();
                $status = 'success';
                $message = 'Update Success';
            }
        } catch (\Exception $e) {
            $status = 'fail';
            $message = $e->getMessage();
            DB::rollback();
        }
        return response()->json([
            'status' => $status,
            'message' => $message
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        DB::beginTransaction();
        try {

            $todo = Todo::findOrFail($id);

            if ($todo->delete()) {
                DB::commit();
                $status = 'success';
                $message = 'Delete Success';
            }
        } catch (\Exception $e) {
            $status = 'fail';
            $message = $e->getMessage();
            DB::rollback();
        }

        return response()->json([
            'status' => $status,
            'message' => $message
        ], 200);
    }
}
