<?php

namespace App\Livewire\Assessment;

use Livewire\Component;
use Livewire\WithPagination;


class IndexAssessment extends Component
{
    use WithPagination;

    public $search = '';
    public $current_selected_category = '';
    public $form_assess;
    public $map_level = 
    [
        1 => "Sangat Rendah",
        2 => "Rendah",
        3 => "Menengah",
        4 => "Tinggi",
        5 => "Sangat Tinggi",
    ];

    public $current_table = "semua";
    public $show_legacy = false;
    public function mount()
    {
        
    }

    public function setHalaman($halaman)
    {
        $this->current_table = $halaman;
    }


    public function delete($id)
    {
        \DB::table('tr_assess')
            ->where('id', $id)
            ->update([
                'status' => 'deleted',
                'updated_at' => now(),
            ]);

        \DB::table('tr_assess_score')
            ->where('id_assess', $id)
            ->update([
                'status' => 'deleted',
                'updated_at' => now(),
            ]);

        \DB::table('tr_assess_resource')
            ->where('id_assess', $id)
            ->update([
                'status' => 'deleted',
                'updated_at' => now(),
            ]);

        return redirect()->route('assessment.index');
    }

    public function edit($token)
    {
        $token = urlencode(encrypt($token));
        return redirect()->route('assessment.edit', $token);
    }

    public function render()
    {
        $data['data_assess'] = \DB::table('tr_assess')
                ->select('tr_assess.*', 'tm_tenant.nama_tenant', 'tm_assess_category.nama_kategori', 'users.name')
                ->leftJoin('tm_tenant', 'tr_assess.id_tenant', 'tm_tenant.id')
                ->leftJoin('tm_assess_category', 'tr_assess.id_category', 'tm_assess_category.id')
                ->leftJoin('users', 'tr_assess.id_user', 'users.id')
                ->where('tr_assess.status', 'open')
                ->when($this->search, function ($query) {
                $query->where('tm_tenant.nama_tenant', 'like', '%' . $this->search . '%')
                      ->orWhere('tr_assess.kode_tiket', 'like', '%' . $this->search . '%')
                      ->orWhere('tr_assess.rekomendasi', 'like', '%' . $this->search . '%')
                      ->orWhere('users.name', 'like', '%' . $this->search . '%');
                 })
                ->orderBy('tr_assess.created_at', 'desc')
                ->paginate(5);

        $data['data_resource'] = \DB::table('tr_assess')
                ->select('tr_assess.*', 'tm_tenant.nama_tenant', 'tm_assess_category.nama_kategori', 'users.name')
                ->leftJoin('tm_tenant', 'tr_assess.id_tenant', 'tm_tenant.id')
                ->leftJoin('tm_assess_category', 'tr_assess.id_category', 'tm_assess_category.id')
                ->leftJoin('users', 'tr_assess.id_user', 'users.id')
                ->where('tr_assess.id_category', 1)
                ->where('tr_assess.status', 'open')
                ->when($this->search, function ($query) {
                $query->where('tm_tenant.nama_tenant', 'like', '%' . $this->search . '%')
                      ->orWhere('tr_assess.kode_tiket', 'like', '%' . $this->search . '%')
                      ->orWhere('tr_assess.rekomendasi', 'like', '%' . $this->search . '%')
                      ->orWhere('users.name', 'like', '%' . $this->search . '%');
                 })
                ->orderBy('tr_assess.created_at', 'desc')
                ->paginate(5);

        $data['data_resource_legacy'] = \DB::table('tr_assess_resource_legacy')
            ->when($this->search, function ($query) {
                $query->where('kode_tiket', 'like', '%' . $this->search . '%');
                      
                 })
                ->paginate(5);

        return view('livewire.assessment.index-assessment', $data);
    }
}
