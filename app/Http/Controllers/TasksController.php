<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = [];
        if($task->user_id == $user->id){
            $user = \Auth::user();
            $tasks = $user->tasks()->get();
            $data = [
                'user' => $user,
                'tasks' => $tasks
            ];
            //return view('dashboard', $tasks);
        }
        return view('dashboard', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("tasks.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $user = \Auth::user();
            $request->validate([
                "content" => "required|max:255",
                "status" => "required|max:10",
            ]);
            $task = new Task;
            $task->content = $request->content;
            $task->status = $request->status;
            $task->user_id = $user->id;
            $task->save();

        return redirect("/");
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = \Auth::user();
        $task = Task::findOrFail($id);
        if($task->user_id == $user->id){
            // メッセージ詳細ビューでそれを表示
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = \Auth::user();
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        if($task->user_id == $user->id){
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::findOrFail($id);
        if($task->user_id == $user->id){
            $request->validate([
                "content" => "required|max:255",
                "status" => "required|max:10"
            ]);
            // idの値でメッセージを検索して取得
            // メッセージを更新
            $task->content = $request->content;
            $task->status = $request->status;
            $task->save();
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        if($task->user_id == $user->id){
            // idの値でメッセージを検索して取得
            // メッセージを削除
            $task->delete();
        }
        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
