<?php
/**
 * Created by PhpStorm.
 * User: ThinkPad
 * Date: 2019/3/5
 * Time: 7:54
 */

namespace App\Admin\Controllers;
use App\Http\Controllers\Controller;
use App\VideoCate;
use Encore\Admin\Controllers\Dashboard;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Content;
use Encore\Admin\Layout\Row;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Show;
use Illuminate\Support\Facades\DB;
use App\Video;
use Encore\Admin\Facades\Admin;

class VideoController extends Controller
{
        public  function index()
        {

        }
        //
        public  function video_list(Content $content)
        {
            return $content
                ->header('视频列表')
                ->description('视频列表')
                ->body($this->grid()->render());
        }

        protected function grid()
        {
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


           //dd($grid);
            return $grid;
        }
        //编辑
        public  function  edit($id,Content $content)
        {

            return $content
                ->header('视频编辑')
                ->description('视频编辑')
                ->body($this->grids()->edit($id));
            // return $content
            // ->header('Detail')
            // ->description('description')
            // ->body($this->detail(965));


        }
        public  function  grids()
        {
            $grid = Admin::form(Video::class, function(Form $form){

                // 显示记录id
                $form->display('id', 'ID');
                $form->model()->id;
                // 添加text类型的input框
                $form->text('video_title', '视频标题');
                $form->text('video_link', '视频URL');
                $form->text('imgpath', '图片URL');
                // $form->image('imgpath', '图片');
                $list=DB::table('video_cates')->select('catename','id')->where('is_delete',1)->get()->toArray();
                $arr = array_column($list,'catename','id');
                $form->select('video_cate_id', '视频分类')->options($arr);

                // 添加describe的textarea输入框
                $form->textarea('content', '视频简介');

                // 数字输入框
//                $form->number('rate', '打分');

                // 添加开关操作
//                $form->switch('released', '发布？');

                // 添加日期时间选择框
//                $form->dateTime('release_at', '发布时间');
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
                // $form->setAction('/admin/Video/edit');
                // 两个时间显示
                // $form->display('created_at', '创建时间');
                // $form->display('updated_at', '修改时间');
            });
            return $grid;
        }
    public function video_edit($id)
    {
        $form = new Form();
        dd($form);
    }
}