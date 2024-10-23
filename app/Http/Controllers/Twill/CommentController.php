<?php

namespace App\Http\Controllers\Twill;

use A17\Twill\Models\Contracts\TwillModelContract;
use A17\Twill\Services\Forms\BladePartial;
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
            $type = strtolower(explode('\\', $model->commentable_type)[2]);
            $form->add(
                BladePartial::make()->view('site.comment-show')->withAdditionalParams([
                    'type' => $type,
                    'comment' => $model
                ])
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
                return $comment->user ? $comment->user->name : 'Unknown';
            }),
        );

        $table->add(
            Text::make()->field('commentable_type')->title('Product/Service')->customRender(function ($comment) {
                $type = explode('\\', $comment->commentable_type);
                $type = end($type);
                return "$type: " . $comment->commentable->type;
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
