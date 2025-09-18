@props([
    'accept' => '*',
    'multiple' => false,
    'maxSize' => 10, // MB
    'label' => 'Upload File',
    'hint' => '',
    'required' => false,
    'showList' => true,
    'allowedTypes' => [],
    'previewImages' => true
])

<div class="file-upload-component">
    <v-file-input
        v-model="files"
        :label="'{{ $label }}'"
        :hint="'{{ $hint }}'"
        :accept="'{{ $accept }}'"
        :multiple="{{ $multiple ? 'true' : 'false' }}"
        :required="{{ $required ? 'true' : 'false' }}"
        :rules="fileRules"
        prepend-icon="mdi-paperclip"
        show-size
        counter
        variant="outlined"
        {{ $attributes }}
        @change="handleFileChange"
    >
        <template v-slot:selection="{ fileNames }">
            <template v-for="fileName in fileNames" :key="fileName">
                <v-chip
                    size="small"
                    label
                    color="primary"
                    class="me-2"
                >
                    @{{ fileName }}
                </v-chip>
            </template>
        </template>
    </v-file-input>

    <!-- File Preview -->
    @if($showList)
        <div v-if="uploadedFiles.length > 0" class="mt-4">
            <v-list density="compact">
                <v-list-subheader>{{ __('Uploaded Files') }}</v-list-subheader>
                <v-list-item
                    v-for="(file, index) in uploadedFiles"
                    :key="index"
                    class="px-0"
                >
                    <template v-slot:prepend>
                        <v-avatar v-if="file.type && file.type.startsWith('image/') && previewImages">
                            <v-img :src="file.preview" :alt="file.name"></v-img>
                        </v-avatar>
                        <v-icon v-else>
                            @{{ getFileIcon(file.type) }}
                        </v-icon>
                    </template>

                    <v-list-item-title>@{{ file.name }}</v-list-item-title>
                    <v-list-item-subtitle>
                        @{{ formatFileSize(file.size) }}
                        <span v-if="file.type"> • @{{ file.type }}</span>
                    </v-list-item-subtitle>

                    <template v-slot:append>
                        <v-progress-circular
                            v-if="file.uploading"
                            :model-value="file.progress"
                            size="20"
                            width="2"
                            color="primary"
                        ></v-progress-circular>

                        <v-icon
                            v-else-if="file.uploaded"
                            color="success"
                            size="small"
                        >
                            mdi-check-circle
                        </v-icon>

                        <v-btn
                            v-else
                            icon="mdi-delete"
                            size="small"
                            variant="text"
                            color="error"
                            @click="removeFile(index)"
                        ></v-btn>
                    </template>
                </v-list-item>
            </v-list>
        </div>
    @endif

    <!-- Upload Progress -->
    <v-progress-linear
        v-if="uploading"
        v-model="uploadProgress"
        color="primary"
        height="6"
        class="mt-2"
    ></v-progress-linear>

    <!-- Error Messages -->
    <v-alert
        v-if="uploadError"
        type="error"
        variant="tonal"
        density="compact"
        class="mt-2"
        closable
        @click:close="uploadError = ''"
    >
        @{{ uploadError }}
    </v-alert>
</div>

