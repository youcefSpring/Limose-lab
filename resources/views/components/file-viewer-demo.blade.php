{{--
    FILE VIEWER COMPONENT - DEMO PAGE
    This file demonstrates all usage patterns of the file-viewer component.
    Access via route: /demo/file-viewer (create this route if needed)
--}}

<x-app-layout>
    <div class="max-w-7xl mx-auto space-y-8">
        <!-- Page Header -->
        <div class="glass-card rounded-xl p-6">
            <h1 class="text-3xl font-bold mb-2">File Viewer Component Demo</h1>
            <p class="text-zinc-600 dark:text-zinc-400">
                Comprehensive demonstration of the file-viewer component with various configurations.
            </p>
        </div>

        <!-- Demo 1: Single Image -->
        <div>
            <h2 class="text-2xl font-bold mb-4">1. Single Image Viewer</h2>
            <x-file-viewer
                :files="'storage/demo/single-image.jpg'"
                title="Single Image Example"
                maxHeight="500px"
            />
        </div>

        <!-- Demo 2: Multiple Images with Carousel -->
        <div>
            <h2 class="text-2xl font-bold mb-4">2. Image Carousel with Thumbnails</h2>
            <x-file-viewer
                :files="[
                    'storage/demo/image1.jpg',
                    'storage/demo/image2.jpg',
                    'storage/demo/image3.jpg',
                    'storage/demo/image4.jpg',
                    'storage/demo/image5.jpg'
                ]"
                type="image"
                title="Research Lab Gallery"
                :showFullscreen="true"
                maxHeight="600px"
            />
            <div class="mt-4 p-4 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                <p class="text-sm text-amber-800 dark:text-amber-200">
                    <strong>Features:</strong> Swipe/drag to navigate • Click thumbnails to jump • Fullscreen mode • Keyboard navigation (arrows)
                </p>
            </div>
        </div>

        <!-- Demo 3: PDF Viewer -->
        <div>
            <h2 class="text-2xl font-bold mb-4">3. PDF Document Viewer</h2>
            <x-file-viewer
                :files="'storage/demo/research-paper.pdf'"
                type="pdf"
                title="Research Paper - Advanced Materials Study"
                :showDownload="true"
                maxHeight="700px"
            />
            <div class="mt-4 p-4 bg-rose-50 dark:bg-rose-900/20 rounded-xl">
                <p class="text-sm text-rose-800 dark:text-rose-200">
                    <strong>Features:</strong> Embedded PDF viewer • Download button • Full scrolling support
                </p>
            </div>
        </div>

        <!-- Demo 4: Document Viewer -->
        <div>
            <h2 class="text-2xl font-bold mb-4">4. Document Viewer</h2>
            <x-file-viewer
                :files="'storage/demo/report.docx'"
                title="Annual Laboratory Report"
                :showDownload="true"
                maxHeight="500px"
            />
            <div class="mt-4 p-4 bg-cyan-50 dark:bg-cyan-900/20 rounded-xl">
                <p class="text-sm text-cyan-800 dark:text-cyan-200">
                    <strong>Note:</strong> .docx files cannot be previewed in browsers. Download button is provided.
                </p>
            </div>
        </div>

        <!-- Demo 5: Text File Viewer -->
        <div>
            <h2 class="text-2xl font-bold mb-4">5. Text File Viewer</h2>
            <x-file-viewer
                :files="'storage/demo/readme.txt'"
                title="Project README"
                maxHeight="400px"
            />
            <div class="mt-4 p-4 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                <p class="text-sm text-emerald-800 dark:text-emerald-200">
                    <strong>Supported text formats:</strong> .txt, .html, .xml, .json, .csv (viewable in iframe)
                </p>
            </div>
        </div>

        <!-- Demo 6: Auto-detection -->
        <div>
            <h2 class="text-2xl font-bold mb-4">6. Auto-detection Example</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <x-file-viewer
                    :files="'storage/demo/auto-image.png'"
                    title="Auto-detected: Image"
                    maxHeight="300px"
                />
                <x-file-viewer
                    :files="'storage/demo/auto-pdf.pdf'"
                    title="Auto-detected: PDF"
                    maxHeight="300px"
                />
            </div>
            <div class="mt-4 p-4 bg-violet-50 dark:bg-violet-900/20 rounded-xl">
                <p class="text-sm text-violet-800 dark:text-violet-200">
                    <strong>Auto-detection:</strong> Component automatically detects file type from extension
                </p>
            </div>
        </div>

        <!-- Demo 7: Empty State -->
        <div>
            <h2 class="text-2xl font-bold mb-4">7. Empty State</h2>
            <x-file-viewer :files="[]" />
            <div class="mt-4 p-4 bg-zinc-100 dark:bg-zinc-800 rounded-xl">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                    <strong>Empty state:</strong> Displayed when no files are provided
                </p>
            </div>
        </div>

        <!-- Demo 8: Minimal Configuration -->
        <div>
            <h2 class="text-2xl font-bold mb-4">8. Minimal Configuration</h2>
            <x-file-viewer :files="'storage/demo/minimal.jpg'" />
            <div class="mt-4 p-4 bg-zinc-100 dark:bg-zinc-800 rounded-xl">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                    <strong>Minimal usage:</strong> Only the files prop is required
                </p>
            </div>
        </div>

        <!-- Demo 9: Custom Height -->
        <div>
            <h2 class="text-2xl font-bold mb-4">9. Custom Height Example</h2>
            <x-file-viewer
                :files="'storage/demo/tall-image.jpg'"
                title="Tall Image - Custom Height"
                maxHeight="300px"
            />
            <div class="mt-4 p-4 bg-zinc-100 dark:bg-zinc-800 rounded-xl">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                    <strong>Custom height:</strong> Set to 300px (default is 600px)
                </p>
            </div>
        </div>

        <!-- Demo 10: Without Download Button -->
        <div>
            <h2 class="text-2xl font-bold mb-4">10. Hidden Download Button</h2>
            <x-file-viewer
                :files="'storage/demo/protected.pdf'"
                title="Protected Document"
                :showDownload="false"
                maxHeight="500px"
            />
            <div class="mt-4 p-4 bg-zinc-100 dark:bg-zinc-800 rounded-xl">
                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                    <strong>Download disabled:</strong> Use :showDownload="false" to hide download option
                </p>
            </div>
        </div>

        <!-- Usage Code Examples -->
        <div class="glass-card rounded-xl p-6">
            <h2 class="text-2xl font-bold mb-4">Code Examples</h2>

            <!-- Example 1 -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2 text-accent-amber">Single Image:</h3>
                <pre class="bg-zinc-900 text-zinc-100 p-4 rounded-lg overflow-x-auto text-sm"><code>&lt;x-file-viewer
    :files="'storage/demo/single-image.jpg'"
    title="Single Image Example"
    maxHeight="500px"
