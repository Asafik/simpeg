/* ===== SIMPEG-SP CUSTOM DROPDOWN COMPONENT JS ===== */
document.addEventListener('DOMContentLoaded', function() {

    // Auto-convert standard native HTML <select> elements into Custom Select Dropdowns
    function convertNativeSelects() {
        const nativeSelects = document.querySelectorAll('select:not(.no-custom-select):not(.select2)');

        nativeSelects.forEach(select => {
            if (select.closest('.custom-select-wrapper')) return; // Already inside custom wrapper

            const wrapper = document.createElement('div');
            wrapper.className = 'custom-select-wrapper relative flex-1 min-w-[140px]';

            const selectedOption = select.options[select.selectedIndex] || select.options[0];
            const placeholder = selectedOption ? selectedOption.text : 'Pilih...';
            const value = selectedOption ? selectedOption.value : '';

            // Trigger Button
            const trigger = document.createElement('button');
            trigger.type = 'button';
            trigger.className = 'custom-select-trigger w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-xs text-left flex items-center justify-between transition focus:outline-none focus:ring-2 focus:ring-blue-800/20';
            trigger.innerHTML = `
                <span class="custom-select-label font-medium text-gray-700 truncate mr-2">${placeholder}</span>
                <i class="fas fa-angle-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            `;

            // Menu Container
            const menu = document.createElement('div');
            menu.className = 'custom-select-options hidden absolute left-0 right-0 mt-1.5 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden text-xs py-1.5 min-w-[180px]';

            const listContainer = document.createElement('div');
            listContainer.className = 'max-h-48 overflow-y-auto';

            Array.from(select.options).forEach(opt => {
                const optDiv = document.createElement('div');
                optDiv.className = `custom-option px-3 py-2 hover:bg-blue-50/70 hover:text-blue-800 cursor-pointer font-medium transition ${opt.selected ? 'selected' : ''}`;
                optDiv.setAttribute('data-value', opt.value);
                optDiv.textContent = opt.text;
                listContainer.appendChild(optDiv);
            });

            menu.appendChild(listContainer);

            // Hidden real input for form submission
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = select.name || '';
            hiddenInput.id = select.id || '';
            hiddenInput.className = 'custom-select-input';
            hiddenInput.value = value;

            // Replace native select in DOM
            select.parentNode.insertBefore(wrapper, select);
            wrapper.appendChild(trigger);
            wrapper.appendChild(menu);
            wrapper.appendChild(hiddenInput);
            select.style.display = 'none';
        });
    }

    function initCustomSelects() {
        const wrappers = document.querySelectorAll('.custom-select-wrapper');

        wrappers.forEach(wrapper => {
            const trigger = wrapper.querySelector('.custom-select-trigger');
            const menu = wrapper.querySelector('.custom-select-options');
            const label = wrapper.querySelector('.custom-select-label');
            const hiddenInput = wrapper.querySelector('.custom-select-input');
            const options = wrapper.querySelectorAll('.custom-option');
            const searchInput = wrapper.querySelector('.custom-select-search');
            const arrow = trigger ? trigger.querySelector('i') : null;

            if (!trigger || !menu) return;

            // Prevent duplicate listeners
            if (wrapper.hasAttribute('data-initialized')) return;
            wrapper.setAttribute('data-initialized', 'true');

            // Toggle Menu
            trigger.addEventListener('click', function(e) {
                e.stopPropagation();
                
                // Close other open custom select menus AND open datepicker popups
                document.querySelectorAll('.custom-select-options').forEach(otherMenu => {
                    if (otherMenu !== menu) otherMenu.classList.add('hidden');
                });
                document.querySelectorAll('.custom-datepicker-popup').forEach(dp => {
                    dp.classList.add('hidden');
                });

                menu.classList.toggle('hidden');
                if (arrow) {
                    arrow.classList.toggle('rotate-180');
                }
                if (!menu.classList.contains('hidden') && searchInput) {
                    searchInput.focus();
                }
            });

            // Option Click Selection
            options.forEach(opt => {
                opt.addEventListener('click', function() {
                    const value = this.getAttribute('data-value');
                    const text = this.textContent.trim();

                    if (label) label.textContent = text;
                    if (hiddenInput) {
                        hiddenInput.value = value;
                        hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));
                    }

                    options.forEach(o => o.classList.remove('selected'));
                    this.classList.add('selected');

                    menu.classList.add('hidden');
                    if (arrow) arrow.classList.remove('rotate-180');
                });
            });

            // Filter Options via Search Box
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.toLowerCase();
                    options.forEach(opt => {
                        const text = opt.textContent.toLowerCase();
                        if (text.includes(query)) {
                            opt.style.display = 'block';
                        } else {
                            opt.style.display = 'none';
                        }
                    });
                });
            }
        });

        // Click outside closes custom selects
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.custom-select-wrapper')) {
                document.querySelectorAll('.custom-select-options').forEach(menu => {
                    menu.classList.add('hidden');
                });
                document.querySelectorAll('.custom-select-trigger i').forEach(arrow => {
                    arrow.classList.remove('rotate-180');
                });
            }
        });
    }

    convertNativeSelects();
    initCustomSelects();

});
