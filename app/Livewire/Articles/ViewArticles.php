<?php

namespace App\Livewire\Articles;

use Livewire\Component;

class ViewArticles extends Component
{

    public $article;

    public function mount($slug)
    {
        $this->article = \DB::table('tr_article')
            ->leftjoin('users', 'tr_article.author', '=', 'users.id')
            ->select('tr_article.*', 'users.name as author_name')
            ->where('tr_article.slug', $slug)
            ->where('tr_article.status', 'active')
            ->first();

        if (! $this->article) {
            abort(404);
        }

        //save view log
        \DB::table('tr_article_views')
            ->updateOrInsert(
                [
                    'id_artikel' => $this->article->id,
                    'id_user' => auth()->user()->id,
                ],
                [
                    'total_view' => \DB::raw('total_view + 1'),
                    'updated_at' => now(),
                ]
            );
    }

    public function delete()
    {
        \DB::table('tr_article')
            ->where('id', $this->article->id)
            ->update([
                'status' => 'deleted',
                'updated_at' => now(),
            ]);

        \DB::table('tr_article_log')->insert([
            'id_artikel' => $this->article->id,
            'id_user' => auth()->user()->id,
            'action' => 'delete',
            'description' => 'Artikel '.$this->article->title.' dihapus',
            'created_at' => now(),
            'updated_at' => now(),
        ]);


        return redirect()->route('articles.index');
    }

    public function render()
    {
        return view('livewire.articles.view-articles');
    }
}
