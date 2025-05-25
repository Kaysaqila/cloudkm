<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IndustriResource\Pages;
use App\Filament\Resources\IndustriResource\RelationManagers;
use App\Models\Industri;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class IndustriResource extends Resource
{
    protected static ?string $model = Industri::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office'; //ganti icon

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make(2) 
                    ->schema([
                        Forms\Components\TextInput::make('nama') 
                            ->label('Nama')                 
                            ->placeholder('Nama Industri')  
                            ->required(),                   
                            
                        Forms\Components\TextInput::make('bidang_usaha') 
                            ->label('Bidang Usaha')                 
                            ->placeholder('Bidang Usaha')  
                            ->required(),                                  
                            
                        Forms\Components\TextInput::make('alamat') 
                            ->label('Alamat')                 
                            ->placeholder('Alamat Industri')  
                            ->columnspan(2)
                            ->required(),                   
                            
                        Forms\Components\TextInput::make('kontak') 
                            ->label('Kontak')                 
                            ->placeholder('Kontak Industri')  
                            ->required(),                   
                            
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->placeholder('Email Industri')
                            ->email()               //mengatur input type="email" dan validasi email otomatis
                            ->unique(ignoreRecord: true)
                            ->validationMessages([
                                'unique' => 'Email sudah digunakan',
                            ])
                            ->required(),                 

                        Forms\Components\TextInput::make('website') 
                            ->label('Website')                 
                            ->placeholder('Website Industri')  
                            ->url() //validasi berupa url
                            ->columnspan(2)
                            ->required(),   
                    ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                ->label('ID')
                ->getStateUsing(fn ($record) => industri::orderBy('id')->pluck('id') //ambil semua id dari tabel guru
                ->search($record->id) + 1),

                Tables\Columns\TextColumn::make('nama')
                ->label('Nama')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('bidang_usaha')
                ->label('Bidang Usaha')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('website')
                ->label('Website')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('kontak')
                ->label('Kontak')
                ->searchable()
                ->sortable(),

                Tables\Columns\TextColumn::make('email')
                ->label('Email')
                ->searchable()
                ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListIndustris::route('/'),
            'create' => Pages\CreateIndustri::route('/create'),
            'view' => Pages\ViewIndustri::route('/{record}'),
            'edit' => Pages\EditIndustri::route('/{record}/edit'),
        ];
    }
}
