<?php

namespace App\Admin\Controllers;

use App\Article;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
class ArticleController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {

        return $content
            ->header('文章列表')
            ->description('文章列表')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('文章详情')
            ->description('文章详情')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('文章编辑')
            ->description('文章编辑')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Article);

        $grid->id('Id')->sortable();
        // $grid->content('Content');
        $grid->title('标题')->editable('textarea');
       
         $grid->imgpath('封面图')->display(function($img) {
                return "<img  width='150' src='$img'/>";
            });
        $grid->author('作者');
         $grid->addtime('发布时间')->display(function($addtime) {
                return date("Y-m-d",$addtime);
            })->sortable();
        $grid->column('d.catename','分类名称');
        $grid->clilcks('源点击量')->sortable();
        // $grid->sourcetype('Sourcetype');
        $grid->clilck('点击量');
        // $grid->video_cate_id('Video cate id');
        $grid->mongo_id('mongo_id');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Article::findOrFail($id));

        $show->id('Id');
        // $show->content('Content');
        $show->content('发布时间')->display(function($content) {
                return htmlspecialchars_decode($content);
            });
        $show->title('Title');
        $show->addtime('Addtime');
        $show->imgpath('Imgpath');
        $show->author('Author');
        $show->clilcks('Clilcks');
        $show->sourcetype('Sourcetype');
        $show->clilck('Clilck');
        $show->video_cate_id('Video cate id');
        $show->mongo_id('Mongo id');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Article);

       
        $form->text('title', '标题');
        $form->number('addtime', '添加的时间戳');
        $form->text('imgpath', '图片URL');
        $form->text('author', '作者');
        $form->number('clilcks', '点击量');
       // $form->switch('sourcetype', 'Sourcetype');
       // $form->switch('clilck', 'Clilck');
        $list=DB::table('video_cates')->select('catename','id')->where('video',2)->get()->toArray();
        $arr = array_column($list,'catename','id');
        $form->select('video_cate_id', '文章分类')->options($arr);

        // $form->text('mongo_id', 'Mongo id');
        $form->textarea('content', 'Content');
         $form->disableReset();
                // 去掉`查看`checkbox
                $form->disableViewCheck();

                // 去掉`继续编辑`checkbox
                $form->disableEditingCheck();
                // 去掉`列表`按钮
        $form->tools(function (Form\Tools $tools) {
                    // 去掉`列表`按钮
                    $tools->disableList();
                    // 去掉`删除`按钮
                    $tools->disableDelete();

                    // 去掉`查看`按钮
                    $tools->disableView();
                });
         // 去掉`继续创建`checkbox
                $form->disableCreatingCheck();
        return $form;
    }
}
