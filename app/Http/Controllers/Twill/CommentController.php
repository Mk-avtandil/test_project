<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\Fields\Select;
use A17\Twill\Services\Listings\TableColumns;
use A17\Twill\Services\Listings\Columns\Text;
use A17\Twill\Services\Forms\Fields\Input;
use A17\Twill\Services\Forms\Form;
use A17\Twill\Http\Controllers\Admin\ModuleController as BaseModuleController;
use App\Models\User;

class CommentController extends BaseModuleController
{
    protected $moduleName = 'comments';
    protected $titleColumnKey = 'body';
    protected $titleColumnLabel = 'Comment';
    protected $titleFormKey = 'body';
    protected $titleFormLabel = 'Comment';
    /**
     * This method can be used to enable/disable defaults. See setUpController in the docs for available options.
     */
    protected function setUpController(): void
    {
        $this->disableCreate();
    }

    /**
     * See the table builder docs for more information. If you remove this method you can use the blade files.
     * When using twill:module:make you can specify --bladeForm to use a blade form instead.
     */
    public function getForm(TwillModelContract $model): Form
    {
        $form = parent::getForm($model);

        if ($model->exists) {
            $user = User::find($model->user_id);
            $items = $model->commentable->toArray();

            $form->add(
                Select::make()
                    ->name('user_id')
                    ->label('User')
                    ->disabled()
                    ->options([ $user->id => $user->name])
            );

            $form->add(
                Select::make()
                    ->name('commentable_id')
                    ->disabled()
                    ->label($model->commentable_type === 'App\\Models\\Product' ? 'Product' : 'Service')
                    ->options([$items['id'] => $items['type']])
            );

            $form->add(
                Input::make()
                    ->name('body')
                    ->disabled()
                    ->label('Comment')
            );
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
            Text::make()->field('user_id')->title('USER')->customRender(function ($comment) {
                $user = User::find($comment->user_id);
                return $user ? $user->name : 'Unknown';
            }),
        );

        $table->add(
            Text::make()->field('commentable_type')->title('Product/Service')->customRender(function ($comment) {
                return $comment ? $comment->commentable_type : 'Unknown';
            })
        );

        $table->add(
            Text::make()->field('created_at')->title('Created')->customRender(function ($comment) {
                return $comment->created_at->diffForHumans();
            })
        );

        return $table;
    }
}
