<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Breadcrumbs\BreadcrumbItem;
use A17\Twill\Services\Breadcrumbs\Breadcrumbs;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;

use App\Models\User;

class OrderController extends BaseModuleController
{
    protected $moduleName = 'orders';
    protected $titleColumnKey = 'status';
    protected $titleColumnLabel = 'Status';
    protected $titleFormKey = 'status';
    protected $titleFormLabel = 'Status';
    private static array $fields;

    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disableCreate();
        $this->setBreadcrumbs(
            Breadcrumbs::make([
                BreadcrumbItem::make()
                    ->url(route('twill.orders.index'))
                    ->displayOnForm()
                    ->label('Orders'),
                BreadcrumbItem::make()
                    ->url(route('twill.orders.show', 1))
                    ->displayOnForm()
                    ->label('OrderName')
            ])
        );
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */

    public function getForm(TwillModelContract $model): Form
    {
        $form = new Form();

        if ($model->exists) {
            $user = User::find($model->user_id);
            $items = $model->orderable->toArray();

            $form->add(
                Select::make()
                ->name('user_id')
                ->label('User')
                ->disabled()
                ->options([ $user->id => $user->name])
            );

            $form->add(
                Select::make()
                    ->name('user_id')
                    ->label('Email')
                    ->disabled()
                    ->options([ $user->id => $user->email])
            );


            $form->add(
                Input::make()
                    ->name('status')
                    ->label('Status')
                    ->readOnly()
            );

            $form->add(
                Input::make()
                    ->name('quantity')
                    ->label('Quantity')
                    ->readOnly()
            );

            $type = $model->orderable_type == 'App\\Models\\Product' ? 'Product' : 'Service';
            $type .= ' (type)';
            $form->add(
                Select::make()
                    ->name('orderable_id')
                    ->disabled()
                    ->label($type)
                    ->options([$items['id'] => $items['type']])
            );

            $form->add(
                Select::make()
                    ->name('orderable_id')
                    ->disabled()
                    ->label('Price')
                    ->options([$items['id'] => $items['price']])
            );

            if (isset($items['color'])) {
                $form->add(
                    Select::make()
                        ->name('orderable_id')
                        ->disabled()
                        ->label('Color')
                        ->options([$items['id'] => $items['color']])
                );
            }

            if (isset($items['size'])) {
                $form->add(
                    Select::make()
                        ->name('orderable_id')
                        ->disabled()
                        ->label('Size')
                        ->options([$items['id'] => $items['size']])
                );
            }

            if (isset($items['is_in_stock'])) {
                $form->add(
                    Select::make()
                        ->name('orderable_id')
                        ->disabled()
                        ->label('Is in stock')
                        ->options([$items['id'] => $items['is_in_stock']])
                );
            }

            if (isset($items['description'])) {
                $form->add(
                    Select::make()
                        ->name('orderable_id')
                        ->disabled()
                        ->label('Description')
                        ->options([$items['id'] => $items['description']])
                );
            }

            if (isset($items['deadline'])) {
                $form->add(
                    Select::make()
                        ->name('orderable_id')
                        ->disabled()
                        ->label('Deadline')
                        ->options([$items['id'] => $items['deadline']])
                );
            }
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
            Text::make()->field('user_id')->title('USER')->customRender(function ($order) {
                $user = User::find($order->user_id);
                return $user ? $user->name : 'Unknown';
            }),
        );

        $table->add(
            Text::make()->field('orderable_type')->title('Product/Service')->customRender(function ($order) {
                $type = explode('\\', $order->orderable_type);
                $type = end($type);
                return "$type: " . $order->orderable->type;
            })
        );

        $table->add(
            Text::make()->field('created_at')->title('Created')->customRender(function ($order) {
                return $order->created_at->diffForHumans();
            })
        );

        return $table;
    }
}


