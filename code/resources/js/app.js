import './bootstrap';

// Global application initialization
$(document).ready(function() {
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    const popoverList = popoverTriggerList.map(function(popoverTriggerEl) {
        return new bootstrap.Popover(popoverTriggerEl);
    });

    // Global error handler for AJAX requests
    $(document).ajaxError(function(event, xhr, settings) {
        if (xhr.status === 401) {
            window.location.href = '/login';
        } else if (xhr.status === 403) {
            showGlobalAlert('warning', 'You do not have permission to perform this action.');
        } else if (xhr.status === 500) {
            showGlobalAlert('danger', 'An internal server error occurred. Please try again later.');
        }
    });

    // Global AJAX setup
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize Select2 for all select elements with the class
    $('.select2').select2({
        theme: 'bootstrap-5',
        width: '100%'
    });

    // Initialize DataTables language
    if (typeof $.fn.dataTable !== 'undefined') {
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: getDataTablesLanguageUrl()
            }
        });
    }
});

// Global utility functions
window.showGlobalAlert = function(type, message, duration = 5000) {
    const alertClass = `alert-${type}`;
    const iconClass = {
        success: 'fas fa-check-circle',
        danger: 'fas fa-exclamation-circle',
        warning: 'fas fa-exclamation-triangle',
        info: 'fas fa-info-circle'
    }[type] || 'fas fa-info-circle';

    const alert = $(`
        <div class="alert ${alertClass} alert-dismissible fade show alert-slide position-fixed"
             style="top: 20px; right: 20px; z-index: 9999; min-width: 300px;" role="alert">
            <i class="${iconClass} me-2"></i>${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);

    $('body').append(alert);

    // Auto dismiss
    if (duration > 0) {
        setTimeout(function() {
            alert.alert('close');
        }, duration);
    }
};

window.showLoading = function() {
    if ($('#loadingOverlay').length === 0) {
        $('body').append(`
            <div class="loading-overlay d-flex flex-column justify-content-center align-items-center" id="loadingOverlay">
                <div class="loading-spinner mb-3"></div>
                <div class="h5">Loading...</div>
            </div>
        `);
    }
    $('#loadingOverlay').removeClass('d-none');
};

window.hideLoading = function() {
    $('#loadingOverlay').addClass('d-none');
};

window.formatCurrency = function(amount, currency = 'USD', locale = 'en-US') {
    return new Intl.NumberFormat(locale, {
        style: 'currency',
        currency: currency
    }).format(amount || 0);
};

window.formatDate = function(date, locale = 'en-US', options = {}) {
    const defaultOptions = {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
    };

    return new Date(date).toLocaleDateString(locale, { ...defaultOptions, ...options });
};

window.formatDateTime = function(dateTime, locale = 'en-US') {
    return new Date(dateTime).toLocaleString(locale, {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
};

window.truncateText = function(text, length) {
    if (!text) return '';
    return text.length > length ? text.substring(0, length) + '...' : text;
};

window.debounce = function(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
};

window.confirmAction = function(message, callback) {
    if (confirm(message)) {
        callback();
    }
};

// Form validation helpers
window.validateForm = function(formSelector) {
    const form = $(formSelector)[0];
    if (!form) return false;

    return form.checkValidity();
};

window.showFormErrors = function(errors) {
    // Clear previous errors
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    // Show new errors
    Object.keys(errors).forEach(field => {
        const input = $(`[name="${field}"]`);
        if (input.length) {
            input.addClass('is-invalid');
            input.after(`<div class="invalid-feedback">${errors[field][0]}</div>`);
        }
    });
};

// Data export helper
window.exportData = function(url, params = {}, filename = null) {
    const exportBtn = $('.export-btn');
    const originalText = exportBtn.html();

    exportBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Exporting...').prop('disabled', true);

    $.get(url, params)
        .done(function(response, status, xhr) {
            // Create download link
            const contentType = xhr.getResponseHeader('content-type');
            const blob = new Blob([response], { type: contentType });
            const downloadUrl = window.URL.createObjectURL(blob);
            const link = document.createElement('a');
            link.href = downloadUrl;

            // Get filename from response header or use default
            const disposition = xhr.getResponseHeader('content-disposition');
            let downloadFilename = filename;

            if (disposition && disposition.indexOf('filename=') !== -1) {
                downloadFilename = disposition.split('filename=')[1].replace(/"/g, '');
            }

            if (!downloadFilename) {
                const extension = contentType.includes('excel') ? 'xlsx' :
                                contentType.includes('csv') ? 'csv' : 'pdf';
                downloadFilename = `export-${new Date().toISOString().split('T')[0]}.${extension}`;
            }

            link.setAttribute('download', downloadFilename);
            document.body.appendChild(link);
            link.click();
            link.remove();
            window.URL.revokeObjectURL(downloadUrl);

            showGlobalAlert('success', 'Export completed successfully!');
        })
        .fail(function(xhr) {
            console.error('Export failed:', xhr);
            showGlobalAlert('danger', 'Export failed. Please try again.');
        })
        .always(function() {
            exportBtn.html(originalText).prop('disabled', false);
        });
};

// DataTables language URL helper
function getDataTablesLanguageUrl() {
    const locale = document.documentElement.lang || 'en';
    const languageUrls = {
        'ar': '//cdn.datatables.net/plug-ins/1.13.6/i18n/ar.json',
        'fr': '//cdn.datatables.net/plug-ins/1.13.6/i18n/fr-FR.json',
        'en': '' // English is default
    };

    return languageUrls[locale] || '';
}

// Table helpers
window.initializeDataTable = function(tableId, options = {}) {
    const defaultOptions = {
        responsive: true,
        pageLength: 15,
        language: {
            processing: '<div class="d-flex align-items-center"><i class="fas fa-spinner fa-spin me-2"></i>Loading...</div>',
            emptyTable: 'No data available',
            zeroRecords: 'No matching records found',
            info: 'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty: 'Showing 0 to 0 of 0 entries',
            infoFiltered: '(filtered from _MAX_ total entries)',
            lengthMenu: 'Show _MENU_ entries per page',
            search: 'Search:',
            paginate: {
                first: 'First',
                last: 'Last',
                next: 'Next',
                previous: 'Previous'
            }
        }
    };

    return $(`#${tableId}`).DataTable({ ...defaultOptions, ...options });
};

// Modal helpers
window.showModal = function(modalId) {
    $(`#${modalId}`).modal('show');
};

window.hideModal = function(modalId) {
    $(`#${modalId}`).modal('hide');
};

// Status color helpers
window.getStatusColor = function(status) {
    const colors = {
        active: '#198754',
        inactive: '#6c757d',
        pending: '#ffc107',
        completed: '#0d6efd',
        cancelled: '#dc3545',
        suspended: '#dc3545',
        operational: '#198754',
        maintenance: '#ffc107',
        out_of_order: '#dc3545',
        reserved: '#0d6efd'
    };
    return colors[status] || '#6c757d';
};

window.getStatusText = function(status) {
    const texts = {
        active: 'Active',
        inactive: 'Inactive',
        pending: 'Pending',
        completed: 'Completed',
        cancelled: 'Cancelled',
        suspended: 'Suspended',
        operational: 'Operational',
        maintenance: 'Maintenance',
        out_of_order: 'Out of Order',
        reserved: 'Reserved'
    };
    return texts[status] || status;
};

// Theme helpers
window.setTheme = function(theme) {
    document.documentElement.setAttribute('data-bs-theme', theme);
    localStorage.setItem('theme', theme);
};

window.getTheme = function() {
    return localStorage.getItem('theme') || 'light';
};

// Initialize theme
document.documentElement.setAttribute('data-bs-theme', getTheme());

// Custom events
$(document).on('click', '[data-confirm]', function(e) {
    const message = $(this).data('confirm');
    if (!confirm(message)) {
        e.preventDefault();
        return false;
    }
});

$(document).on('click', '[data-loading]', function() {
    const btn = $(this);
    const loadingText = btn.data('loading') || 'Loading...';
    const originalText = btn.html();

    btn.data('original-text', originalText);
    btn.html(`<i class="fas fa-spinner fa-spin me-1"></i>${loadingText}`).prop('disabled', true);
});

// Form submission with loading state
$(document).on('submit', 'form[data-loading]', function() {
    const form = $(this);
    const submitBtn = form.find('[type="submit"]');
    const loadingText = form.data('loading') || 'Processing...';

    if (submitBtn.length) {
        const originalText = submitBtn.html();
        submitBtn.data('original-text', originalText);
        submitBtn.html(`<i class="fas fa-spinner fa-spin me-1"></i>${loadingText}`).prop('disabled', true);
    }
});

// Reset button states on page unload
$(window).on('beforeunload', function() {
    $('[data-original-text]').each(function() {
        const btn = $(this);
        btn.html(btn.data('original-text')).prop('disabled', false);
    });
});

// Auto-hide alerts
$(document).on('click', '.alert .btn-close', function() {
    $(this).closest('.alert').fadeOut();
});

// Initialize search delay
$(document).on('keyup', '.search-input', debounce(function() {
    const searchTerm = $(this).val();
    const targetTable = $(this).data('target');

    if (targetTable && window[targetTable + 'Table']) {
        window[targetTable + 'Table'].search(searchTerm).draw();
    }
}, 300));

// Print functionality
window.printElement = function(elementId) {
    const element = document.getElementById(elementId);
    if (!element) return;

    const printWindow = window.open('', '_blank');
    printWindow.document.write(`
        <!DOCTYPE html>
        <html>
        <head>
            <title>Print</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body { margin: 20px; }
                @media print {
                    .no-print { display: none !important; }
                }
            </style>
        </head>
        <body>
            ${element.innerHTML}
        </body>
        </html>
    `);
    printWindow.document.close();
    printWindow.print();
};

// Clipboard functionality
window.copyToClipboard = function(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showGlobalAlert('success', 'Copied to clipboard!', 2000);
        }).catch(() => {
            showGlobalAlert('danger', 'Failed to copy to clipboard.');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showGlobalAlert('success', 'Copied to clipboard!', 2000);
    }
};

// Auto-save functionality
window.setupAutoSave = function(formSelector, saveUrl, interval = 30000) {
    let autoSaveTimer;

    $(formSelector).on('input change', function() {
        clearTimeout(autoSaveTimer);
        autoSaveTimer = setTimeout(() => {
            const formData = new FormData(this);

            $.ajax({
                url: saveUrl,
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function() {
                    showGlobalAlert('info', 'Auto-saved', 1000);
                },
                error: function() {
                    console.log('Auto-save failed');
                }
            });
        }, interval);
    });
};

console.log('SGLR Laboratory Management System initialized with jQuery + Bootstrap');