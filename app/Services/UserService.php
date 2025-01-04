<?php
namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
class UserService {
	/**
	 * Summary of user
	 * @var User
	 */
	public User $user;

	/**
	 * Summary of __construct
	 * @param string $name
	 * @param string $email
	 * @param string $password
	 * @param int $role
	 */
	public function __construct(
		public string $name,
		public string $email,
		public string $password,
		public int $role,
	) {
		$this->user = User::create( [ 
			"name" => $this->name,
			"email" => $this->email,
			"password" => $this->password,
			"role" => $this->role,
		] );
	}

	/**
	 * Summary of create
	 * @param string $name
	 * @param string $email
	 * @param string $password
	 * @param int $role
	 * @return \App\Services\UserService
	 */
	public static function create(
		string $name,
		string $email,
		string $password,
		int $role,
	): self {
		$userService = new UserService(
			name: $name,
			email: $email,
			password: $password,
			role: $role,
		);
		$userService->user->save();
		return $userService;
	}

	/**
	 * Summary of createFromUser
	 * @param \App\Models\User $user
	 * @return \App\Services\UserService
	 */
	public static function fromModel( User $user ): self {
		$userService = new UserService(
			name: $user->name,
			email: $user->email,
			password: $user->password,
			role: $user->role,
		);
		$userService->user = $user;
		return $userService;
	}

	/**
	 * Summary of createFromRequest
	 * @param \Illuminate\Http\Request $request
	 * @return \App\Services\UserService
	 */
	public static function createFromRequest( Request $request ): self {
		$validated = $request->validate( [ 
			'name' => [ 'required', 'string', 'max:255' ],
			'email' => [ 'required', 'email', 'unique:users,email' ],
			'password' => [ 'required', 'string', 'min:8' ],
			'role' => [ 'nullable', 'integer' ],
		] );
		$user = User::create( $validated );
		return self::fromModel( $user );
	}
	/**
	 * Summary of updateFromRequest
	 * @param \Illuminate\Http\Request $request
	 * @param \App\Models\User $user
	 * @return \App\Services\UserService
	 */
	public static function updateFromRequest( Request $request, User $user ): self {
		$validated = $request->validate( [ 
			'name' => [ 'sometimes', 'string', 'max:255' ],
			'email' => [ 'sometimes', 'email', Rule::unique( 'users', 'email' )->ignore( $user->id ) ],
			'password' => [ 'sometimes', 'string', 'min:8' ],
			'role' => [ 'nullable', 'integer' ],

		] );
		$user->update( $validated );
		return self::fromModel( $user );
	}
}
