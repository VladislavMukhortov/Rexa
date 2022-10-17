<?php

namespace App\Http\Livewire\Traits;
use Livewire\WithPagination;

trait Sorter
{
    use WithPagination;

    public $sortType = 'desc';
    public $sortField = 'created_at';

    public function sort($sortField)
    {
        $this->sortType = $this->sortType == 'desc' ? 'asc' : 'desc';
        $this->sortField = $sortField;
        $this->resetPage();
    }

    public function paginationView()
    {
        return 'admin.livewire.pagination.view';
    }
}
