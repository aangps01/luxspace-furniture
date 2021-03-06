<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Product &raquo; {{ $product->name }} &raquo; Gallery
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
                    {data: 'url', name: 'url'},
                    {data: 'is_featured', name: 'is_featured'},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        width: '10%'
                    },
                ]
            });
        </script>
    </x-slot>

    <x-slot name="style">
        <style>
            td {
                text-align: center;
            }
        </style>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(Session::has('error'))
            @include('components.toast.danger', ['message' => Session::get('error')])
            @endif
            @if(Session::has('success'))
            @include('components.toast.success', ['message' => Session::get('success')])
            @endif
            <div class="mb-10">
                <a href="{{ route('dashboard.product.gallery.create', $product->slug) }}"
                    class="bg-green-400 hover:bg-green-600 font-bold py-2 px-4 rounded shadow-lg">+ Upload Photos</a>
            </div>
            <div class="shadow overflow-hidden sm-rounded-md mb-3">
                <div class="px-4 py-5 bg-white sm:p-6">
                    <table id="crudTable">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Image</th>
                                <th>Is Featured</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <a href="{{ route('dashboard.product.index') }}" class="text-sm underline">
                &slarr; Back to products</a>
        </div>
    </div>
</x-app-layout>
