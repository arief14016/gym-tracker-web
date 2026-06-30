<?php

namespace App\Filament\Resources\Admin\UserManagementResource\Pages;

use App\Filament\Resources\Admin\UserManagementResource;
use Filament\Resources\Pages\CreateRecord;

class CreateUserManagement extends CreateRecord
{
    protected static string $resource = UserManagementResource::class;

    protected function afterCreate(): void
    {
        $record = $this->getRecord();
        $assignedMembers = $this->form->getState()['assigned_members'] ?? [];

        if (!empty($assignedMembers)) {
            $record->assignedMembers()->sync($assignedMembers);
        }
    }
}
