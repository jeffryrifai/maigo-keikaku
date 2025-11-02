<?php

namespace App\Livewire\Articles;

use Livewire\WithPagination;
use Livewire\Component;
use Illuminate\Database\Query\JoinClause;

class IndexArticles extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedTagId = '';
    public $tags_filter = [];

    public function mount(){


    }

    public function addTag()
    {
        $data['article_tags'] = \DB::table('tm_article_tag')->get();
        if ($this->selectedTagId) {
            $tags_filter = $data['article_tags']->firstWhere('id', $this->selectedTagId);
            if ($tags_filter && !collect($this->tags_filter)->contains('id', $tags_filter->id)) {
                $this->tags_filter[] = $tags_filter;
            }

            $this->selectedTagId = '';
        }

    }

    public function removeTag($id)
    {
        $this->tags_filter = collect($this->tags_filter)->reject(fn($t) => $t->id == $id)->values()->toArray();
    }
      

    public function render()
    {
        $data['article_tags'] = \DB::table('tm_article_tag')->orderBy('nama_tag', 'asc')->get();

        $tags = \DB::table('tr_article_tag')
                    ->select('tr_article_tag.id', 'tr_article_tag.id_artikel', 'tm_article_tag.nama_tag')
                    ->join('tm_article_tag', 'tr_article_tag.id_tag', '=', 'tm_article_tag.id');

        $current_tags_filter = $this->tags_filter;

        $data['articles'] = \DB::table('tr_article')
            ->leftjoin('users', 'tr_article.author', '=', 'users.id')
            ->leftjoinSub($tags, 'tags', function(JoinClause $join){
                $join->on('tr_article.id', 'tags.id_artikel');
            })
            ->select('tr_article.id', 'tr_article.title', 'tr_article.short_description', 'tr_article.slug', 'tr_article.created_at', 'tr_article.updated_at',
            'users.name as author_name', \DB::raw('GROUP_CONCAT(tags.nama_tag) as tags'))
            ->where('tr_article.status', 'active')
            ->when($this->search, function ($query) {
                $query->where('tr_article.title', 'like', '%' . $this->search . '%')
                      ->orWhere('users.name', 'like', '%' . $this->search . '%')
                      ->orWhere('tr_article.short_description', 'like', '%' . $this->search . '%');
            })
            ->when($current_tags_filter, function ($query) use ($current_tags_filter) {
                // Ambil nama_tag dari array
                $tagNames = collect($current_tags_filter)->pluck('nama_tag')->toArray();

                // Bangun kondisi OR
                $conditions = [];
                $bindings = [];
                foreach ($tagNames as $tag) {
                    $conditions[] = "GROUP_CONCAT(tags.nama_tag) LIKE ?";
                    $bindings[] = "%{$tag}%";
                }

                $query->havingRaw('(' . implode(' OR ', $conditions) . ')', $bindings);
            })
            ->groupBy('tr_article.id')
            ->orderBy('tr_article.created_at', 'desc')
            ->paginate(6);

        return view('livewire.articles.index-articles', $data);
    }

    public function resetFilter(){
        $this->tags_filter = [];
    }
}
