<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Theme') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <button id="createThemeButton" class="bg-blue-500 text-white px-6 py-2 rounded-lg">
                        <i class="fa-solid fa-square-plus mr-2"></i> Create Theme
                    </button><br><br>

                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="themesTable" class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50 text-gray-700 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="px-6 py-3 text-left">No</th>
                                    <th class="px-6 py-3 text-left">Name</th>
                                    <th class="px-6 py-3 text-left">Description</th>
                                    <th class="px-6 py-3 text-left">Status</th>
                                    <th class="px-6 py-3 text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-gray-700 text-sm">
                                <!-- DataTables will populate the table body -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Create Theme-->
    <div id="createThemeModal" class="fixed inset-0 items-center justify-center z-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-blue-50 rounded-lg w-full max-w-lg p-6 shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-blue-800">Create New Theme</h3>
                    <button id="closeModalButton" class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                <form id="createThemeForm" class="mt-4">
                    @csrf
                    <label for="themeName" class="block text-blue-800">Theme Name</label>
                    <input type="text" id="themeName" name="themeName" class="mt-2 px-4 py-2 border border-blue-300 rounded-lg w-full" placeholder="Enter theme name" required>

                    <label for="themeDescription" class="block text-blue-800 mt-4">Theme Description</label>
                    <textarea id="themeDescription" name="themeDescription" class="mt-2 px-4 py-2 border border-blue-300 rounded-lg w-full" placeholder="Enter description" required></textarea>

                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-lg mt-4 w-full hover:bg-blue-600">Create</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Editing -->
    <div id="editModalTheme" class="fixed inset-0 items-center justify-center z-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-blue-50 rounded-lg w-full max-w-lg p-6 shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-blue-800">Edit Theme</h3>
                    <button id="closeModalButtonTheme" class="text-blue-500 hover:text-blue-700">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <form id="editThemeForm">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-blue-800">Name</label>
                        <input type="text" id="name" class="mt-2 px-4 py-2 border border-blue-300 rounded-lg w-full" />
                    </div>
                    <div class="mb-4">
                        <label for="description" class="block text-blue-800">Description</label>
                        <textarea id="description" class="mt-2 px-4 py-2 border border-blue-300 rounded-lg w-full"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="block text-blue-800">Status</label>
                        <select id="status" class="mt-2 px-4 py-2 border border-blue-300 rounded-lg w-full">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">Save</button>
                        <button type="button" id="cancelModal" class="px-6 py-2 bg-gray-500 text-white rounded-md ml-2 hover:bg-gray-600">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('script')
    @include('master.themes.script')
    @endsection
</x-app-layout>