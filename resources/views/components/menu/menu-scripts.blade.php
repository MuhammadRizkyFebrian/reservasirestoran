<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get filter elements
        const filterButton = document.getElementById('filterButton');
        const resetButton = document.getElementById('resetButton');
        const searchInput = document.getElementById('searchInput');
        const categoryFilter = document.getElementById('categoryFilter');
        const typeFilter = document.getElementById('typeFilter');
        const menuFilterForm = document.getElementById('menuFilterForm');
        const filterResults = document.getElementById('filterResults');
        const resultCount = document.getElementById('resultCount');
        
        // Get all menu items
        const menuItems = document.querySelectorAll('.menu-item-card');
        const totalItems = menuItems.length;
        
        // Real-time search as user types (with 300ms debounce)
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(applyFilter, 300);
        });
        
        // Apply filter when selecting a category
        categoryFilter.addEventListener('change', applyFilter);
        
        // Apply filter when selecting a type
        typeFilter.addEventListener('change', applyFilter);
        
        // Filter button click handler
        if (filterButton) {
            filterButton.addEventListener('click', applyFilter);
        }
        
        // Form submit handler
        if (menuFilterForm) {
            menuFilterForm.addEventListener('submit', function(e) {
                e.preventDefault();
                applyFilter();
            });
        }
        
        // Reset button handler
        if (resetButton) {
            resetButton.addEventListener('click', function() {
                searchInput.value = '';
                categoryFilter.value = '';
                typeFilter.value = '';
                
                // Show all menu items
                menuItems.forEach(item => {
                    item.style.display = '';
                });
                
                // Hide results counter
                filterResults.classList.add('hidden');
            });
        }
        
        // Filter function to filter menu items
        function applyFilter() {
            const searchTerm = searchInput.value.toLowerCase();
            const category = categoryFilter.value;
            const type = typeFilter.value;
            
            // Track number of visible items
            let visibleCount = 0;
            
            menuItems.forEach(item => {
                const itemTitle = item.getAttribute('data-title').toLowerCase();
                const itemDescription = item.getAttribute('data-description').toLowerCase();
                const itemCategory = item.getAttribute('data-category');
                const itemType = item.getAttribute('data-type');
                
                // Check if the item matches all filters
                const matchesSearch = searchTerm === '' || 
                    itemTitle.includes(searchTerm) || 
                    itemDescription.includes(searchTerm);
                
                const matchesCategory = category === '' || itemCategory === category;
                const matchesType = type === '' || itemType === type;
                
                // Show or hide based on filter matches
                if (matchesSearch && matchesCategory && matchesType) {
                    item.style.display = '';
                    visibleCount++;
                } else {
                    item.style.display = 'none';
                }
            });
            
            // Display the number of matches
            resultCount.textContent = visibleCount;
            filterResults.classList.remove('hidden');
            
            // If all items are visible and no filters are applied, hide the results counter
            const noFiltersApplied = searchTerm === '' && category === '' && type === '';
            if (visibleCount === totalItems && noFiltersApplied) {
                filterResults.classList.add('hidden');
            }
            
            // Message if no results
            if (visibleCount === 0) {
                resultCount.textContent = '0';
                if (!document.getElementById('no-results-message')) {
                    const noResultsMsg = document.createElement('div');
                    noResultsMsg.id = 'no-results-message';
                    noResultsMsg.className = 'text-center py-8 text-lg text-base-content/70';
                    noResultsMsg.innerHTML = 'Tidak ada menu yang sesuai dengan filter.<br>Silakan coba kriteria pencarian lain.';
                    
                    // Add the message after the filter
                    const foodSection = document.querySelector('.container.mx-auto.px-4.py-8.bg-base-100');
                    if (foodSection) {
                        foodSection.appendChild(noResultsMsg);
                    }
                }
            } else {
                // Remove no results message if it exists
                const noResultsMsg = document.getElementById('no-results-message');
                if (noResultsMsg) {
                    noResultsMsg.remove();
                }
            }
        }
        
        // Add section visibility toggling when all items in a section are hidden
        function updateSectionVisibility() {
            const sections = document.querySelectorAll('.container.mx-auto.px-4.py-8.bg-base-100');
            
            sections.forEach(section => {
                const sectionTitle = section.querySelector('h2');
                if (!sectionTitle) return;
                
                const sectionItems = section.querySelectorAll('.menu-item-card');
                if (sectionItems.length === 0) return;
                
                let allHidden = true;
                sectionItems.forEach(item => {
                    if (item.style.display !== 'none') {
                        allHidden = false;
                    }
                });
                
                // Hide section if all items are hidden
                sectionTitle.style.display = allHidden ? 'none' : '';
                
                // Hide grid if all items are hidden
                const grid = section.querySelector('.grid');
                if (grid) {
                    grid.style.display = allHidden ? 'none' : '';
                }
            });
        }
        
        // Call updateSectionVisibility after filtering
        const originalApplyFilter = applyFilter;
        applyFilter = function() {
            originalApplyFilter();
            updateSectionVisibility();
        };
    });
</script> 