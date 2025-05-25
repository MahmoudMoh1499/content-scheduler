<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Filament\Resources\PostResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;

class ListPosts extends ListRecords
{
    protected static string $resource = PostResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('managePosts')
                ->label('Manage Posts')
                ->url(PostResource::getUrl())
                ->icon('heroicon-o-document-text'),

            Action::make('createPost')
                ->label('New Post')
                ->url(PostResource::getUrl('create'))
                ->icon('heroicon-o-plus'),
        ];
    }
}
