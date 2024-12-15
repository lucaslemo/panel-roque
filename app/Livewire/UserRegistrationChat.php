<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Log;
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
     * 0 - Initial messages.
     *
     * 1 - Creating password.
     *
     * 2 - Password confirmation.
     *
     * 3 - Editing user data.
     *
     * 4 - Creating new users.
     *
     * 5 - Access the Portal
     */
    public int $stage = 0;

    /**
     * @var array{id:int, array{message:string, data:array, animation:bool, time:int, type:string}} $messages
     */
    public array $messages = [];

    public array|Collection $usersDefault = [];

    public string $password = '';
    public string $password_confirmation = '';
    public string $genderAudioVoice = 'male';
    public string $extAudioVoice = 'mp3';

    /**
     * Add a new message on the messages history.
     */
    private function addNewMessage(string $message, array $data = [], bool $animation = true, int $time = 0, string $type = 'received', string|null $audio = null): void
    {
        // Adiciona uma única mensagem
        $this->messages[] = [
            'message' => $message,
            'data' => $data,
            'animation' => $animation,
            'time' => $time,
            'type' => $type,
            'audio' => $audio
        ];
    }

    /**
     * Based on the current stage creates messages for the user.
     */
    private function interactions(array $messages = [], string|null $type = null, array $messagesData = [])
    {
        switch ($this->stage) {
            case 0:
                // Exibe as mensagens iniciais.
                $initialMessages = [
                    [
                        'text' => Lang::get("For your security, let's first create a login password for future access to the site, ok?"),
                        'audio' => asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_1.{$this->extAudioVoice}"),
                    ],
                    [
                        'text' => Lang::get('Your password must contain at least 8 characters, including letters and numbers.'),
                        'audio' => asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_2.{$this->extAudioVoice}"),
                    ],
                    [
                        'text' => Lang::get('Here we go. Enter the password you want.'),
                        'audio' => asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_3.{$this->extAudioVoice}")
                    ],
                ];
                foreach ($initialMessages as $key => $message) {
                    $this->addNewMessage($message['text'], [], true, ($key + 1) * 1000, 'received', $message['audio']);
                }

                break;

            case 1:
                // Exibe as mensagens após a primeira inserção da senha.
                $this->addNewMessage($this->password, [], true, 0, $type);
                if ($type === 'error') {
                    foreach ($messages as $key => $message) {
                        $audio = null;
                        if (strpos($message, '8 caracteres') !== false) {
                            $audio = asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_4.{$this->extAudioVoice}");
                        } else if(strpos($message, 'pelo menos um número') !== false) {
                            $audio = asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_5.{$this->extAudioVoice}");
                        }

                        $this->addNewMessage($message, [], true, ($key + 1) * 1000, 'received', $audio);
                    }

                } else if ($type === 'sent') {
                    $this->addNewMessage(Lang::get('Please enter your password again.'), [], true, 1000, 'received', asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_6.{$this->extAudioVoice}"));
                }
                break;

            case 2:
                // Exibe as mensagens após a confirmação da senha.
                $this->addNewMessage($this->password, [], true, 0, $type);
                if ($type === 'error') {
                    foreach ($messages as $key => $message) {
                        $audio = null;
                        if(strpos($message, 'não correspondem') !== false) {
                            $audio = asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_7.{$this->extAudioVoice}");
                        }

                        $this->addNewMessage($message, [], true, ($key + 1) * 1000, 'received', $audio);
                    }

                } else if ($type === 'sent') {
                    $confirmationMessages = [
                        [
                            'text' => Lang::get('Password registered.'),
                            'audio' => asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_8.{$this->extAudioVoice}"),
                        ],
                        [
                            'text' => Lang::get('We have some information about you in the system, such as your phone number and email address.'),
                            'audio' => asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_9.{$this->extAudioVoice}")
                        ],
                        [
                            'text' => Lang::get("Make sure your data is correct. To correct it, simply click on \"Edit\". If the data is correct, simply click on \"Confirm Data\" to proceed to the next step."),
                            'audio' => asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_10.{$this->extAudioVoice}")
                        ],
                    ];

                    $time = 0;
                    foreach ($confirmationMessages as $key => $message) {
                        $time = ($key + 1) * 1000;
                        $this->addNewMessage($message['text'], [], true, $time, 'received', $message['audio']);
                    }
                    $this->addNewMessage(Lang::get('Personal Data'), [], true, $time + 1000, 'info');
                }
                break;

            case 3:
                $this->addNewMessage(Lang::get('Confirm Data'), [], true, 0, 'button');
                $this->addNewMessage(Lang::get('Okay! Now check out which companies you can view here:'), [], true, 1000, 'received', asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_11.{$this->extAudioVoice}"));

                $time = 0;
                foreach ($messages as $key => $message) {
                    $time = ($key + 2) * 1000;
                    $data = array_key_exists($key, $messagesData) ? $messagesData[$key] : [];
                    $this->addNewMessage($message, $data, true, $time, $type);
                }
                $this->addNewMessage(Lang::get('Would you like to share their data with anyone?'), [], true, $time + 1000, 'received', asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_12.{$this->extAudioVoice}"));
                $this->addNewMessage('', [], true, $time + 2000, 'buttonNewUser');
                break;

            case 4:
                $time = 0;
                foreach ($messages as $key => $message) {
                    $time = $key * 1000;
                    $data = array_key_exists($key, $messagesData) ? $messagesData[$key] : [];
                    $this->addNewMessage($message, $data, true, $time, 'newUser');
                }
                $this->addNewMessage(Lang::get('Would you like to share the data with anyone else?'), [], true, $time + 1000, 'received', asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_13.{$this->extAudioVoice}"));
                $this->addNewMessage('', [], true, $time + 2000, 'buttonNewUser');
                break;

            case 5:
                $this->addNewMessage(Lang::get('No'), [], true, 0, 'button');
                $this->addNewMessage(Lang::get('Okay. Your registration was successful!'), [], true, 1000, 'received', asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_14.{$this->extAudioVoice}"));
                $this->addNewMessage(Lang::get('Welcome to our Customer Portal! See you soon.'), [], true, 2000, 'received', asset("build/assets/audios/{$this->genderAudioVoice}/TEXTO_15.{$this->extAudioVoice}"));
                $this->addNewMessage('', [], true, 3000, 'buttonAccess');

                break;
            default:

                break;
        }
    }

    /**
     * Handle the user action with the chat.
     */
    public function passwordSubmit(): void
    {
        if ($this->stage === 1 || $this->stage === 2) {
            // Valida a senha fornecida
            $validator = Validator::make(
                ['password' => $this->password, 'password_confirmation' => $this->password_confirmation],
                ['password' => $this->stage === 1 ? ['required', 'string', Password::defaults()->uncompromised()->letters()->numbers()] : ['required', 'confirmed']],
                ['password.confirmed' => Lang::get('The passwords you entered do not match. Please enter the created password again.')]
            );

            $type = $validator->fails() ? 'error' : 'sent';
            $errors = $validator->errors()->get('password');

            if ($this->stage === 1 && $type === 'sent') {
                $validated = $validator->validated();
                $this->password_confirmation = $validated['password'];

            } else if ($this->stage === 2 && $type === 'sent') {
                try {
                    // Atualiza a nova senha do usuário
                    $validated = $validator->validated();
                    $this->user->password = Hash::make($validated['password']);
                    $this->user->save();

                } catch (\Throwable $th) {
                    report($th);
                    $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
                }
            }

            // Mostra as mensagens ao usuário
            $this->interactions($errors, $type);

            // Define o próximo estágio do chat.
            if ($type === 'sent') {
                $this->stage++;
            } else if ($type === 'error') {
                $this->stage = 1;
            }

            $this->password = '';
        }
    }

    /**
     * Confirm user edition.
     */
    public function confirmEdition(): void
    {
        try {
            if ($this->stage === 3) {

                $customers = $this->user->customers;

                $messages = [];
                $data = [];
                foreach($customers as $key => $customer) {
                    $messages[$key] = $customer->nmCliente;
                    $data[$key] = ['code' => formatCnpjCpf($customer->codCliente)];
                }

                $this->interactions($messages, 'customer', $data);
                $this->stage++;
            }
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Create the message for ner users.
     */
    #[On('new-user')]
    public function newUser(User $newUser): void
    {
        try {
            if ($this->stage === 4) {

                $this->usersDefault[$newUser->id] = $newUser;

                $newMessage = [0 => Lang::get('Registered user')];
                $newData = [0 => ['userId' => $newUser->id]];

                $this->interactions($newMessage, 'newUser', $newData);
            }
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
            if ($this->stage === 4) {
                $this->stage++;
                $this->interactions();
            }
        } catch (\Throwable $th) {
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
            if ($this->stage === 5) {
                $this->user->active = true;
                $this->user->save();
                Auth::login($this->user);
            }

            $this->redirectIntended(default: route('app.dashboard', absolute: false), navigate: true);
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    /**
     * Reload user info.
     */
    #[On('refresh-user')]
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
     * Reload user default info.
     */
    #[On('refresh-user-default')]
    public function refreshUserDefault(int $id): void
    {
        try {
            if (array_key_exists($id, $this->usersDefault)) {
                $this->usersDefault[$id]->refresh();
            }
        } catch (\Throwable $th) {
            report($th);
            $this->dispatch('showAlert', __('Error when fetching users data.'), __($th->getMessage()), 'danger');
        }
    }

    public function hydrate()
    {
        for($i = 0; $i < count($this->messages); $i++) {
            $this->messages[$i]['animation'] = false;
        }
    }

    /**
     * Mount the initial data for chat.
     */
    public function mount(User $user)
    {
        $this->user = $user;
        $this->interactions();
        $this->stage++;
    }

    public function render()
    {
        return view('livewire.user-registration-chat');
    }
}
