<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOrder extends EditRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            \Filament\Actions\Action::make('confirm')
                ->action(fn() => $this->record->update(['status' => 'confirmed']))
                ->visible(fn() => $this->record->status === 'draft')
                ->requiresConfirmation()
                ->color('info'),
            \Filament\Actions\Action::make('ship')
                ->action(fn() => $this->record->update(['status' => 'shipped']))
                ->visible(fn() => $this->record->status === 'confirmed' && $this->record->type === 'sales')
                ->requiresConfirmation()
                ->color('success'),
            \Filament\Actions\Action::make('receive')
                ->action(fn() => $this->record->update(['status' => 'received']))
                ->visible(fn() => $this->record->status === 'confirmed' && $this->record->type === 'purchase')
                ->requiresConfirmation()
                ->color('success'),
        ];
    }
}
