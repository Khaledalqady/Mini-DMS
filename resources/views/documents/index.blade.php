

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mini-DMS - Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
    <div class="container mx-auto p-6 ">
        <h1 class="text-2xl font-bold mb-4">Document Management</h1>
        
        @if (session('status'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="flex justify-end p-4">
            <form method="Post" action="/logout">
            @csrf
            @method('DELETE')
            <button class="text-blue-600 font-bold border border-blue-600 px-4 py-2 rounded hover:underline">Log Out</button>
            </form>

        </div>

        <!-- Upload Form -->
        <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data" class="mb-8">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-sm font-medium text-gray-700">Document Title</label>
                <input type="text" name="title" id="title" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                @error('title')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-4">
                <label for="file" class="block text-sm font-medium text-gray-700">Upload File (PDF, DOCX, TXT)</label>
                <input type="file" name="file" id="file" class="mt-1 block w-full" accept=".pdf,.docx,.txt" required>
                @error('file')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="bg-indigo-600 text-black px-4 py-2 rounded-md hover:bg-indigo-700">Upload</button>
        </form>


       @if ($documents->isNotEmpty())
           <a href="{{ Storage::url($documents->first()->file_path) }}" target="_blank" class="text-indigo-600 border border-blue-600 px-4 py-2 rounded hover:text-indigo-900 mr-4 mb-2">
               Preview First
           </a>
       @endif



        <!-- Document List -->
        <div class="bg-white shadow overflow-hidden sm:rounded-md">
            <ul class="divide-y divide-gray-200">
                @forelse ($documents as $document)
                    <li class="px-6 py-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $document->title }}</p>
                                <p class="text-sm text-gray-500">Uploaded: {{ $document->created_at->format('M d, Y') }}</p>
                            </div>
                            <div>
                                <a href="{{ route('documents.download', $document->id) }}" class="text-indigo-600 hover:text-indigo-900 mr-4">Download</a>
                                <form action="{{ route('documents.destroy', $document->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure you want to delete this document?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="px-6 py-4 text-gray-500">No documents uploaded yet.</li>
                @endforelse
            </ul>
        </div>
    </div>
</body>
</html>