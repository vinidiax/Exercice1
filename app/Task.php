<?php
/**
 * Created by PhpStorm.
 * User: Vinicius
 * Date: 26/01/2018
 * Time: 23:06
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
	protected $fillable = [
		'type',
		'content',
		'sort_order',
		'done',
		'date_created'
	];
}