// Simple Actions JavaScript for Patients Table - No animations, just functionality
document.addEventListener('DOMContentLoaded', function() {

    // Initialize Bootstrap tooltips
    initializeTooltips();

    // Initialize dropdowns
    initializeDropdowns();

    // Initialize modals
    initializeModals();

    console.log('Patient actions initialized');
});

/**
 * Initialize Bootstrap tooltips
 */
function initializeTooltips() {
    const tooltipElements = document.querySelectorAll('[title]');
    tooltipElements.forEach(element => {
        new bootstrap.Tooltip(element, {
            trigger: 'hover',
            delay: { show: 300, hide: 100 },
            placement: 'top'
        });
    });
}

/**
 * Initialize dropdown functionality
 */
function initializeDropdowns() {
    // Ensure dropdowns work properly
    const dropdownElements = document.querySelectorAll('.dropdown-toggle');
    dropdownElements.forEach(element => {
        new bootstrap.Dropdown(element);
    });

    // Fix dropdown positioning
    document.addEventListener('shown.bs.dropdown', function(e) {
        const dropdown = e.target;
        const menu = dropdown.nextElementSibling;

        if (menu) {
            // Ensure dropdown stays within viewport
            const rect = menu.getBoundingClientRect();
            const viewportWidth = window.innerWidth;

            if (rect.right > viewportWidth) {
                menu.style.left = 'auto';
                menu.style.right = '0';
            }
        }
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.dropdown')) {
            const openDropdowns = document.querySelectorAll('.dropdown-menu.show');
            openDropdowns.forEach(menu => {
                const dropdown = bootstrap.Dropdown.getInstance(menu.previousElementSibling);
                if (dropdown) {
                    dropdown.hide();
                }
            });
        }
    });
}

/**
 * Initialize modal functionality
 */
function initializeModals() {
    // Enhanced delete confirmation
    const deleteButtons = document.querySelectorAll('[data-bs-target*="delete_patient"]');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const patientName = this.closest('tr')?.querySelector('a[href*="/patients/"]')?.textContent?.trim();
            const modalId = this.getAttribute('data-bs-target');
            const modal = document.querySelector(modalId);

            if (modal && patientName) {
                // Update modal content with patient name
                const modalBody = modal.querySelector('.modal-body p');
                if (modalBody) {
                    modalBody.innerHTML = `Are you sure you want to delete <strong>${patientName}</strong>?`;
                }
            }
        });
    });

    // Handle form submissions in modals
    const deleteModals = document.querySelectorAll('[id*="delete_patient"]');
    deleteModals.forEach(modal => {
        const form = modal.querySelector('form');
        if (form) {
            form.addEventListener('submit', function() {
                const submitButton = this.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = 'Deleting...';
                }
            });
        }
    });
}

/**
 * Simple search functionality
 */
function initializeSearch() {
    const searchInput = document.getElementById('patient-search');
    if (!searchInput) return;

    let searchTimeout;

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const searchTerm = this.value.toLowerCase().trim();

        searchTimeout = setTimeout(() => {
            filterPatients(searchTerm);
        }, 300);
    });

    function filterPatients(searchTerm) {
        const rows = document.querySelectorAll('.table tbody tr');

        rows.forEach(row => {
            if (searchTerm === '') {
                row.style.display = '';
                return;
            }

            const patientName = row.querySelector('a[href*="/patients/"]')?.textContent?.toLowerCase() || '';
            const patientId = row.querySelector('.badge')?.textContent?.toLowerCase() || '';
            const phone = row.cells[5]?.textContent?.toLowerCase() || '';

            const matches = patientName.includes(searchTerm) ||
                patientId.includes(searchTerm) ||
                phone.includes(searchTerm);

            row.style.display = matches ? '' : 'none';
        });

        // Update visible count
        const visibleRows = document.querySelectorAll('.table tbody tr[style=""], .table tbody tr:not([style])').length;
        updateResultsCount(visibleRows);
    }

    function updateResultsCount(count) {
        let countElement = document.getElementById('results-count');
        if (!countElement) {
            countElement = document.createElement('div');
            countElement.id = 'results-count';
            countElement.className = 'text-muted small mt-2';
            searchInput.parentNode.appendChild(countElement);
        }

        if (searchInput.value.trim()) {
            countElement.textContent = `${count} patients found`;
            countElement.style.display = 'block';
        } else {
            countElement.style.display = 'none';
        }
    }
}

/**
 * Handle batch selection
 */
function initializeBatchSelection() {
    const selectAllCheckbox = document.getElementById('select-all-patients');
    const patientCheckboxes = document.querySelectorAll('.patient-checkbox');

    if (!selectAllCheckbox || patientCheckboxes.length === 0) return;

    // Handle select all
    selectAllCheckbox.addEventListener('change', function() {
        patientCheckboxes.forEach(checkbox => {
            checkbox.checked = this.checked;
        });
        updateBatchActions();
    });

    // Handle individual checkboxes
    patientCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateSelectAllState();
            updateBatchActions();
        });
    });

    function updateSelectAllState() {
        const checkedCount = document.querySelectorAll('.patient-checkbox:checked').length;
        const totalCount = patientCheckboxes.length;

        if (checkedCount === 0) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = false;
        } else if (checkedCount === totalCount) {
            selectAllCheckbox.indeterminate = false;
            selectAllCheckbox.checked = true;
        } else {
            selectAllCheckbox.indeterminate = true;
        }
    }

    function updateBatchActions() {
        const checkedCount = document.querySelectorAll('.patient-checkbox:checked').length;
        const batchBar = document.getElementById('batch-actions-bar');
        const countSpan = document.getElementById('selected-count');

        if (batchBar) {
            batchBar.style.display = checkedCount > 0 ? 'block' : 'none';
        }

        if (countSpan) {
            countSpan.textContent = checkedCount;
        }
    }
}

/**
 * Export selected patients
 */
function exportSelected() {
    const checkedBoxes = document.querySelectorAll('.patient-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);

    if (ids.length === 0) {
        alert('Please select at least one patient');
        return;
    }

    // Create export URL
    const exportUrl = new URL('/patients/export', window.location.origin);
    exportUrl.searchParams.set('ids', ids.join(','));

    // Open in new tab
    window.open(exportUrl.toString(), '_blank');
}

/**
 * Delete selected patients
 */
function deleteSelected() {
    const checkedBoxes = document.querySelectorAll('.patient-checkbox:checked');
    const ids = Array.from(checkedBoxes).map(cb => cb.value);

    if (ids.length === 0) {
        alert('Please select at least one patient');
        return;
    }

    if (confirm(`Are you sure you want to delete ${ids.length} selected patients? This action cannot be undone.`)) {
        // Create form and submit
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/patients/batch-delete';

        // Add CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        if (csrfToken) {
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = csrfToken;
            form.appendChild(csrfInput);
        }

        // Add method field
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        // Add IDs
        const idsInput = document.createElement('input');
        idsInput.type = 'hidden';
        idsInput.name = 'ids';
        idsInput.value = ids.join(',');
        form.appendChild(idsInput);

        document.body.appendChild(form);
        form.submit();
    }
}

// Initialize additional features when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(() => {
        initializeSearch();
        initializeBatchSelection();
    }, 100);
});

// Make functions available globally
window.exportSelected = exportSelected;
window.deleteSelected = deleteSelected;