<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Breadcrumbs\BreadcrumbItem;
use A17\Twill\Services\Breadcrumbs\Breadcrumbs;
use A17\Twill\Services\Forms\BladePartial;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Listings\Columns\Text;
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
    protected $previewView = 'site.order';

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

        $type = explode('\\', 'App\\Models\\Product')[2];
        $params = [
            'type' => $type,
            'model' => $model,
        ];
        if($type === 'Product') {
            $params['media_url'] = $model->orderable?->medias()?->first();
        }

        $form->add(BladePartial::make()->view('new-form')->withAdditionalParams($params));
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
