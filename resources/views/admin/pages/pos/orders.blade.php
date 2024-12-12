@extends('admin.layouts.master')

@section('content')
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="card shadow-sm rounded-4">
                <div class="card-header bg-primary text-black d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Order List</h3>
                    {{-- <button class="btn btn-light btn-sm">
                        <i class="fas fa-download"></i> Export
                    </button> --}}
                </div>
                <div class="card-body">
                    <!-- Compact Filter Form -->
                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('pos.orders.list') }}" class="row g-3 align-items-end mb-4">
                        <div class="col-md-5">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
                        </div>
                        <div class="col-md-5">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fas fa-filter"></i> Filter
                            </button>
                        </div>
                    </form>

                    <!-- Order Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Order ID</th>
                                    <th>Customer</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Order Date</th>
                                    {{-- <th class="text-end">Actions</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($orders as $order)
                                    <tr>
                                        <td><strong>#{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</strong></td>
                                        <td>{{ $order->customer_name ?? 'Guest' }}</td>
                                        <td><strong>${{ number_format($order->total_amount, 2) }}</strong></td>
                                        <td>
                                            <span class="badge
                                                {{ $order->status === 'Completed' ? 'bg-success' : ($order->status === 'Pending' ? 'bg-warning text-white' : 'bg-danger') }}" style="color: white;">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('d M Y') }}</td>
                                        {{-- <td class="text-end">
                                            <a href="{{ route('pos.orders.show', $order->id) }}" class="btn btn-sm btn-outline-info">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <a href="{{ route('pos.orders.edit', $order->id) }}" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                        </td> --}}
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">No orders found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    {{-- <div class="d-flex justify-content-between align-items-center mt-4">
                        <p class="mb-0 text-muted">Showing {{ $orders->firstItem() ?? 0 }} to {{ $orders->lastItem() ?? 0 }} of {{ $orders->total() ?? 0 }} orders</p>
                        <div>
                            {{ $orders->links() }}
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
