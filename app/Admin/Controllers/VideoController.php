<?php

namespace App\Admin\Controllers;

use App\Video;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use App\VideoCate;
use Illuminate\Support\Facades\DB;
class VideoController extends Controller
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
            ->header('视频列表')
            ->description('视频列表')
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
            ->header('视频详情')
            ->description('description')
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
            ->header('视频编辑')
            ->description('视频编辑')
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
            ->header('视频添加')
            ->description('视频添加')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Video);

        // $grid->id('Id');
        // $grid->imgpath('Imgpath');
         $grid->addtime('Addtime');
        // $grid->click('Click');
        // $grid->content('Content');
        // $grid->is_delete('Is delete');
        // $grid->video_label('Video label');
        // $grid->video_brief('Video brief');
        // $grid->video_link('Video link');
        // $grid->mongo_id('Mongo id');
        // $grid->video_title('Video title');
        // $grid->video_cate_id('Video cate id');
        // $grid->img('Img');
            $grid = new Grid(new VideoCate());
            $grid->catename('分类名称');
            $grid = new Grid(new Video());
            $grid->id('id')->sortable();
            $grid->model()->where('is_delete', '=', 1);
            $grid->model()->orderBy('id', 'desc');
            // 直接通过字段名`username`添加列
            $grid->video_title('标题')->editable('textarea');
//            $grid->video_link('视频路径');
            $grid->column('video_link','视频路径')->style('max-width:260px;word-break:break-all;');
            $grid->imgpath('封面图')->display(function($img) {
                return "<img  width='150' src='$img'/>";
            });
            $grid->column('c.catename','分类名称');
            $grid->addtime('发布时间')->display(function($addtime) {
                return date("Y-m-d",$addtime);
            })->sortable();

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                    $actions->disableView();
            });
            $grid->column('c.rewriteurl','分类url');
            $grid->video_cate_id('分类id');
            $grid->click('点击量')->sortable();
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
        $show = new Show(Video::findOrFail($id));

        $show->id('Id');
        $show->imgpath('Imgpath');
        $show->addtime('Addtime');
        $show->click('Click');
        $show->content('Content');
        $show->is_delete('Is delete');
        $show->video_label('Video label');
        $show->video_brief('Video brief');
        $show->video_link('Video link');
        $show->mongo_id('Mongo id');
        $show->video_title('Video title');
        $show->video_cate_id('Video cate id');
        // $show->img('Img');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Video);

        // $form->text('imgpath', 'Imgpath');
        // $form->number('click', 'Click');
        // $form->text('content', 'Content');
         // $form->switch('is_delete', '')->default(1);
        // $form->text('video_label', 'Video label');
        // $form->text('video_brief', 'Video brief');
        // $form->text('video_link', 'Video link');
        // $form->text('mongo_id', 'Mongo id');
        // $form->text('video_title', 'Video title');
        // $form->switch('video_cate_id', 'Video cate id')->default(1);
         // 显示记录id
                 $form->display('id', 'ID');
                $form->model()->id;
                // 添加text类型的input框
                $form->text('video_title', '视频标题');
                $form->text('video_link', '视频URL');
                $form->text('imgpath', '图片URL');
                $list=DB::table('video_cates')->select('catename','id')->where('is_delete',1)->get()->toArray();
                $arr = array_column($list,'catename','id');
                $form->select('video_cate_id', '视频分类')->options($arr);

                // 添加describe的textarea输入框
                $form->textarea('content', '视频简介');
                $form->number('addtime', '添加的时间戳');
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
        // $form->image('img', 'Img');

        return $form;
    }
}
