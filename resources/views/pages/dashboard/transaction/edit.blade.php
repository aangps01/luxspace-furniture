<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Transaction &raquo; # {{ $transaction->id }} {{ $transaction->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if ($errors->any())
            <div class="mb-5" role="alert">
                <div class="bg-red-500 text-white font-bold rounded-t px-4 py-2">
                    There&apos;s something wrong!
                </div>
                <div class="border border-t-0 border-red-400 rounded-b px-4 py-3 text-red-700">
                    <p>
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    </p>
                </div>
            </div>
            @endif
            <form class="w-full" action="{{ route('dashboard.transaction.update', $transaction->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="flex flex-wrap -mx-3 mb-6">
                    <label class="block uppercase tracking-wide text-gray-700 text-xs font-bold mb-2"
                        for="status">Status</label>
                    <select name="status" id="status"
                        class="block w-full bg-gray-200 text-gray-700 border border-gray-200 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
                        <option value="{{ $transaction->status }}">{{ $transaction->status }}</option>
                        <option disabled>-----------------</option>
                        <option value="PENDING">PENDING</option>
                        <option value="SUCCESS">SUCCESS</option>
                        <option value="CHALLENGE">CHALLENGE</option>
                        <option value="FAILED">FAILED</option>
                        <option value="SHIPPING">SHIPPING</option>
                        <option value="SHIPPED">SHIPPED</option>
                    </select>
                </div>
                <div class="flex flex-wrap -mx-3 mb-6">
                    <div class="w-full px-3 text-right">
                        <button type="submit"
                            class=" shadow-lg bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Update Data
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
