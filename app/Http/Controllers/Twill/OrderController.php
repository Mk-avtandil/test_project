<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Breadcrumbs\BreadcrumbItem;
use A17\Twill\Services\Breadcrumbs\Breadcrumbs;
use A17\Twill\Services\Forms\Fields\Radios;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Forms\Option;
use A17\Twill\Services\Forms\Options;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\Product;
use App\Models\User;
use App\Repositories\OrderRepository;

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
        self::$fields = [
            Input::make()
                ->name('details')
                ->label('Details'),

            Radios::make()
                ->name('status')
                ->options([
                    Option::make('pending', 'Pending'),
                    Option::make('completed', 'Completed'),
                ]),

            Select::make()
                ->name('user_id')
                ->options(Options::make(
                    User::all('id', 'name')->map(function ($user) {
                        return Option::make($user->id, $user->name);
                    })->toArray()
                ))
                ->label('User'),

            Radios::make()->name('orderable_type')->label('Order Type')->options([
                Option::make('App\\Models\\Product', 'Product'),
//                Option::make('App\\Models\\Service', 'Service'),
            ]),

            Select::make()
                ->name('orderable_id')
                ->options(Options::make(
                    Product::all('id', 'type')->map(function ($product) {
                        return Option::make($product->id, $product->type);
                    })))
                ->label('Product/Service')
        ];
    }


    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = new Form();

        foreach(self::$fields as $field) {
            $form->add($field);
        }
        return $form;
    }

    public function getBrowserTableColumns(): TableColumns
    {
        return TableColumns::make([
            Text::make()->field('user_id'),
            Text::make()->field('details'),
        ]);
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
            Text::make()->field('orderable')->title('Product/Service')->customRender(function ($order) {
                return $order ? $order->orderable->type : 'Unknown';
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
