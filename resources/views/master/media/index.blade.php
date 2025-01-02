<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Media') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <button id="createMediaButton" class="bg-green-500 text-white px-6 py-2 rounded-lg">
                        <i class="fa-solid fa-square-plus mr-2"></i> Create Media
                    </button><br><br>

                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="mediaTable" class="min-w-full bg-white border border-gray-200 rounded-lg">
                            <thead class="bg-gray-50 text-gray-700 uppercase text-sm leading-normal">
                                <tr>
                                    <th class="px-6 py-3 text-left">No</th>
                                    <th class="px-6 py-3 text-left">Name</th>
                                    <th class="px-6 py-3 text-left">Description</th>
                                    <th class="px-6 py-3 text-left">Theme</th>
                                    <th class="px-6 py-3 text-left">Type File</th>
                                    <th class="px-6 py-3 text-left">File</th>
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


    <!-- Modal Create Media-->
    <div id="createMediaModal" class="fixed inset-0 items-center justify-center z-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-green-50 rounded-lg w-full max-w-lg p-6 shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-green-800">Create New Media</h3>
                    <button id="closeModalButtonMedia" class="text-green-500 hover:text-green-700">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>

                <form id="createMediaForm" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    <label for="mediaName" class="block text-green-800">Media Name</label>
                    <input type="text" id="mediaName" name="mediaName" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full" placeholder="Enter media name" required>

                    <label for="mediaDescription" class="block text-green-800 mt-4">Media Description</label>
                    <textarea id="mediaDescription" name="mediaDescription" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full" placeholder="Enter description" required></textarea>

                    <label for="mediaType" class="block text-green-800">Media Type:</label>
                    <div class="mb-4">
                        <select id="mediaType" name="mediaType" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full" required>
                            <option value="image">Image</option>
                            <option value="quiz">Quiz</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <label for="mediaTheme" class="block text-green-800">Theme:</label>
                    <select id="mediaTheme" name="mediaTheme" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full">
                        @if($themes->isEmpty())
                        <option disabled>No themes available</option>
                        @else
                        @foreach($themes as $theme)
                        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                        @endforeach
                        @endif
                    </select>

                    <label for="mediaFile" class="block text-green-800">Image:</label>
                    <input type="file" id="mediaFile" name="mediaFile" class="mt-2">

                    <label for="mediaSound" class="block text-green-800">Sound:</label>
                    <input type="file" id="mediaSound" name="mediaSound" class="mt-2">

                    <label for="mediaVideo" class="block text-green-800">Video:</label>
                    <input type="file" id="mediaVideo" name="mediaVideo" class="mt-2">

                    <label for="mediaQuiz" class="block text-green-800">Link</label>
                    <input type="text" id="mediaQuiz" name="mediaQuiz" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full" placeholder="Enter Link Quizi">


                    <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-lg mt-4 w-full hover:bg-blue-600">Create</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal for Editing -->
    <div id="editModalMedia" class="fixed inset-0 items-center justify-center z-50 hidden">
        <div class="flex items-center justify-center min-h-screen">
            <div class="bg-green-50 rounded-lg w-full max-w-lg p-6 shadow-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-xl font-semibold text-green-800">Edit Media</h3>
                    <button id="closeModalButtonMedia" class="text-green-500 hover:text-green-700">
                        <i class="fa-solid fa-times"></i>
                    </button>
                </div>
                <form id="editMediaForm" class="mt-4" enctype="multipart/form-data">
                    @csrf
                    <label for="mediaNameEdit" class="block text-green-800">Media Name</label>
                    <input type="text" id="mediaNameEdit" name="mediaNameEdit" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full" placeholder="Enter media name" required>

                    <label for="mediaDescriptionEdit" class="block text-green-800 mt-4">Media Description</label>
                    <textarea id="mediaDescriptionEdit" name="mediaDescriptionEdit" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full" placeholder="Enter description" required></textarea>

                    <label for="mediaTypeEdit" class="block text-green-800">Media Type:</label>
                    <div class="mb-4">
                        <select id="mediaTypeEdit" name="mediaTypeEdit" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full" required>
                            <option value="image">Image</option>
                            <option value="quiz">Quiz</option>
                            <option value="video">Video</option>
                        </select>
                    </div>

                    <label for="mediaThemeEdit" class="block text-green-800">Theme:</label>
                    <select id="mediaThemeEdit" name="mediaThemeEdit" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full">
                        @if($themes->isEmpty())
                        <option disabled>No themes available</option>
                        @else
                        @foreach($themes as $theme)
                        <option value="{{ $theme->id }}">{{ $theme->name }}</option>
                        @endforeach
                        @endif
                    </select>
                    <div class="mb-4">
                        <label for="mediaStatusEdit" class="block text-green-800">Status</label>
                        <select id="mediaStatusEdit" name="mediaStatusEdit" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full">
                            <option value="1">Enabled</option>
                            <option value="0">Disabled</option>
                        </select>
                    </div>
                    <label for="mediaFileEdit" class="block text-green-800">Image:</label>
                    <input type="file" id="mediaFileEdit" name="mediaFileEdit" class="mt-2">

                    <label for="mediaSoundEdit" class="block text-green-800">Sound:</label>
                    <input type="file" id="mediaSoundEdit" name="mediaSoundEdit" class="mt-2">

                    <label for="mediaVideoEdit" class="block text-green-800">Video:</label>
                    <input type="file" id="mediaVideoEdit" name="mediaVideoEdit" class="mt-2">

                    <label for="mediaQuizEdit" class="block text-green-800">Link</label>
                    <input type="text" id="mediaQuizEdit" name="mediaQuizEdit" class="mt-2 px-4 py-2 border border-green-300 rounded-lg w-full" placeholder="Enter Link Quizi">

                    <div class="flex justify-end">
                        <button type="submit" class="px-6 py-2 bg-green-500 text-white rounded-md hover:bg-green-600">Save</button>
                        <button type="button" id="cancelModalMedia" class="px-6 py-2 bg-gray-500 text-white rounded-md ml-2 hover:bg-gray-600">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @section('script')
    @include('master.media.script')
    @endsection
</x-app-layout>