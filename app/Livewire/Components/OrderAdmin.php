<?php

namespace App\Livewire\Components;

use App\DTOs\Orders\OrderFiltersData;
use App\Models\Order;
use App\Services\Orders\Contracts\OrderServiceInterface;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Exception;

class OrderAdmin extends Component
{
    use WithPagination;

    protected OrderServiceInterface $orderService;

    #[Url(as: 'q')]
    public string $search = '';

    #[Url]
    public string $status = '';

    #[Url]
    public string $date = '';

    public string $sortBy = 'created_at';

    public string $sortDirection = 'desc';

    public int $perPage = 10;

    public array $statuses = [];


    public ?int $selectedOrderId = null;
    public ?string $selectedPdfUrl = null;
    public bool $showPdfModal = false;

    /*
    |--------------------------------------------------------------------------
    | Inicialización
    |--------------------------------------------------------------------------
    */
    public function mount(): void
    {
        $this->statuses = $this->orderService->statuses();
    }

    public function boot(OrderServiceInterface $orderService): void
    {
        $this->orderService = $orderService;
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function updatingDate(): void
    {
        $this->resetPage();
    }

    public function sort(string $column): void
    {
        if ($this->sortBy === $column) {
            $this->sortDirection = $this->sortDirection === 'asc'
                ? 'desc'
                : 'asc';

            return;
        }

        $this->sortBy = $column;
        $this->sortDirection = 'asc';
    }

    #[Computed]
    public function orders()
    {
        return $this->orderService->paginate(
            new OrderFiltersData(
                search: $this->search,
                status: $this->status,
                date: $this->date,
                sortBy: $this->sortBy,
                sortDirection: $this->sortDirection,
                perPage: $this->perPage,
            )
        );
    }

    #[Computed]
    public function stats(): array
    {
        return [
            'today' => Order::whereDate('created_at', today())->count(),
            'pending' => Order::where('status', 'pending')->count(),
            'preparing' => Order::where('status', 'preparing')->count(),
            'month_total' => Order::whereMonth('created_at', now()->month)
                ->sum('total'),
        ];
    }

    public function viewPdf(int $orderId)
    {
        try {
            $this->selectedOrderId = $orderId;
            $path = "orders/order-{$orderId}.pdf";

            if (Storage::disk('public')->exists($path)) {
                $this->selectedPdfUrl = Storage::url($path);
            } else {
                $this->selectedPdfUrl = null;
            }

            $this->showPdfModal = true;
        } catch (Exception $e) {
            report($e);
            flashMessageError($e->getMessage());
        }
    }

    public function generatePdf()
    {
        try {
            if (!$this->selectedOrderId)
                throw new Exception('Intente nuevamente');

            $order = $this->orderService->getOrderById($this->selectedOrderId, true);
            $this->selectedPdfUrl = $this->orderService->generatePdf($order);
        } catch (Exception $e) {
            report($e);
            flashMessageError($e->getMessage());
        }
    }

    /**
     * Cerrar el modal y limpiar el PDF de memoria.
     */
    public function closeModal()
    {
        $this->showPdfModal = false;
        $this->selectedPdfUrl = null;
    }

    public function render()
    {
        return view('livewire.admin.order')
                ->layout('components.layouts.admin');
    }
}
