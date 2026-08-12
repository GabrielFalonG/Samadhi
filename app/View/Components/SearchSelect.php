<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class SearchSelect extends Component
{
    /**
     * Colección de opciones.
     */
    public Collection $options;

    /**
     * Nombre del campo ID.
     */
    public string $optionValue;

    /**
     * Nombre del campo visible.
     */
    public string $optionLabel;

    /**
     * Campo opcional para mostrar debajo del título.
     */
    public ?string $optionDescription;

    /**
     * Campo opcional para mostrar precio.
     */
    public ?string $optionPrice;

    /**
     * Campo opcional para mostrar imagen.
     */
    public ?string $optionImage;

    /**
     * Placeholder.
     */
    public string $placeholder;

    public function __construct(
        Collection $options,
        string $optionValue = 'id',
        string $optionLabel = 'name',
        ?string $optionDescription = null,
        ?string $optionPrice = null,
        ?string $optionImage = null,
        string $placeholder = 'Buscar...'
    ) {
        $this->options = $options;
        $this->optionValue = $optionValue;
        $this->optionLabel = $optionLabel;
        $this->optionDescription = $optionDescription;
        $this->optionPrice = $optionPrice;
        $this->optionImage = $optionImage;
        $this->placeholder = $placeholder;
    }

    public function render(): View|Closure|string
    {
        return view('components.search-select');
    }
}
