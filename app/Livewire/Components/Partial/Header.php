<?php

namespace App\Livewire\Components\Partial;

use Livewire\Component;

class Header extends Component
{

  public $showMenu = false;

  public function toggle()
  {
    $this->showMenu = !$this->showMenu;
  }

  public function close()
  {
    $this->showMenu = false;
  }

  public function render()
  {
    return view('livewire.components.partial.header');
  }
}
