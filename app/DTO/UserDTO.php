<?php
namespace App\DTO;

use Illuminate\Support\Facades\Request;
class UserDTO {
	public function __construct(
		public ?string $name = null,
		public ?string $email = null,
		public ?int $role = null,
		public ?string $password = null,
	) {
	}
	public static function fromRequestCreate( Request $request ): self {
		$validated = $request->validate( [ 
			'name' => [ 'required', 'string', 'max:255' ],
			'email' => [ 'required', 'email', 'unique:users,email' ],
			'password' => [ 'required', 'string', 'min:8' ],
			'role' => [ 'sometimes', 'nullable', 'integer' ],
		] );

		return new self(
			name: $validated['name'],
			email: $validated['email'],
			password: $validated['password'],
			role: $validated['role'],
		);
	}
	public static function fromRequestUpdate( Request $request ): self {
		$validated = $request->validate( [ 
			'name' => [ 'sometimes', 'nullable', 'string', 'max:255' ],
			'email' => [ 'sometimes', 'nullable', 'email', 'unique:users,email' ],
			'password' => [ 'sometimes', 'nullable', 'string', 'min:8' ],
			'role' => [ 'nullable', 'integer' ],
		] );

		return new self(
			name: $validated['name'],
			email: $validated['email'],
			password: $validated['password'],
			role: $validated['role'],
		);
	}
}
