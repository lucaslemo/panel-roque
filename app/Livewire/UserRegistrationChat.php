<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;

class UserRegistrationChat extends Component
{
    public User|null $user = null;
    public int $stage = 0;
    public array $messages = [];
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Add a new message on the messages history.
     */
    private function addNewMessage(string $message, bool $animation = true, int $time = 0, string $type = 'received'): void
    {
        $this->messages[] = [
            'message' => $message,
            'animation' => $animation,
            'time' => $time,
            'type' => $type,
        ];
    }

    /**
     * Handle the user action with the chat.
     */
    public function passwordSubmit(): void
    {
        // Valida a senha fornecida
        $validated = Validator::make(
            ['password' => $this->password, 'password_confirmation' => $this->password_confirmation],
            ['password' => $this->stage === 0 ? ['required', 'string', Password::defaults()->uncompromised()->letters()->numbers()] : ['required', 'confirmed']],
        );

        // Cria a mensagem do usuário
        $type = $validated->fails() ? 'error' : 'sent';
        $this->addNewMessage($this->password, true, 0, $type);

        // Mensagens de erro
        foreach ($validated->errors()->get('password') as $key => $error) {
            $this->addNewMessage($error, true, ($key + 1) * 1000, 'received');
        }

        // Cria as novas mensagens no chat
        if ($type === 'sent' && $this->stage === 0) {
            $this->stage += 1;
            $this->password_confirmation = $this->password;

            // Mensagem para confirmar senha
            $this->addNewMessage(Lang::get('Please enter your password again.'), true, 1000, 'received');

        } else if ($type === 'sent' && $this->stage === 1) {
            $this->stage += 1;

            // Mensagens para senha criada com sucesso
            $newMessages = [
                Lang::get('Password registered.'),
                Lang::get('We have some information about you in the system, such as your phone number and email address. Do you want to validate that your data is correct?'),
                Lang::get("Make sure your data is correct. To correct it, simply click on \"Edit\". If the data is correct, simply click on \"Confirm Data\" to proceed to the next step."),
            ];

            foreach ($newMessages as $key => $message) {
                $this->addNewMessage($message, true, ($key + 1) * 1000, 'received');
            }
        }

        $this->password = '';
    }

    /**
     * Each request made update the animation trigger for every message on screen.
     */
    public function hydrate()
    {
        $messages = [];
        foreach($this->messages as $message) {
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
            $this->addNewMessage($message, true, ($key + 1) * 1000, 'received');
        }
    }

    public function render()
    {
        return view('livewire.user-registration-chat');
    }
}
