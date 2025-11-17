<?php

namespace App\Livewire\Assessment;

use Livewire\Component;
use Illuminate\Support\Facades\Crypt;

class CreateAssessment extends Component
{

    public $category;
    public $tenant;
    public $kode_tiket = '';
    public $selected_category = '';
    public $selected_tenant = '';
    public $form_assess;
    public $form_data = [];
    public $keterangan;
    public $score_max = 0;
    public $score_final = 0;
    public $total_score = 0;
    public $recommendation = '';
    public $id_edit;
    public $isResEdit = false;
    public $showNotice = false;

    public function mount($token = null)
    {
        $this->category = \DB::table('tm_assess_category')->get();
        $this->tenant = \DB::table('tm_tenant')->orderBy('nama_tenant', 'asc')->get();

        if($token)
        {
            $this->id_edit = decrypt(urldecode($token));
            
        }
    }

    public function updatedSelectedCategory($value)
    {
        $this->form_data = [];
    }

    public function calculateScore()
    {
        $this->total_score = 0;
        $maxTotal = $this->form_assess->sum('bobot');

        foreach ($this->form_assess as $criteria) {
            $tipe   = $criteria->tipe_kriteria;
            $bobot  = $criteria->bobot;
            $value  = $this->form_data[$criteria->id]['value'] ?? null;
            $skor   = 0;

            switch ($tipe) {
                case 'checklist':
                    $skor = $this->calculateChecklistScore($criteria, $value);
                    break;

                case 'level':
                    $skor = $this->calculateLevelScore($criteria, $value);
                    break;

                case 'resource':
                default:
                    $skor = 0;
                    break;
            }

            $this->total_score += $skor;
        }
        $normalized = ($maxTotal > 0) ? ($this->total_score / $maxTotal) * 100 : 0;
        $this->total_score = $normalized;
        $this->recommendation = $this->generateRecommendation($this->total_score);
    }

    protected function calculateChecklistScore($criteria, $checkedSubs)
    {
        if (!is_array($checkedSubs) || empty($checkedSubs)) return 0;

        $subs = \DB::table('tm_assess_criteria_sub')
            ->where('id_criteria', $criteria->id)
            ->where('status', 'open')
            ->get(['id']);

        $totalSubs = $subs->count();
        $selectedCount = count($checkedSubs);

        return $totalSubs > 0
            ? ($selectedCount / $totalSubs) * $criteria->bobot
            : 0;
    }

    protected function calculateLevelScore($criteria, $value)
    {
        $nilai = $value ?? 0;
        return ($nilai / 5) * $criteria->bobot;
    }

    protected function generateRecommendation($score)
    {
        if ($score >= 75) {
            return 'Approved Tiket';
        } elseif ($score >= 40) {
            return 'Hold / Follow Up Tenant';
        } else {
            return 'Reject Tiket';
        }
    }

    public function save()
    {
        $rules = [];
        $rules['kode_tiket'] = 'required|string';
        $rules['selected_category'] = 'required|string';
        if (isset($this->form_data[5])){
            $rules['form_data.5.value.vcpu'] = 'required';
            $rules['form_data.5.value.memory'] = 'required';
            $rules['form_data.5.value.storage'] = 'required';
            $messages['form_data.5.value.vcpu.required'] = 'Value vCPU wajib diisi.';
            $messages['form_data.5.value.memory.required'] = 'Value Memory wajib diisi.';
            $messages['form_data.5.value.storage.required'] = 'Value Storage wajib diisi.';
        }
        if (isset($this->form_data[6])){
            $rules['form_data.6.value.vcpu'] = 'required';
            $rules['form_data.6.value.memory'] = 'required';
            $rules['form_data.6.value.storage'] = 'required';
            $messages['form_data.6.value.vcpu.required'] = 'Value vCPU wajib diisi.';
            $messages['form_data.6.value.memory.required'] = 'Value Memory wajib diisi.';
            $messages['form_data.6.value.storage.required'] = 'Value Storage wajib diisi.';
        }

        if (isset($this->form_data[7])){
            $rules['form_data.7.value'] = 'required';
            $messages['form_data.7.value.required'] = 'Value wajib dipilih.';

        }

        if (isset($this->form_data[8])){
            $rules['form_data.8.value'] = 'required';
            $messages['form_data.8.value.required'] = 'Value wajib dipilih.';
            
        }
        
        $this->validate($rules, $messages);
        $this->calculateScore();

        if($this->id_edit){
            \DB::table('tr_assess')
                ->where('id', $this->id_edit)
                ->update([
                "kode_tiket" => $this->kode_tiket,
                "id_tenant" => $this->selected_tenant,
                "id_category" => $this->selected_category,
                "skor_final" => $this->total_score,
                "rekomendasi" => $this->recommendation,
                "keterangan" => $this->keterangan,
                "id_user" => auth()->user()->id,
                "updated_at" => now(),
            ]);
            if($this->isResEdit){
                \DB::table('tr_assess_resource')->where('id_assess', $this->id_edit)->delete();
            }
            \DB::table('tr_assess_score')->where('id_assess', $this->id_edit)->delete();
            $id_assess = $this->id_edit;
        }else{
            $id_assess = \DB::table('tr_assess')->insertGetId([
                "kode_tiket" => $this->kode_tiket,
                "id_tenant" => $this->selected_tenant,
                "id_category" => $this->selected_category,
                "skor_final" => $this->total_score,
                "rekomendasi" => $this->recommendation,
                "keterangan" => $this->keterangan,
                "id_user" => auth()->user()->id,
                "created_at" => now(),
                "updated_at" => now(),
            ]);
        }


        foreach($this->form_data as $k=>$val)
        {
            if( array_key_exists("value", $val )){
                if($val['type'] == "checklist")
                {
                    foreach($val['value'] as $k2 => $v2)
                    {
                        \DB::table('tr_assess_score')->insert([
                            "id_assess" => $id_assess,
                            "id_category" => $this->selected_category,
                            "id_criteria" => $k,
                            "id_criteria_sub" => $k2,
                            "score" => $v2,
                            "created_at" => now(),
                            "updated_at" => now(),
                        ]);
                    }
                }else if($val['type'] == "resource"){
                    $insert_resource = $val['value'];
                    $insert_resource["id_assess"] = $id_assess;
                    $insert_resource["id_criteria"] = $k;
                    $insert_resource["created_at"] = now();
                    $insert_resource["updated_at"] = now();
                    \DB::table('tr_assess_resource')->insert($insert_resource);
                }else{
                    \DB::table('tr_assess_score')->insert([
                            "id_assess" => $id_assess,
                            "id_category" => $this->selected_category,
                            "id_criteria" => $k,
                            "score" => $val['value'],
                            "created_at" => now(),
                            "updated_at" => now(),
                    ]);
                }
            }
            

        }

        $this->showNotice = true;
    }

