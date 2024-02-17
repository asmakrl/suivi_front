<div>
    <div>
        <section class="mt-10">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <!-- Start coding here -->
                <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                    <div class="flex items-center justify-between d p-4">
                        <div class="flex">
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 " placeholder="Search" required="">
                            </div>
                        </div>
                        <div class="flex space-x-3">
                            <div class="flex space-x-3 items-center">
                                <label class="w-40 text-sm font-medium text-gray-900">User Type :</label>
                                <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option value="">All</option>
                                    <option value="0">User</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">Title</th>
                                <th scope="col" class="px-4 py-3">Description</th>
                                <th scope="col" class="px-4 py-3">Received At</th>
                                <th scope="col" class="px-4 py-3">Action</th>
                                <th scope="col" class="px-4 py-3">Show Request</th>
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach( $requests as $item)
                                <tr wire:key="{{$item['id']}}" class="border-b dark:border-gray-700">
                                    <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{$item['title']}}
                                    </th>
                                    <td class="px-4 py-3">{{$item['description']}}</td>
                                    <td class="px-4 py-3">{{$item['received_at']}}</td>
                                    <td class="px-4 py-3 text-green-500" >
                                        <ul>
                                            @forelse($item['action'] as $action)
                                                <li>{{ $action['type']['action_type'] }}</li>
                                            @empty
                                                <li>No actions available.</li>
                                            @endforelse
                                        </ul>
                                    </td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button  wire:click="goToLink4({{$item['id']}})" class="px-3 py-1 bg-red-500 text-white rounded">Show Request</button>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button  wire:click="goToLink3({{$item['id']}})" class="px-3 py-1 bg-red-500 text-white rounded">Add Action</button>
                                    </td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <button  wire:click="goToLink2({{$item['id']}})" class="px-3 py-1 bg-red-500 text-white rounded">E</button>
                                        <button onclick="confirm('Are you sure you want to delete this request?')" wire:click="delete({{$item['id']}})" class="px-3 py-1 bg-red-500 text-white rounded">X</button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="py-4 px-3">
                        <div class="flex ">
                            <div class="flex space-x-4 items-center mb-3">
                                <label class="w-32 text-sm font-medium text-gray-900">Per Page</label>
                                <select
                                    wire:model='size' wire:change="changeSize($event.target.value)"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <div class="px-4 py-3 flex items-center justify-end">
                                    <button wire:click="goToLink()" class="px-3 py-1 bg-blue-500 text-white rounded">Add Request</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <nav aria-label="Page navigation example">
                <ul class="flex list-none pl-0 rounded my-2">
                    @for ($i = 1; $i <= $totalPages; $i++) <li class="relative block py-2 px-3 leading-tight bg-white border border-gray-300 text-blue-700 border-r-0 ml-0.5 first:ml-0 first:rounded-l">
                        <button wire:click="goToPage({{ $i }})" class="{{ $i == $currentPage ? 'bg-red-500 text-white' : 'bg-transparent hover:bg-blue-500 text-blue-700 font-semibold hover:text-white py-2 px-4 border border-blue-500 hover:border-transparent rounded' }}">
                            {{ $i }}
                        </button>
                    </li>
                    @endfor
                </ul>
            </nav>
        </section>
    </div>
</div>
