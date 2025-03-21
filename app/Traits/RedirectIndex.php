<?php

namespace App\Traits;

trait RedirectIndex
{
  protected function getRedirectUrl(): string
  {
    return $this->previousUrl ?? $this->getResource()::getUrl('index');
  }
}
