<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Medias;
use A17\Twill\Services\Forms\Fields\Wysiwyg;
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
    protected $previewView = 'site.product';

    private static array $formFields;
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->enableSkipCreateModal();
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);
        $fields = [
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
            Medias::make()
                ->name('cover')
                ->label('Images'),
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
            Input::make()
                ->name('quantity')
                ->label('Количество')
                ->type('number')
                ->required()
        ];

        foreach ($fields as $field) {
            $form->add($field);
        }

        return $form;
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('size')->title('Size')
        );

        $table->add(
            Text::make()->field('price')->title('Price')->customRender(function ($product) {
                return '$' . $product->price;
            })
        );

        $table->add(
            Text::make()->field('quantity')->title('Is in stock')->customRender(function ($product) {
                return $product->quantity > 0 ? 'Yes' : 'No';
            })
        );

        $table->add(
            Text::make()->field('cover')->title('Images')->customRender(function ($product) {
                $mediaUrl = $product->medias()->get()->isNotEmpty()
                    ? "/storage/uploads/" . $product->medias()->first()['uuid']
                    : "/default.png";

                return $mediaUrl ? "<img src=\"{$mediaUrl}\" alt=\"{$product->type}\" style=\"width: 100px;\" />" : 'No image';
            })
        );

        return $table;
    }
}
