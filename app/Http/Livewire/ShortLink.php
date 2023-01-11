<?php

namespace App\Http\Livewire;

use AshAllenDesign\ShortURL\Classes\Validation;
use AshAllenDesign\ShortURL\Exceptions\ShortURLException;
use AshAllenDesign\ShortURL\Facades\ShortURL;
use Livewire\Component;

class ShortLink extends Component
{
    public bool $isOpened;

    public bool $deactivateAt;
    public bool $singleUse;
    public float $deactivateAtCount;
    public int $deactivateAtType;
    public string $destination;
    public string $shortURL;
    public string $error;

    public function mount()
    {
        $this->isOpened = false;
        $this->deactivateAtCount = 2;
        $this->deactivateAtType = 0;
        $this->singleUse = 0;
        $this->destination = '';
        $this->shortURL = '';
        $this->deactivateAt = 0;
        $this->error = '';
    }

    public function toggleOptions()
    {
        $this->isOpened = !$this->isOpened;
    }

    public function generate()
    {
        $this->error = '';

        try {
            $shortObject = ShortURL::destinationUrl($this->destination);

            if ($this->singleUse) {
                $shortObject = $shortObject->singleUse();
            }

            if ($this->deactivateAt) {
                switch ($this->deactivateAtType) {
                    case 0:
                        $shortObject->deactivateAt(now()->addDays($this->deactivateAtCount));
                        break;
                    case 1:
                        $shortObject->deactivateAt(now()->addMonths($this->deactivateAtCount));
                        break;
                    case 3:
                        $shortObject->deactivateAt(now()->addYears($this->deactivateAtCount));
                        break;
                    default:
                        break;
                }
            }

            $this->shortURL = $shortObject->make()->default_short_url;
        } catch (ShortURLException $e){
            if($e->getCode() == 0){
                $this->error = 'Перед посиланням необхідно вказати https:// або http://';
            }else{
                $this->error = 'Помилка створення короткого посилання';
            }
        }
    }

    public function render()
    {
        return view('livewire.short-link');
    }
}
