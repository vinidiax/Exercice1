<?php

namespace App\Http\Controllers;

use App\Task;
use function collect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use function is_bool;


class TasksController extends Controller
{
   public function index()
   {
	   $tasks = DB::select("SELECT * FROM tasks ORDER BY sort_order ASC");
		
		if(!count($tasks) > 0){
		    return [
			    'message' => 'Wow. You have nothing else to do. Enjoy the rest of your day!'
		    ];
		}
	
	   return response()->json($tasks,200);
   }
	
	public function store(Request $request)
	{
		$validatorResponse = $this->validateRequest($request);
		
		if(!is_bool($validatorResponse))
		{
			return $validatorResponse;
		}
		
		$task = new Task();
		
		$isInsert = true;
		
		$this->fillAndSaveTask($task,$request,$isInsert);
		
		return response()->json("",201);
	}
	
	public function update(Request $request,$id)
	{
		$task = Task::find($id);
		
		if(!empty($task)) {
			
			$validatorResponse = $this->validateRequest($request);
			
			if(!is_bool($validatorResponse))
			{
				return response()->json($validatorResponse);
			}
			
			if($task->sort_order != $request->json('sort_order')) {
				$this->reorderTasks($task->sort_order,$request->json('sort_order'));
			}
			
			$this->fillAndSaveTask($task,$request);
			
			return response()->json($task,200);
		}
		return [
			'message' => 'Are you a hacker or something? The task you were trying to edit doesn\'t exist.'
		];
	}
	
	public function destroy($id)
	{
		$task = Task::find($id);
		
		if(!empty($task)){
			Task::destroy($id);
			return response()->json('',200);
		}
		
		return[
			'message' => 'Good news! The task you were trying to delete didn\'t even exist.'
		];
	}
	
	private function reorderTasks($actualOrder, $expectedOrder)
	{
		if($actualOrder > $expectedOrder)
		{
			DB::update("UPDATE tasks SET sort_order = sort_order + 1 WHERE sort_order >= {$expectedOrder} and sort_order <= $actualOrder");
			return;
		}
		
		DB::update("UPDATE tasks SET sort_order = sort_order - 1 WHERE sort_order > {$actualOrder} and sort_order <= $expectedOrder");
	}
	
	private function getNextOrder()
	{
		$orderNumber =  DB::table('tasks')->select('sort_order')->orderBy('sort_order','desc')->take(1)->get();
		
		if(empty($orderNumber)){
			return 1;
		}
		
		$orderNumber = json_decode(trim($orderNumber,'[]'),true);
		
		return $orderNumber['sort_order']+1;
	}
	
	private function validateRequest($request)
	{
		$validator = Validator::make([
			'type' =>  $request->json('type'),
			'content' => $request->json('content'),
			'sort_order' => $request->json('sort_order'),
			'done' => $request->json('done')
		],[
			'type' => 'required',
			'content' => 'required',
			'sort_order' => 'required',
			'done' => 'required'
		]);
		
		if($validator->fails()){
			return [
				'message' => 'Bad move! Try removing the task instead of deleting its content.'
			];
		}
		if(!in_array( $request->json('type'),['shopping','work'])){
			return[
				'message' => 'The task type you provided is not supported. You can only use shopping or work.'
			];
		}
		return true;
	}
	
	private function fillAndSaveTask(Task $task,$request, $isInsert = false)
	{
		$task->type = $request->json('type');
		$task->content = $request->json('content');
		$task->sort_order = $isInsert == true ?  $this->getNextOrder() : $request->json('sort_order');
		$task->done = $request->json('done');
		$task->timestamps = false;
		
		if($isInsert) {
			$task->date_created = date('Y-m-d H:i:s');
		}

	
		$task->save();
	}
}
