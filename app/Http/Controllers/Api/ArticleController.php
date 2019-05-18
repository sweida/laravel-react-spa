<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticleController extends Controller
{


    // 添加文章
    public function add(ArticleRequest $request){
        Article::create($request->all());
        return $this->success('文章添加成功！');
    }

    //返回用户列表 10篇为一页
    public function list(Request $request){
        // 需要显示的字段
        $data = ['id', 'title', 'img', 'classify', 'clicks', 'like', 'created_at'];

        if($request->all)
            // 包括下架的文章
            $articles = Article::withTrashed()->paginate(10, $data);
        else
            $articles = Article::paginate(10, $data);
        return $this->success($articles);
    }

    //返回指定文章
    public function detail(ArticleRequest $request, Article $article){
        $id = $request->get('id');
        if ($request->all)
            // 包括下架文章
            $artic = $article::withTrashed()->find($id);
        else
            $artic = $article::find($id);

        // 访问统计
        visits($article)->increment();

        // 上一篇和下一篇文章
        if ($artic){
            $prevId = Article::where('id', '<', $id)->max('id');
            $nextId = Article::where('id', '>', $id)->min('id');
            $artic->prevArticle = Article::where('id', $prevId)->get(['id', 'title']);
            $artic->nextrAticle = Article::where('id', $nextId)->get(['id', 'title']);
            $artic->view_count = visits($article)->count();
        } else {
            return $this->failed('该文章已经下架');
        }

        return $this->success($artic);
            
    }

    // 修改文章
    public function edit(ArticleRequest $request){
        $article = Article::findOrFail($request->id);
        $article->update($request->all());

        return $this->success('文章修改成功！');
    }

    // 下架文章
    public function delete(ArticleRequest $request){
        $article = Article::find($request->id);
        return $article->delete() ?
            $this->success('文章下架成功') :
            $this->failed('文章下架失败');
    }

    // 恢复下架文章
    public function restored(ArticleRequest $request){
        return Article::withTrashed()->find($request->id)->restore() ?
            $this->success('文章恢复成功') :
            $this->failed('文章恢复失败');
    }

    // 真删除文章
    public function reallyDelete(ArticleRequest $request){
        $article = Article::find($request->id);
        return $article->forceDelete() ?
            $this->success('文章删除成功') :
            $this->failed('文章删除失败');
    }

}
