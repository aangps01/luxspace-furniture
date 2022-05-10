<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; #{{ $transaction->id }} {{ $transaction->name }}
        </h2>
    </x-slot>

    <x-slot name="script">
        <script>
            $('#crudTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ url()->current() }}',
                columns: [
                    {data: 'id', name: 'id', width: '5%'},
                    {data: 'product.name', name: 'product.name'},
                    {data: 'product.price', name: 'product.price'},
                ]
            });
        </script>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Session::has('error'))
            @include('components.toast.danger', ['message' => Session::get('error')])
            @endif
            @if(Session::has('success'))
            @include('components.toast.success', ['message' => Session::get('success')])
            @endif
            <h2 class="font-semibold text-lg text-gray-800 leading-tight mb-5">
                Transaction Details
            </h2>
            <div class="shadow bg-white overflow-hidden border-b sm-rounded-md mb-10">
                <div class="px-4 py-5 border-gray-200">
                    <table class="table-auto w-full">
                        <tbody>
                            <tr>
                                <th class="border px-6 py-6 text-right">Nama</th>
                                <td class="border px-6 py-6">{{ $transaction->name }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-6 text-right">Alamat</th>
                                <td class="border px-6 py-6">{{ $transaction->address }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-6 text-right">Telepon</th>
                                <td class="border px-6 py-6">{{ $transaction->phone }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-6 text-right">Kurir</th>
                                <td class="border px-6 py-6">{{ $transaction->courrier }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-6 text-right">Payment</th>
                                <td class="border px-6 py-6">{{ $transaction->payment }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-6 text-right">Payment URL</th>
                                <td class="border px-6 py-6">{{ $transaction->payment_url }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-6 text-right">Total Price</th>
                                <td class="border px-6 py-6">{{ $transaction->total_price }}</td>
                            </tr>
                            <tr>
                                <th class="border px-6 py-6 text-right">Status</th>
                                <td class="border px-6 py-6">{{ $transaction->status }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <h2 class="font-semibold text-lg text-gray-800 leading-tight mb-5">
                Transaction Items
            </h2>
            <div class="shadow overflow-hidden sm-rounded-md">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nama</th>
                                <th>Harga</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
