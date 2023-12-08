<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ToDoRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
class TodoController extends Controller
{
    private $toDoRepository;
    private $user;
    private $todos;
    private $todo;
    private $todaData;

    public function __construct()
    {
        $this->toDoRepository = new ToDoRepository();
    }

    public function index()
    {
        $this->user = Auth::user();
        if(!$this->user){
            return redirect()->to('login');  
        }
        $this->todos = $this->toDoRepository->all($this->user->id);
        return view('todo.list', ['todos' => $this->todos]);
    }
    
    public function create()
    {
        return view('todo.add');
    }
    public function store(Request $request)
    {
        $this->user = Auth::user();
        $input = $request->input();
        $this->todaData = [
            "title" => $input["title"],
            "description" => $input["description"],
            "user_id" => $this->user->id,
            "status" => $input["status"]
        ];
        $todoStatus = $this->toDoRepository->create($this->todaData);
        if ($todoStatus) {
            $message = 'Todo successfully added';
            $type = 'success';
        } else {
            $message = 'Oops, something went wrong. Todo not saved';
            $type = 'error';
        }

        return redirect('todo')->with($type, $message);
    }

    public function show($id)
    {
        $this->user = Auth::user();
        $this->todo = $this->toDoRepository->show(['user_id' => $this->user->id, 'id' => $id]);
        if (!$this->todo) {
            return redirect('todo')->with('error', 'Todo not found');
        }
        return view('todo.view', ['todo' => $this->todo]);
    }

    public function edit($id)
    {
        $this->user = Auth::user();
        $this->todo = $this->toDoRepository->show(['user_id' => $this->user->id, 'id' => $id]);
        if ($this->todo) {
            return view('todo.edit', ['todo' => $this->todo]);
        } else {
            return redirect('todo')->with('error', 'Todo not found');
        }
    }

    public function update(Request $request, $id)
    {
        $this->user = Auth::user();
        $this->todo = $this->toDoRepository->find($id);
        if (!$this->todo) {
            return redirect('todo')->with('error', 'Todo not found.');
        }
        $input = $request->input();
        $this->todaData = [
            "title" => $input["title"],
            "description" => $input["description"],
            "user_id" => $this->user->id,
            "status" => $input["status"]
        ];
        $todoStatus = $this->toDoRepository->update($this->todaData, $this->todo->id);
        if ($todoStatus) {
            return redirect('todo')->with('success', 'Todo successfully updated.');
        } else {
            return redirect('todo')->with('error', 'Oops something went wrong. Todo not updated');
        }    
    }

    public function destroy($id)
    {
        $this->user = Auth::user();
        $this->todo = $this->toDoRepository->show(['user_id' => $this->user->id, 'id' => $id]);
        $respStatus = $respMsg = '';
        if (!$this->todo) {
            $respStatus = 'error';
            $respMsg = 'Todo not found';
        }
        $todoDelStatus = $this->toDoRepository->delete($id);
        if ($todoDelStatus) {
            $respStatus = 'success';
            $respMsg = 'Todo deleted successfully';
        } else {
            $respStatus = 'error';
            $respMsg = 'Oops something went wrong. Todo not deleted successfully';
        }
        return redirect('todo')->with($respStatus, $respMsg);
    }
}
