<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Breadcrumbs\Breadcrumbs;
use A17\Twill\Services\Forms\Fields\Checkbox;
use A17\Twill\Services\Forms\Fields\Radios;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
use A17\Twill\Services\Forms\Option;
use A17\Twill\Services\Forms\Options;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class ProductController extends BaseModuleController
{
    protected $moduleName = 'products';
    protected $titleColumnKey = 'type';
    protected $titleColumnLabel = 'Type';
    protected $titleFormKey = 'type';
    protected $titleFormLabel = 'Type';


    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()
                ->name('type')
                ->label('Тип продукта')
                ->maxLength(100)
                ->required(),
        );

        $form->add(
            Wysiwyg::make()
                ->name('description')
                ->label('Описание')
                ->required()
                ->maxLength(1000),
        );

        $form->add(
            Input::make()
                ->name('color')
                ->required()
                ->label('Цвет'),
        );

        $form->add(
            Input::make()
                ->name('size')
                ->maxLength(100)
                ->required()
                ->type('number')
                ->label('Размер'),
        );

        $form->add(
            Input::make()
                ->name('price')
                ->type('number')
                ->required()
                ->label('Цена'),
        );

        $form->add(
            Checkbox::make()
                ->name('is_in_stock')
        );

        return $form;
    }

    public function getCreateForm(): Form
    {
        return Form::make([
            Input::make()
                ->name('type')
                ->label('Тип продукта')
                ->maxLength(100)
                ->required(),
            Wysiwyg::make()
                ->name('description')
                ->label('Описание')
                ->required()
                ->maxLength(1000),
            Input::make()
                ->name('color')
                ->required()
                ->label('Цвет'),
            Input::make()
                ->name('size')
                ->maxLength(100)
                ->required()
                ->type('number')
                ->label('Размер'),
            Input::make()
                ->name('price')
                ->type('number')
                ->required()
                ->label('Цена'),
            Checkbox::make()
                ->name('is_in_stock')
        ]);
    }


    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('description')->title('Description')
        );

        return $table;
    }
}