/&gt;</code></pre>
            </div>

            <!-- Example 2 -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2 text-accent-violet">Multiple Images:</h3>
                <pre class="bg-zinc-900 text-zinc-100 p-4 rounded-lg overflow-x-auto text-sm"><code>&lt;x-file-viewer
    :files="['image1.jpg', 'image2.jpg', 'image3.jpg']"
    type="image"
    title="Gallery"
    :showFullscreen="true"
/&gt;</code></pre>
            </div>

            <!-- Example 3 -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold mb-2 text-accent-rose">PDF Document:</h3>
                <pre class="bg-zinc-900 text-zinc-100 p-4 rounded-lg overflow-x-auto text-sm"><code>&lt;x-file-viewer
    :files="'storage/document.pdf'"
    type="pdf"
    title="Research Paper"
    :showDownload="true"
    maxHeight="700px"
/&gt;</code></pre>
            </div>

            <!-- Example 4 -->
            <div>
                <h3 class="text-lg font-semibold mb-2 text-accent-cyan">From Database:</h3>
                <pre class="bg-zinc-900 text-zinc-100 p-4 rounded-lg overflow-x-auto text-sm"><code>&lt;x-file-viewer
    :files="$publication-&gt;images"
    title="{{ $publication-&gt;title }}"
/&gt;</code></pre>
            </div>
        </div>

        <!-- Props Reference -->
        <div class="glass-card rounded-xl p-6">
            <h2 class="text-2xl font-bold mb-4">Props Reference</h2>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-zinc-200 dark:border-zinc-700">
                            <th class="text-left py-3 px-4 font-semibold">Prop</th>
                            <th class="text-left py-3 px-4 font-semibold">Type</th>
                            <th class="text-left py-3 px-4 font-semibold">Default</th>
                            <th class="text-left py-3 px-4 font-semibold">Description</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-700">
                        <tr>
                            <td class="py-3 px-4 font-mono text-accent-amber">files</td>
                            <td class="py-3 px-4">array|string</td>
                            <td class="py-3 px-4 text-zinc-500">-</td>
                            <td class="py-3 px-4">File path(s) to display (required)</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-mono text-accent-amber">type</td>
                            <td class="py-3 px-4">string</td>
                            <td class="py-3 px-4 text-zinc-500">'auto'</td>
                            <td class="py-3 px-4">File type: 'auto', 'image', 'pdf', 'document'</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-mono text-accent-amber">title</td>
                            <td class="py-3 px-4">string|null</td>
                            <td class="py-3 px-4 text-zinc-500">null</td>
                            <td class="py-3 px-4">Header title</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-mono text-accent-amber">showDownload</td>
                            <td class="py-3 px-4">boolean</td>
                            <td class="py-3 px-4 text-zinc-500">true</td>
                            <td class="py-3 px-4">Show download button</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-mono text-accent-amber">showFullscreen</td>
                            <td class="py-3 px-4">boolean</td>
                            <td class="py-3 px-4 text-zinc-500">true</td>
                            <td class="py-3 px-4">Show fullscreen button (images only)</td>
                        </tr>
                        <tr>
                            <td class="py-3 px-4 font-mono text-accent-amber">maxHeight</td>
                            <td class="py-3 px-4">string</td>
                            <td class="py-3 px-4 text-zinc-500">'600px'</td>
                            <td class="py-3 px-4">Maximum viewer height</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Features List -->
        <div class="glass-card rounded-xl p-6">
            <h2 class="text-2xl font-bold mb-4">Component Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold mb-3 text-accent-amber">Image Viewer</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Swiper.js carousel with smooth transitions</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Thumbnail navigation for multiple images</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Fullscreen mode with ESC to exit</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Keyboard navigation (arrow keys)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Touch/swipe gestures for mobile</span>
                        </li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-3 text-accent-violet">General Features</h3>
                    <ul class="space-y-2 text-sm">
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Glassmorphic design matching RLMS theme</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Automatic light/dark mode support</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Auto-detection of file types</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>Download functionality for all file types</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <svg class="w-5 h-5 text-accent-emerald flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            <span>RTL support (Arabic)</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
