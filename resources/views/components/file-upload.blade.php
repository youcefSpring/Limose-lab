@props([
    'accept' => '*',
    'multiple' => false,
    'maxSize' => 10, // MB
    'label' => 'Upload File',
    'hint' => '',
    'required' => false,
    'showPreview' => true,
    'name' => 'file',
    'id' => null,
    'allowedTypes' => []
])

@php
    $inputId = $id ?? 'file-upload-' . uniqid();
@endphp

<div class="file-upload-component">
    <div class="mb-3">
        <label for="{{ $inputId }}" class="form-label">
            {{ $label }}
            @if($required)
                <span class="text-danger">*</span>
            @endif
        </label>

        <input type="file"
               class="form-control @error($name) is-invalid @enderror"
               id="{{ $inputId }}"
               name="{{ $multiple ? $name . '[]' : $name }}"
               accept="{{ $accept }}"
               @if($multiple) multiple @endif
               @if($required) required @endif
               onchange="handleFileSelect(this)"
               {{ $attributes }}>

        @if($hint)
            <div class="form-text">{{ $hint }}</div>
        @endif

        @if($maxSize)
            <div class="form-text">
                {{ __('Maximum file size: :size MB', ['size' => $maxSize]) }}
                @if(!empty($allowedTypes))
                    <br>{{ __('Allowed types: :types', ['types' => implode(', ', $allowedTypes)]) }}
                @endif
            </div>
        @endif

        @error($name)
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    @if($showPreview)
    <!-- File Preview Area -->
    <div id="{{ $inputId }}-preview" class="file-preview-area" style="display: none;">
        <div class="card">
            <div class="card-header">
                <h6 class="card-title mb-0">
                    <i class="fas fa-file me-2"></i>{{ __('Selected Files') }}
                </h6>
            </div>
            <div class="card-body">
                <div id="{{ $inputId }}-file-list" class="file-list">
                    <!-- Files will be displayed here -->
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

@if($showPreview)
<script>
function handleFileSelect(input) {
    const inputId = input.id;
    const previewArea = document.getElementById(inputId + '-preview');
    const fileList = document.getElementById(inputId + '-file-list');
    const files = input.files;

    if (files.length === 0) {
        previewArea.style.display = 'none';
        return;
    }

    // Show preview area
    previewArea.style.display = 'block';
    fileList.innerHTML = '';

    // Display each file
    Array.from(files).forEach((file, index) => {
        const fileItem = document.createElement('div');
        fileItem.className = 'file-item d-flex align-items-center justify-content-between p-2 border rounded mb-2';

        const fileInfo = document.createElement('div');
        fileInfo.className = 'd-flex align-items-center';

        const fileIcon = document.createElement('i');
        fileIcon.className = 'fas ' + getFileIcon(file.type) + ' me-2 text-primary';

        const fileDetails = document.createElement('div');
        fileDetails.innerHTML = `
            <div class="fw-medium">${file.name}</div>
            <small class="text-muted">${formatFileSize(file.size)} • ${file.type || 'Unknown type'}</small>
        `;

        fileInfo.appendChild(fileIcon);
        fileInfo.appendChild(fileDetails);

        const removeBtn = document.createElement('button');
        removeBtn.type = 'button';
        removeBtn.className = 'btn btn-sm btn-outline-danger';
        removeBtn.innerHTML = '<i class="fas fa-times"></i>';
        removeBtn.onclick = function() {
            removeFileFromInput(input, index);
        };

        fileItem.appendChild(fileInfo);
        fileItem.appendChild(removeBtn);
        fileList.appendChild(fileItem);
    });

    // Validate files
    validateFiles(input, files);
}

function removeFileFromInput(input, indexToRemove) {
    const dt = new DataTransfer();
    const files = input.files;

    for (let i = 0; i < files.length; i++) {
        if (i !== indexToRemove) {
            dt.items.add(files[i]);
        }
    }

    input.files = dt.files;
    handleFileSelect(input);
}

function validateFiles(input, files) {
    const maxSize = {{ $maxSize }} * 1024 * 1024; // Convert MB to bytes
    const allowedTypes = @json($allowedTypes);
    let hasError = false;
    let errorMessage = '';

    Array.from(files).forEach(file => {
        // Check file size
        if (file.size > maxSize) {
            hasError = true;
            errorMessage = `{{ __('File size must be less than :size MB', ['size' => $maxSize]) }}`;
        }

        // Check file type
        if (allowedTypes.length > 0 && !allowedTypes.includes(file.type)) {
            hasError = true;
            errorMessage = `{{ __('File type not allowed') }}`;
        }
    });

    // Remove existing error message
    const existingError = input.parentNode.querySelector('.file-upload-error');
    if (existingError) {
        existingError.remove();
    }

    // Add error message if validation failed
    if (hasError) {
        input.classList.add('is-invalid');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback file-upload-error';
        errorDiv.textContent = errorMessage;
        input.parentNode.appendChild(errorDiv);
    } else {
        input.classList.remove('is-invalid');
    }
}

function getFileIcon(type) {
    if (!type) return 'fa-file';

    if (type.startsWith('image/')) return 'fa-file-image';
    if (type.startsWith('video/')) return 'fa-file-video';
    if (type.startsWith('audio/')) return 'fa-file-audio';
    if (type.includes('pdf')) return 'fa-file-pdf';
    if (type.includes('word') || type.includes('document')) return 'fa-file-word';
    if (type.includes('excel') || type.includes('spreadsheet')) return 'fa-file-excel';
    if (type.includes('powerpoint') || type.includes('presentation')) return 'fa-file-powerpoint';
    if (type.includes('zip') || type.includes('rar') || type.includes('7z')) return 'fa-file-archive';
    if (type.includes('text')) return 'fa-file-alt';

    return 'fa-file';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';

    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));

    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}
</script>
@endif

<style>
.file-upload-component {
    width: 100%;
}

.file-preview-area {
    margin-top: 1rem;
}

.file-item {
    background-color: #f8f9fa;
    transition: background-color 0.15s ease-in-out;
}

.file-item:hover {
    background-color: #e9ecef;
}

.file-list {
    max-height: 300px;
    overflow-y: auto;
}
</style>