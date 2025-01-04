<?php
namespace App\Services;

use App\DTO\UserDTO;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Mockery\Undefined;
class UserService {
	public static function createUser( UserDTO $userDTO ): User {
		return User::create( [ 
			'name' => $userDTO->name,
			'email' => $userDTO->email,
			'password' => $userDTO->password,
			'role' => $userDTO->role,
		] );
	}
	public static function updateUser( User $user, UserDTO $userDTO ): User {
		$user::update( collect( [ 
			'name' => $userDTO->name,
			'email' => $userDTO->email,
			'password' => $userDTO->password,
			'role' => $userDTO->role,
		] )->filter( fn( $value, $key ) => $value != null )
			->toArray()
		);
		return $user->refresh();
	}



}
