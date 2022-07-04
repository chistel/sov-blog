<?php

namespace App\Actions\Users;

use App\Contracts\Repositories\Users\UserRepository;
use App\Events\Users\UserAuthenticated;
use App\Events\Users\UserHasRegistered;
use App\Events\Users\UserWasAdded;
use App\Exceptions\Users\UserDoesNotExist;
use App\Models\Users\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Platform\Database\Traits\EventDispatcher;
use Platform\Tokens\TokenManager;

class RegisterAction
{
    use EventDispatcher, DispatchesJobs {
        EventDispatcher::dispatch insteadof DispatchesJobs;
        DispatchesJobs::dispatch as dispatchJob;
    }

    protected array $createdByEvents = [
        User::CREATED_REGISTER => UserHasRegistered::class,
        User::CREATED_SOCIAL => UserWasAdded::class,
    ];

    public function __construct(
        protected UserRepository $userRepository,
        protected TokenManager $tokenManager
    ) {
    }

    /**
     * @param Request $request
     * @return User|null
     * @throws BindingResolutionException
     */
    public function execute(Request $request): ?User
    {
        $user = $this->setupUser($request);

        $this->authenticateUser($user);

        $this->dispatch($user->releaseEvents());


        return $user;
    }

    /**
     * Manages user creation
     *
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @param $createdBy
     * @return User|null
     */
    public function create(
        $firstName,
        $lastName,
        $email,
        $password,
        $createdBy,
    ): ?User {
        try {
            return $this->userRepository->requireUser($email, $createdBy);
        } catch (UserDoesNotExist) {
            // Create user
            $user = new User(compact('firstName', 'lastName', 'password', 'email'));

            if (array_key_exists($createdBy, $this->createdByEvents)) {
                $user->raise(new $this->createdByEvents[$createdBy]($user));
            }

            return $user;
        }
    }

    /**
     * @param Request $request
     * @return User|null
     */
    private function setupUser(Request $request): ?User
    {
        $createdBy = User::CREATED_REGISTER;

        $user = $this->userRepository->getByEmail($request->email);

        if (!$user) {
            $user = $this->create($request->firstName, $request->lastName, $request->email,
                $request->password, $createdBy);

            $this->userRepository->save($user);
        }

        return $user;
    }

    /**
     * Authenticate the user, log them in immediately.
     *
     * @param User $user
     */
    private function authenticateUser(User $user): void
    {
        Auth::login($user);
        Session::put('authentication.freshLogin', true);


        $user->raise(new UserAuthenticated($user));
    }
}
