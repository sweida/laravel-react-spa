<?php

namespace App\Http\Controllers\Api;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\Redis;

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
    public function detail(ArticleRequest $request){
        $id = $request->get('id');
        if ($request->all)
            // 包括下架文章
            $article = Article::withTrashed()->find($id);
        else
            $article = Article::find($id);

        // 访问统计
        visits($article)->increment();

        // 上一篇和下一篇文章
        if ($article){
            $prevId = Article::where('id', '<', $id)->max('id');
            $nextId = Article::where('id', '>', $id)->min('id');
            $article->prevArticle = Article::where('id', $prevId)->get(['id', 'title']);
            $article->nextrAticle = Article::where('id', $nextId)->get(['id', 'title']);
            $article->view_count = visits($article)->count();
        } else {
            return $this->failed('该文章已经下架');
        }
        return $this->success($article);   
    }

    // 修改文章
    public function edit(ArticleRequest $request){
        $article = Article::findOrFail($request->id);
        $article->update($request->all());

        return $this->success('文章修改成功！');
    }

    // 下架文章
    public function delete(ArticleRequest $request){
        Article::findOrFail($request->id)->delete();
        return $this->success('文章下架成功');
    }

    // 恢复下架文章
    public function restored(ArticleRequest $request){
        Article::withTrashed()->findOrFail($request->id)->restore();
        return $this->success('文章恢复成功');
    }

    // 真删除文章
    public function reallyDelete(ArticleRequest $request){
        Article::findOrFail($request->id)->forceDelete();
        return $this->success('文章删除成功');
    }

}