    public function confirmRedirect(){
        return redirect()->route('assessment.index');
    }

    public function setEdit()
    {
        $assess_edit = \DB::table('tr_assess')
            ->where('id', $this->id_edit)
            ->first();

        $this->kode_tiket = $assess_edit->kode_tiket;
        if($this->selected_category == ''){
            $this->selected_category = $assess_edit->id_category;
        }
        $this->selected_tenant = $assess_edit->id_tenant;
        $this->keterangan = $assess_edit->keterangan;
        //resource
        if($assess_edit->id_category == 1){
            $this->isResEdit = true;
            $res_edit = \DB::table('tr_assess_resource')
                ->where('id_assess', $this->id_edit)
                ->where('tr_assess_resource.status', 'open')
                ->get();

            foreach($res_edit as $row)
            {
                $this->form_data[$row->id_criteria]['value']['vcpu'] = $row->vcpu;
                $this->form_data[$row->id_criteria]['value']['memory'] = $row->memory;
                $this->form_data[$row->id_criteria]['value']['storage'] = $row->storage;
            }
        }

        //other assess
        $scr_edit = \DB::table('tr_assess_score')
            ->select('tr_assess_score.*', 'tm_assess_criteria.tipe_kriteria')
            ->leftjoin('tm_assess_criteria', 'tr_assess_score.id_criteria', 'tm_assess_criteria.id')
            ->where('id_assess', $this->id_edit)
            ->where('tr_assess_score.status', 'open')
            ->get();
        
        foreach($scr_edit as $row)
        {
            //checklist
            if($row->tipe_kriteria == "checklist"){
                $this->form_data[$row->id_criteria]['value'][$row->id_criteria_sub] = $row->score == 1 ? true : false;
            }else{
                $this->form_data[$row->id_criteria]['value'] = $row->score;
            }
        }
    }

    public function render()
    {
        if($this->id_edit){
            $this->setEdit();
        }
        if($this->selected_category != ''){
    
            $current_selected_category = \DB::table('tm_assess_category')->where('id', $this->selected_category)->first();

            $this->form_assess = \DB::table('tm_assess_criteria')
                ->when($current_selected_category != '', function($query) use($current_selected_category) {
                    if($current_selected_category != 'general'){
                        $query->where('jenis', $current_selected_category->jenis)
                            ->orWhere('jenis', 'required');
                    }else{
                        $query->where('jenis', 'required');
                    }
                })
                ->get();

            // langsung isi default type di form_data
            foreach ($this->form_assess as $row) {
                $this->form_data[$row->id]['type'] = $row->tipe_kriteria;
                if($row->tipe_kriteria == "checklist")
                {
                    $data_sub_kriteria = \DB::table('tm_assess_criteria_sub')->where('id_criteria', $row->id)->get();
                    if(!$this->id_edit){
                        foreach($data_sub_kriteria as $sub_k)
                        {
                            $this->form_data[$row->id]['value'][$sub_k->id] = false;
                        }
                    }
                }
            }
        }
        return view('livewire.assessment.create-assessment');
    }
}
