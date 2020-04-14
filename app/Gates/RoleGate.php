<?php
namespace App\Gates;

use Illuminate\Auth\Access\Response;
/**
 * 
 */
class RoleGate
{
	
	public function allowed($user, $allowed)
	{
		$allowed = explode(':', $allowed);

		$user = [$user->role];
		return array_intersect($user,$allowed );
	}

	// public function allowed($user, $id)
	// {
	// 	$roles = $user->roles->pluck('name')->toArray();
	// 	return $user->id === $id || in_array('admin',$roles) ?? Response::allow() : Response::deny("You are not authorized");
	// }

	// $response = Gate::inspect('allow-edit',$post->user->id);
	// if($response->denied()){
	// 	return redirect()->back()->with('status',$reponse->message());
	// }
}