<script>
export default {
    props: {
        accept: {
            type: String,
            default: '*'
        },
        multiple: {
            type: Boolean,
            default: false
        },
        maxSize: {
            type: Number,
            default: 10 // MB
        },
        allowedTypes: {
            type: Array,
            default: () => []
        },
        previewImages: {
            type: Boolean,
            default: {{ $previewImages ? 'true' : 'false' }}
        },
        uploadUrl: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            files: [],
            uploadedFiles: [],
            uploading: false,
            uploadProgress: 0,
            uploadError: ''
        }
    },
    computed: {
        fileRules() {
            return [
                value => {
                    if (!value || value.length === 0) return true;

                    const files = Array.isArray(value) ? value : [value];

                    for (const file of files) {
                        // Check file size
                        if (file.size > this.maxSize * 1024 * 1024) {
                            return `{{ __('File size must be less than') }} ${this.maxSize}MB`;
                        }

                        // Check file type
                        if (this.allowedTypes.length > 0 && !this.allowedTypes.includes(file.type)) {
                            return `{{ __('File type not allowed') }}`;
                        }
                    }

                    return true;
                }
            ];
        }
    },
    methods: {
        handleFileChange(files) {
            if (!files || files.length === 0) return;

            const fileArray = Array.isArray(files) ? files : [files];

            fileArray.forEach(file => {
                const fileData = {
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    file: file,
                    uploading: false,
                    uploaded: false,
                    progress: 0,
                    preview: null
                };

                // Generate preview for images
                if (file.type && file.type.startsWith('image/') && this.previewImages) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        fileData.preview = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }

                this.uploadedFiles.push(fileData);
            });

            // Auto-upload if enabled
            if (this.autoUpload) {
                this.uploadFiles();
            }
        },

        async uploadFiles() {
            const filesToUpload = this.uploadedFiles.filter(f => !f.uploaded && !f.uploading);

            if (filesToUpload.length === 0) return;

            this.uploading = true;
            this.uploadError = '';

            for (const fileData of filesToUpload) {
                try {
                    await this.uploadSingleFile(fileData);
                } catch (error) {
                    this.uploadError = error.message || '{{ __("Upload failed") }}';
                    break;
                }
            }

            this.uploading = false;
        },

        async uploadSingleFile(fileData) {
            const formData = new FormData();
            formData.append('file', fileData.file);

            fileData.uploading = true;

            try {
                const response = await axios.post(this.uploadUrl, formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    },
                    onUploadProgress: (progressEvent) => {
                        fileData.progress = Math.round(
                            (progressEvent.loaded * 100) / progressEvent.total
                        );

                        // Update overall progress
                        const totalProgress = this.uploadedFiles.reduce((sum, f) => {
                            return sum + (f.uploading ? f.progress : (f.uploaded ? 100 : 0));
                        }, 0);
                        this.uploadProgress = totalProgress / this.uploadedFiles.length;
                    }
                });

                fileData.uploaded = true;
                fileData.uploading = false;
                fileData.progress = 100;
                fileData.url = response.data.data.file.url;
                fileData.id = response.data.data.file.id;

                // Emit uploaded event
                this.$emit('uploaded', fileData);

            } catch (error) {
                fileData.uploading = false;
                fileData.progress = 0;
                throw error;
            }
        },

        removeFile(index) {
            this.uploadedFiles.splice(index, 1);
        },

        getFileIcon(type) {
            if (!type) return 'mdi-file';

            if (type.startsWith('image/')) return 'mdi-file-image';
            if (type.startsWith('video/')) return 'mdi-file-video';
            if (type.startsWith('audio/')) return 'mdi-file-music';
            if (type.includes('pdf')) return 'mdi-file-pdf-box';
            if (type.includes('word') || type.includes('document')) return 'mdi-file-word';
            if (type.includes('excel') || type.includes('spreadsheet')) return 'mdi-file-excel';
            if (type.includes('powerpoint') || type.includes('presentation')) return 'mdi-file-powerpoint';
            if (type.includes('zip') || type.includes('rar') || type.includes('7z')) return 'mdi-folder-zip';
            if (type.includes('text')) return 'mdi-file-document';

            return 'mdi-file';
        },

        formatFileSize(bytes) {
            if (bytes === 0) return '0 Bytes';

            const k = 1024;
            const sizes = ['Bytes', 'KB', 'MB', 'GB'];
            const i = Math.floor(Math.log(bytes) / Math.log(k));

            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
        }
    }
}
</script>

<style scoped>
.file-upload-component {
    width: 100%;
}

.v-list-item {
    border-radius: 8px;
    margin-bottom: 4px;
}

.v-list-item:hover {
    background-color: rgba(0, 0, 0, 0.04);
}
</style>