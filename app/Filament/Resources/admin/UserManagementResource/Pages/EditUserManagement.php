<?php

namespace App\Filament\Resources\Admin\UserManagementResource\Pages;

use App\Filament\Resources\Admin\UserManagementResource;
use Filament\Resources\Pages\EditRecord;

class EditUserManagement extends EditRecord
{
    protected static string $resource = UserManagementResource::class;

    protected function afterSave(): void
    {
        $record = $this->getRecord();
        $assignedMembers = $this->form->getState()['assigned_members'] ?? [];

        // Only update assignments if the user is a trainer
        if ($record->role->value === 'trainer') {
            $record->assignedMembers()->sync($assignedMembers);
        } else {
            // Clear assignments if not a trainer
            $record->assignedMembers()->detach();
        }
    }
}
