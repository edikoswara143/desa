<?php

namespace App\Livewire;

use Livewire\Component;

class VillageService extends Component
{

  public $title;

  public function mount($title = null)
  {
    $this->title = $title;
  }

  public function render()
  {
    return view('livewire.village-service');
  }
}
