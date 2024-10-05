<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use Livewire\Attributes\On;

class UserRegistrationChat extends Component
{
    /**
     * The user who is finalizing his registration.
     */
    public User|null $user = null;

    /**
     * The current stage the chat is in.
     * 0 - Creating password.
     *
     * 1 - Password confirmation.
     *
     * 2 - Editing user data.
     *
     * 3 - Creating new users.
     *
     * 4 - Access the Portal
     */
    public int $stage = 0;

    /**
     * @var array{id:int, array{message:string, data:array, animation:bool, time:int, type:string}} $messages
     */
    public array $messages = [];

    public array|Collection $usersDefault = [];

    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Add a new message on the messages history.
     */
    private function addNewMessage(string $message, array $data = [], bool $animation = true, int $time = 0, string $type = 'received'): void
    {
        $this->messages[] = [
            'message' => $message,
            'data' => $data,
            'animation' => $animation,
            'time' => $time,
            'type' => $type,
        ];
    }

    /**
     * Add a new user created by the admin.
     */
    private function addNewUserDefault(User $user)
    {
        $this->usersDefault[$user->id] = $user;
    }

    /**
     * Reload user info.
     */
    #[On('refreshUserUserRegistrationChat')]
    public function refreshUser(): void
    {
        try {
            $this->user->refresh();
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Reload user info.
     */
    #[On('refreshUserDefaultUserRegistrationChat')]
    public function refreshUserDefault(int $id): void
    {
        try {
            $this->usersDefault[$id]->refresh();
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Ends the interaction and logs the user in.
     */
    public function finishChat(): void
    {
        try {
            if ($this->stage === 3) {
                $this->stage += 1;
                $this->addNewMessage(Lang::get('No'), [], true, 0, 'button');
                $this->addNewMessage(Lang::get('Okay. Your registration was successful!'), [], true, 1000, 'received');
                $this->addNewMessage(Lang::get('Welcome to our Customer Portal! See you soon.'), [], true, 2000, 'received');

                $this->addNewMessage('', [], true, 3000, 'buttonAccess');
            }
        } catch (\Throwable $th) {
            $this->stage -= 1;
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Ends the interaction and logs the user in.
     */
    public function openPortal(): void
    {
        try {
            $this->user->active = true;

            $this->user->save();

            Auth::login($this->user);

            $this->redirectIntended(default: route('app.dashboard', absolute: false), navigate: true);
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Confirm user edition.
     */
    public function confirmEdition(): void
    {
        try {
            if ($this->stage === 2) {
                $this->stage += 1;

                // Atualiza os dados do usuário e busca os clientes.
                $this->user->refresh();
                $customers = $this->user->customers;

                // Cria a mensagem do usuário
                $this->addNewMessage(Lang::get('Confirm Data'), [], true, 0, 'button');

                // Cria as mensagens do sistema
                $this->addNewMessage(Lang::get('Okay! Now check out which companies you can view here:'), [], true, 1000, 'received');

                $time = 0;
                foreach($customers as $key => $customer) {
                    $this->addNewMessage($customer->nmCliente, ['code' => formatCnpjCpf($customer->codCliente)], true, ($key + 2) * 1000, 'customer');
                    $time = ($key + 2) * 1000;
                }

                $this->addNewMessage(Lang::get('Would you like to share their data with anyone?'), [], true, $time + 1000, 'received');

                $this->addNewMessage('', ['shouldDisabled' => false], true, $time + 2000, 'buttonNewUser');
            }
        } catch (\Throwable $th) {
            report($th);
            $this->stage -= 1;
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Handle the user action with the chat.
     */
    public function passwordSubmit(): void
    {
        // Valida a senha fornecida
        $validator = Validator::make(
            ['password' => $this->password, 'password_confirmation' => $this->password_confirmation],
            ['password' => $this->stage === 0 ? ['required', 'string', Password::defaults()->uncompromised()->letters()->numbers()] : ['required', 'confirmed']],
            ['password.confirmed' => Lang::get('The passwords you entered do not match. Please enter the created password again.')]
        );

        // Cria a mensagem do usuário
        $type = $validator->fails() ? 'error' : 'sent';
        $this->addNewMessage($this->password, [], true, 0, $type);

        // Mensagens de erro
        foreach ($validator->errors()->get('password') as $key => $error) {
            $this->addNewMessage($error, [], true, ($key + 1) * 1000, 'received');
        }

        // Cria as novas mensagens no chat
        if ($type === 'sent' && $this->stage === 0) {
            $this->stage += 1;
            $this->password_confirmation = $this->password;

            // Mensagem para confirmar senha
            $this->addNewMessage(Lang::get('Please enter your password again.'), [], true, 1000, 'received');

        } else if ($type === 'sent' && $this->stage === 1) {
            $this->stage += 1;

            try {
                $validated = $validator->validated();

                // Atualiza a nova senha do usuário
                $this->user->password = Hash::make($validated['password']);
                $this->user->save();

                // Mensagens para senha criada com sucesso
                $newMessages = [
                    Lang::get('Password registered.'),
                    Lang::get('We have some information about you in the system, such as your phone number and email address. Do you want to validate that your data is correct?'),
                    Lang::get("Make sure your data is correct. To correct it, simply click on \"Edit\". If the data is correct, simply click on \"Confirm Data\" to proceed to the next step."),
                ];

                foreach ($newMessages as $key => $message) {
                    $this->addNewMessage($message, [], true, ($key + 1) * 1000, 'received');
                }

                $this->addNewMessage(Lang::get('Personal Data'), [], true, 4000, 'info');
            } catch (\Throwable $th) {
                report($th);
                $this->stage -= 1;
                $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
            }
        }

        $this->password = '';
    }

    /**
     * Create the message for ner users.
     */
    #[On('newUserUserRegistrationChat')]
    public function newUser(User $newUser): void
    {
        try {
            if ($this->stage === 3) {
                $this->addNewUserDefault($newUser);

                $this->addNewMessage(Lang::get('Registered user'), ['userId' => $newUser->id], true, 0, 'newUser');

                $this->addNewMessage(Lang::get('Would you like to share their data with anyone?'), [], true, 1000, 'received');

                $this->addNewMessage('', ['shouldDisabled' => false], true, 2000, 'buttonNewUser');
            }
        } catch (\Throwable $th) {
            $this->stage -= 1;
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Each request made update the animation trigger for every message on screen.
     */
    public function hydrate()
    {
        $messages = [];
        foreach($this->messages as $message) {
            if ($message['type'] === 'buttonNewUser') {
                $message['data']['shouldDisabled'] = true;
            }
            $message['animation'] = false;
            $messages[] = $message;
        }
        $this->messages = $messages;
    }

    /**
     * Mount the initial data for chat.
     */
    public function mount(User $user)
    {
        $this->user = $user;

        $initialMessages = [
            Lang::get("For your security, let's first create a login password for future access to the site, ok?"),
            Lang::get('Your password must contain at least 8 characters, including letters and numbers.'),
            Lang::get('Here we go. Enter the password you want.'),
        ];

        foreach ($initialMessages as $key => $message) {
            $this->addNewMessage($message, [], true, ($key + 1) * 1000, 'received');
        }
    }

    public function render()
    {
        return view('livewire.user-registration-chat');
    }
}
