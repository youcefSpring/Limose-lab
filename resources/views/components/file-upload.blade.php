@props([
    'name' => 'file',
    'label' => null,
    'required' => false,
    'currentFile' => null,
    'accept' => 'image/*,.pdf,.doc,.docx,.odt,.txt',
    'error' => null,
    'maxSize' => '10MB'
])

@php
    $hasError = $error || $errors->has($name);
    $errorMessage = $error ?? $errors->first($name);

    // Generate unique ID for this instance
    $uniqueId = 'file-upload-' . Str::random(8);
@endphp

<div x-data="{
    fileName: '{{ $currentFile ? basename($currentFile) : '' }}',
    fileSize: '',
    fileType: '{{ $currentFile ? 'image' : '' }}',
    previewUrl: '{{ $currentFile ?? '' }}',
    isDragging: false,

    init() {
        // Auto-detect file type from currentFile if it exists
        @if($currentFile)
            const currentFileName = '{{ basename($currentFile) }}';
            const ext = currentFileName.split('.').pop().toLowerCase();

            if (['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp', 'bmp'].includes(ext)) {
                this.fileType = 'image';
            } else if (ext === 'pdf') {
                this.fileType = 'pdf';
            } else if (['doc', 'docx', 'odt', 'txt'].includes(ext)) {
                this.fileType = 'document';
            }
        @endif
    },

    handleFileSelect(event) {
        const file = event.target.files[0];
        if (file) {
            this.processFile(file);
        }
    },

    processFile(file) {
        this.fileName = file.name;
        this.fileSize = this.formatFileSize(file.size);
        this.fileType = this.getFileType(file);

        // Generate preview for images
        if (this.fileType === 'image') {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.previewUrl = e.target.result;
            };
            reader.readAsDataURL(file);
        } else {
            this.previewUrl = '';
        }
    },

    getFileType(file) {
        const type = file.type.toLowerCase();
        if (type.startsWith('image/')) return 'image';
        if (type === 'application/pdf') return 'pdf';
        if (type.includes('word') || type.includes('document') ||
            type === 'text/plain' || type.includes('opendocument')) return 'document';
        return 'unknown';
    },

    formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
    },

    removeFile() {
        this.fileName = '';
        this.fileSize = '';
        this.fileType = '';
        this.previewUrl = '';
        const input = document.getElementById('{{ $uniqueId }}');
        if (input) {
            input.value = '';
        }
    },

    handleDragOver(event) {
        event.preventDefault();
        this.isDragging = true;
    },

    handleDragLeave() {
        this.isDragging = false;
    },

    handleDrop(event) {
        event.preventDefault();
        this.isDragging = false;

        const file = event.dataTransfer.files[0];
        if (file) {
            // Set file to input element
            const dataTransfer = new DataTransfer();
            dataTransfer.items.add(file);
            document.getElementById('{{ $uniqueId }}').files = dataTransfer.files;

            this.processFile(file);
        }
    }
}" class="w-full">

    @if($label)
        <label for="{{ $uniqueId }}" class="block text-sm font-medium mb-2">
            {{ $label }}
            @if($required)
                <span class="text-accent-rose">*</span>
            @endif
        </label>
    @endif

    <!-- File Input (Hidden) -->
    <input
        type="file"
        id="{{ $uniqueId }}"
        name="{{ $name }}"
        accept="{{ $accept }}"
        @if($required) required @endif
        @change="handleFileSelect($event)"
        class="sr-only"
        {{ $attributes }}
    />

    <!-- Upload Area -->
    <div
        @dragover="handleDragOver($event)"
        @dragleave="handleDragLeave()"
        @drop="handleDrop($event)"
        :class="isDragging ? 'border-accent-violet bg-accent-violet/5' : 'border-black/10 dark:border-white/10'"
        class="relative flex justify-center px-6 pt-8 pb-8 border-2 border-dashed rounded-xl hover:border-accent-violet/50 dark:hover:border-accent-violet/50 transition-all bg-white dark:bg-surface-700/30 @error($name) border-accent-rose @enderror">

        <!-- Preview Area (shown when file is selected) -->
        <div x-show="fileName" x-cloak class="w-full">
            <!-- Image Preview -->
            <div x-show="fileType === 'image'" class="space-y-4">
                <div class="flex justify-center">
                    <img :src="previewUrl" :alt="fileName" class="max-h-48 rounded-lg shadow-lg">
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium" x-text="fileName"></p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400" x-text="fileSize"></p>
                </div>
            </div>

            <!-- PDF Preview -->
            <div x-show="fileType === 'pdf'" class="space-y-4">
                <div class="flex justify-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-2xl bg-accent-rose/10">
                        <svg class="w-12 h-12 text-accent-rose" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6"/>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium" x-text="fileName"></p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400" x-text="fileSize"></p>
                </div>
            </div>

            <!-- Document Preview -->
            <div x-show="fileType === 'document'" class="space-y-4">
                <div class="flex justify-center">
                    <div class="inline-flex items-center justify-center w-24 h-24 rounded-2xl bg-accent-cyan/10">
                        <svg class="w-12 h-12 text-accent-cyan" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                </div>
                <div class="text-center">
                    <p class="text-sm font-medium" x-text="fileName"></p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400" x-text="fileSize"></p>
                </div>
            </div>

            <!-- Remove Button -->
            <div class="flex justify-center mt-4">
                <button
                    type="button"
                    @click="removeFile()"
                    class="flex items-center gap-2 px-4 py-2 rounded-xl glass hover:glass-card text-sm font-medium transition-all hover:text-accent-rose">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                    {{ __('Remove File') }}
                </button>
            </div>
        </div>

        <!-- Upload Prompt (shown when no file is selected) -->
        <div x-show="!fileName" x-cloak class="space-y-3 text-center">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-accent-violet/10 mb-2 transition-all" :class="isDragging ? 'scale-110' : 'scale-100'">
                <svg class="w-8 h-8 text-accent-violet" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                </svg>
            </div>

            <div class="flex text-sm justify-center">
                <label for="{{ $uniqueId }}" class="relative cursor-pointer rounded-md font-medium text-accent-violet hover:text-accent-amber transition-colors px-2">
                    <span>{{ __('Upload a file') }}</span>
                </label>
                <p class="text-zinc-500 dark:text-zinc-400">{{ __('or drag and drop') }}</p>
            </div>

            <div class="space-y-1">
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    {{ __('Supported formats: Images (JPG, PNG, GIF, SVG, WEBP), PDFs, Documents (DOC, DOCX, ODT, TXT)') }}
                </p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400">
                    {{ __('Maximum file size:') }} {{ $maxSize }}
                </p>
            </div>

            @if($currentFile)
                <div class="pt-3 mt-3 border-t border-black/10 dark:border-white/10">
                    <p class="text-xs text-zinc-500 dark:text-zinc-400">{{ __('Current file:') }}</p>
                    <p class="text-sm font-medium text-accent-amber mt-1">{{ basename($currentFile) }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Error Message -->
    @if($hasError)
        <p class="mt-2 text-sm text-accent-rose">{{ $errorMessage }}</p>
    @endif
</div>

<style>
    [x-cloak] { display: none !important; }
</style>
