<?php

namespace App\Livewire;

use App\Http\Controllers\CheckoutNotificationController;
use App\Http\Repositories\UserRepository;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\Product;
use App\Models\User;
use App\Notifications\TelegramNotification;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Actions;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;
use Filament\Forms\Form;

class CheckoutProduct extends Component implements HasForms, HasInfolists, HasActions
{
    use InteractsWithActions;
    use InteractsWithInfolists;
    use InteractsWithForms;

    public Product $product;

    public ?array $data = [];

    public function mount(Product $product): void
    {
        $this->product = $product;

        $data = [];
        $data['status_id'] = OrderStatus::where('name', 'pending')->first()->id;
        $data['author_id'] = $this->product->author()->first()->id;
        $data['product_id'] = $this->product->id;

        $this->form->fill($data);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('client_phone')
                    ->required(),
                TextInput::make('client_address')
                    ->required(),
                Hidden::make('status_id')
                    ->required(),
                Hidden::make('author_id')
                    ->required(),
                Hidden::make('product_id')
                    ->required(),
                Textarea::make('note')
                    ->required(),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        $order = $this->form->getState();
        Order::create($order);

        app(CheckoutNotificationController::class)
            ->send($order, $order['author_id']);


        $this->redirect(route('thank-you'));
    }

    public function orderInfolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->record($this->product)
            ->schema([
                Section::make([
                    Split::make([
                        Group::make([
                            ImageEntry::make('images')
                                ->label('')
                                ->stacked()
                                ->extraImgAttributes([
                                    'class' => 'rounded',
                                    'data-fancybox' => "images",
                                ]),

                            TextEntry::make('game.title')
                                ->label('')
                                ->badge(),

                            TextEntry::make('title')
                                ->label(''),

                            TextEntry::make('price')
                                ->inlineLabel()
                                ->suffix(' грн.')
                                ->label('Ціна'),
                        ]),
                    ])
                ])
            ]);
    }

    public function render(): \Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
    {
        return view('livewire.checkout-product');
    }
}
