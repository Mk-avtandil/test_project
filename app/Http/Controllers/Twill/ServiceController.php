<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\DatePicker;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\NestedModuleController as BaseModuleController;

class ServiceController extends BaseModuleController
{
    protected $moduleName = 'services';
    protected $titleColumnKey = 'type';
    protected $titleColumnLabel = 'Type';
    protected $titleFormKey = 'type';
    protected $titleFormLabel = 'Type';

    private static array $formFields;
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();
        self::$formFields = [
            Input::make()
                ->name('type')
                ->label('Тип сервиса')
                ->maxLength(100)
                ->required(),
            Input::make()
                ->name('price')
                ->type('number')
                ->required()
                ->label('Цена'),
            DatePicker::make()
                ->name("deadline")
                ->label("Срок выполнения")
                ->required(),
            Input::make()
                ->name('example_link')
                ->label('Ссылка...'),
        ];
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        foreach (self::$formFields as $field) {
            $form->add($field);
        }

        return $form;
    }

    public function getCreateForm(): Form
    {
        return Form::make(self::$formFields);
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
