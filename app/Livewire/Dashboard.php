<?php

namespace App\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $filter_tgl_mulai;
    public $filter_tgl_selesai;

    public $perm_vcpu = 0;
    public $perm_memory = 0;
    public $perm_storage = 0;

    public $assess_vcpu = 0;
    public $assess_memory = 0;
    public $assess_storage = 0;

    public $kek_label = [];
    public $kek_value = [];
    

    public function mount(){
        
        $this->filter_tgl_mulai = Carbon::now()->startOfYear()->toDateString();
        $this->filter_tgl_selesai = Carbon::now()->toDateString();
        $this->update_data();

    }

    public function update_data(){
    $res_perm = \DB::table('tr_assess_resource')
            ->select(
                \DB::raw('SUM(vcpu) as vcpu'),
                \DB::raw('SUM(memory) as memory'),
                \DB::raw('SUM(storage) as storage'),
            )
            ->where('id_criteria', 5)
            ->where('status', 'open')
            ->whereBetween('created_at', [$this->filter_tgl_mulai.' 00:00:00', $this->filter_tgl_selesai. ' 23:59:59'])
            ->first();
        $this->perm_vcpu += $res_perm->vcpu ?? 0;
        $this->perm_memory += $res_perm->memory ?? 0;
        $this->perm_storage += $res_perm->storage ?? 0;

        $res_assess = \DB::table('tr_assess_resource')
            ->select(
                \DB::raw('SUM(vcpu) as vcpu'),
                \DB::raw('SUM(memory) as memory'),
                \DB::raw('SUM(storage) as storage'),
            )
            ->where('id_criteria', 6)
            ->where('status', 'open')
            ->whereBetween('created_at', [$this->filter_tgl_mulai.' 00:00:00', $this->filter_tgl_selesai. ' 23:59:59'])
            ->first();

        $this->assess_vcpu += $res_assess->vcpu ?? 0;
        $this->assess_memory += $res_assess->memory ?? 0;
        $this->assess_storage += $res_assess->storage ?? 0;

        $res_legacy = \DB::table('tr_assess_resource_legacy')
            ->select(        
                \DB::raw('SUM(perm_vcpu) as perm_vcpu'),
                \DB::raw('SUM(perm_memory) as perm_memory'),
                \DB::raw('SUM(perm_storage) as perm_storage'),
                \DB::raw('SUM(assess_vcpu) as assess_vcpu'),
                \DB::raw('SUM(assess_memory) as assess_memory'),
                \DB::raw('SUM(assess_storage) as assess_storage')
                )
            ->whereBetween('created_at', [$this->filter_tgl_mulai.' 00:00:00', $this->filter_tgl_selesai. ' 23:59:59'])
            ->first();
        $this->perm_vcpu += $res_legacy->perm_vcpu ?? 0;
        $this->perm_memory += $res_legacy->perm_memory ?? 0;
        $this->perm_storage += $res_legacy->perm_storage ?? 0;
        $this->assess_vcpu += $res_legacy->assess_vcpu ?? 0;
        $this->assess_memory += $res_legacy->assess_memory ?? 0;
        $this->assess_storage += $res_legacy->assess_storage ?? 0;

        $data_kekurangan = \DB::table('tr_assess_score')
                ->select(\DB::raw('count(tr_assess_score.id_criteria_sub) as jumlah_case'), 'tm_assess_criteria_sub.nama_sub_kriteria', 
                'tm_assess_criteria_sub.sub_type')
                ->leftJoin('tm_assess_criteria', 'tm_assess_criteria.id', 'tr_assess_score.id_criteria')
                ->leftJoin('tm_assess_criteria_sub', 'tm_assess_criteria_sub.id', 'tr_assess_score.id_criteria_sub')
                ->where('tm_assess_criteria.tipe_kriteria', "checklist")
                ->where('tr_assess_score.score', 0)
                ->where('tr_assess_score.status', 'open')
                ->whereBetween('tr_assess_score.created_at', [$this->filter_tgl_mulai.' 00:00:00', $this->filter_tgl_selesai. ' 23:59:59'])
                ->groupBy('tr_assess_score.id_criteria_sub')
                ->orderBy('jumlah_case', 'desc')
                ->limit(5)
                ->get();
        
        foreach($data_kekurangan as $row)
        {
            array_push($this->kek_label, $row->nama_sub_kriteria);
            array_push($this->kek_value, $row->jumlah_case);
        }

        $this->dispatch('chart-data-loaded', chart_data: [
            'data' => [
                'labels' => $this->kek_label,
                'values' => $this->kek_value,
            ]
        ]); 
    }

    public function updated(){
        $this->perm_vcpu = 0;
        $this->perm_memory = 0;
        $this->perm_storage = 0;

        $this->assess_vcpu = 0;
        $this->assess_memory = 0;
        $this->assess_storage = 0;

        $this->kek_label = [];
        $this->kek_value = [];
        
        $this->update_data();
    }

    public function render()
    {   
        $data_views = \DB::table('tr_article_views')
            ->select('id_artikel', \DB::raw('sum(total_view) as total_view'))
            ->groupBy('id_artikel');

        $data['artikel'] = \DB::table('tr_article')
            ->select('tr_article.*', 'views_total.total_view', 'users.name')
            ->leftJoinSub($data_views, 'views_total', function($join){
                $join->on('tr_article.id', 'views_total.id_artikel');
            })
            ->leftJoin('users', 'tr_article.author', 'users.id')
            ->orderBy('views_total.total_view', 'desc')
            ->where('tr_article.status', 'active')
            ->limit(5)
            ->get();
        return view('livewire.dashboard', $data);
    }
}
