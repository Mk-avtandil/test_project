<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

class RevisionController extends BaseModuleController
{
    protected $moduleName = 'revisions';
    protected $titleColumnKey = 'email';
    protected $titleColumnLabel = 'Email';
    protected $titleFormKey = 'product_name';
    protected $titleFormLabel = 'Product';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disablePermalink();
        $this->disableCreate();
        $this->disableEditor=true;
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        $form->add(
            Input::make()->name('username')->label('User')
        );

        $form->add(
            Input::make()->name('user_ip')->label('User ip')
        );

        $form->add(
            Input::make()->name('device_name')->label('Device')
        );

        $form->add(
            Input::make()->name('product_name')->label('Product')
        );

        $form->add(
            Input::make()->name('quantity')->label('Quantity')
        );

        $form->add(
            Input::make()->name('status')->label('Status')
        );

        $form->add(
            Input::make()->name('price')->label('Price')
        );

        $form->add(
            Input::make()->name('total_price')->label('Total price')
        );

        $form->add(
            Input::make()->name('created_at')->label('Created at')
        );

        $form->add(
            Input::make()->name('updated_at')->label('Updated at')
        );

        return $form;
    }

    /**
     * This is an example and can be removed if no modifications are needed to the table.
     */
    protected function additionalIndexTableColumns(): TableColumns
    {
        $table = parent::additionalIndexTableColumns();

        $table->add(
            Text::make()->field('username')->title('User')
        );

        $table->add(
            Text::make()->field('product_name')->title('Product')
        );

        $table->add(
            Text::make()->field('quantity')->title('Quantity')
        );

        $table->add(
            Text::make()->field('status')->title('Status')
        );

        $table->add(
            Text::make()->field('created_at')->title('Created at')
        );

        $table->add(
            Text::make()->field('updated_at')->title('Updated at')
        );

        return $table;
    }
}
