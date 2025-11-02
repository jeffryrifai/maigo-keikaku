<?php

namespace App\Livewire\Articles;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class CreateArticles extends Component
{
    public $title;
    public $summary;
    public $content = '';
    public $content_delta = "{}";

    public $selectedTagId = '';
    public $tags = [];
    public $article;

    public function mount($slug = null)
    {
        if($slug){
            $this->article = \DB::table('tr_article')
                ->where('slug', $slug)
                ->where('status', 'active')
                ->first();
        }
        if ($this->article) {
            $this->title = $this->article->title;
            $this->summary = $this->article->short_description;
            $this->content = $this->article->content;
            $this->content_delta = $this->article->content_delta;
            $article_tags = \DB::table('tr_article_tag')
                ->leftJoin('tm_article_tag', 'tr_article_tag.id_tag', '=', 'tm_article_tag.id')
                ->select('tm_article_tag.*')
                ->where('tr_article_tag.id_artikel', $this->article->id)
                ->where('tr_article_tag.status', 'active')
                ->get();

            $this->tags = $article_tags->toArray();
            $this->dispatch('quill-editmode', content: $this->content);
        }
        
    }

    public function save()
    {
        $this->dispatch('form-submit', delta_content: $this->content_delta);
        $this->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string',
            'content' => 'required',
            'tags' => 'array',
        ]);
        if($this->article) {
            //update article
            \DB::table('tr_article')
                ->where('id', $this->article->id)
                ->update([
                    'title' => $this->title,
                    'slug' => \Str::slug($this->title).'-'.time(),
                    'short_description' => $this->summary,
                    'content' => $this->content,
                    'content_delta' => $this->content_delta,
                    'updated_at' => now(),
                ]);
            //update tags
            \DB::table('tr_article_tag')
                ->where('id_artikel', $this->article->id)
                ->delete();
            foreach ($this->tags as $tag) {
                \DB::table('tr_article_tag')->insert([
                    'id_artikel' => $this->article->id,
                    'id_tag' => $tag->id,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            \DB::table('tr_article_log')->insert([
                'id_artikel' => $this->article->id,
                'id_user' => auth()->user()->id,
                'action' => 'update',
                'description' => 'Artikel '.$this->title.' diperbarui',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            session()->flash('success', 'Artikel berhasil diperbarui!');
            $this->reset();
            return redirect()->route('articles.index');
        }else{
            $article = \DB::table('tr_article')->insertGetId([
                'title' => $this->title,
                'slug' => \Str::slug($this->title).'-'.time(),
                'short_description' => $this->summary,
                'content' => $this->content,
                'content_delta' => $this->content_delta,
                'author' => auth()->user()->id,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            foreach ($this->tags as $tag) {
                \DB::table('tr_article_tag')->insert([
                    'id_artikel' => $article,
                    'id_tag' => $tag->id,
                    'status' => 'active',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            \DB::table('tr_article_log')->insert([
                'id_artikel' => $article,
                'id_user' => auth()->user()->id,
                'action' => 'create',
                'description' => 'Artikel '.$this->title.' dibuat',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            session()->flash('success', 'Artikel berhasil disimpan!');
            $this->reset();
            return redirect()->route('articles.index');
        }

    }

    public function addTag()
    {
        $data['article_tags'] = \DB::table('tm_article_tag')->get();
        if ($this->selectedTagId) {
            $tag = $data['article_tags']->firstWhere('id', $this->selectedTagId);
            if ($tag && !collect($this->tags)->contains('id', $tag->id)) {
                $this->tags[] = $tag;
            }

            $this->selectedTagId = '';
        }
    }

    public function removeTag($id)
    {
        $this->tags = collect($this->tags)->reject(fn($t) => $t->id == $id)->values()->toArray();
    }
        
    public function render()
    {
        $data['article_tags'] = \DB::table('tm_article_tag')->orderBy('nama_tag', 'asc')->get();

        return view('livewire.articles.create-articles', $data);
    }
}
