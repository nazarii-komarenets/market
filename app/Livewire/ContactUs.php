<?php

namespace App\Livewire;

use App\Http\Controllers\RequestNotificationController;
use App\Models\Request;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;

class ContactUs extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill($this->data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make([
                    TextInput::make('contacts')
                        ->label('Залишіть свої контакти')
                        ->required(),
                    Textarea::make('note')
                        ->label('Повідомлення')
                        ->required(),
                ])
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $request = Request::create($this->form->getState());

        app(RequestNotificationController::class)
            ->send('Контакти: *'. $request->contacts .'* | Повідомлення: '. $request->note);

        $this->redirect(route('thank-you'));
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.contact-us');
    }
}
