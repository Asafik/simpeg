/* ===== SIMPEG-SP CUSTOM DATEPICKER COMPONENT JS ===== */
document.addEventListener('DOMContentLoaded', function() {

    const monthNames = [
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    ];

    function convertNativeDateInputs() {
        const dateInputs = document.querySelectorAll('input[type="date"]:not(.no-custom-datepicker)');

        dateInputs.forEach(input => {
            if (input.closest('.custom-datepicker-wrapper')) return;

            const wrapper = document.createElement('div');
            wrapper.className = 'custom-datepicker-wrapper relative w-full';

            const name = input.name || '';
            const id = input.id || '';
            const required = input.hasAttribute('required') ? 'required' : '';
            const placeholder = input.placeholder || 'dd/mm/yyyy';

            // Display Readonly Input
            const displayInput = document.createElement('input');
            displayInput.type = 'text';
            displayInput.readOnly = true;
            displayInput.placeholder = placeholder;
            displayInput.className = 'custom-datepicker-input w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg pl-3 pr-9 py-2.5 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-800/20';

            const icon = document.createElement('i');
            icon.className = 'far fa-calendar-alt absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs pointer-events-none';

            const inputGroup = document.createElement('div');
            inputGroup.className = 'relative w-full';
            inputGroup.appendChild(displayInput);
            inputGroup.appendChild(icon);

            // Popup Calendar Container
            const popup = document.createElement('div');
            popup.className = 'custom-datepicker-popup hidden absolute left-0 mt-1.5 w-72 bg-white border border-gray-200 rounded-2xl shadow-2xl z-50 p-4 text-xs select-none';

            // Hidden Real Value Input (YYYY-MM-DD)
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = name;
            hiddenInput.id = id;
            if (required) hiddenInput.setAttribute('required', 'required');
            hiddenInput.className = 'custom-datepicker-value';
            hiddenInput.value = input.value || '';

            // Set initial display text if value exists
            if (input.value) {
                const parts = input.value.split('-');
                if (parts.length === 3) {
                    displayInput.value = `${parts[2]}/${parts[1]}/${parts[0]}`;
                }
            }

            // Replace in DOM
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(inputGroup);
            wrapper.appendChild(popup);
            wrapper.appendChild(hiddenInput);
            input.remove();

            initSingleDatepicker(wrapper);
        });
    }

    function initSingleDatepicker(wrapper) {
        const displayInput = wrapper.querySelector('.custom-datepicker-input');
        const popup = wrapper.querySelector('.custom-datepicker-popup');
        const hiddenInput = wrapper.querySelector('.custom-datepicker-value');

        if (!displayInput || !popup) return;

        let currentDate = new Date();
        let selectedDate = null;

        if (hiddenInput.value) {
            const parts = hiddenInput.value.split('-');
            if (parts.length === 3) {
                selectedDate = new Date(parts[0], parts[1] - 1, parts[2]);
                currentDate = new Date(selectedDate);
            }
        }

        let viewYear = currentDate.getFullYear();
        let viewMonth = currentDate.getMonth();

        function renderCalendar() {
            popup.innerHTML = `
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                    <button type="button" class="datepicker-prev w-7 h-7 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-600 transition cursor-pointer">
                        <i class="fas fa-chevron-left text-[10px]"></i>
                    </button>
                    <span class="datepicker-title font-extrabold text-gray-800 text-xs">${monthNames[viewMonth]} ${viewYear}</span>
                    <button type="button" class="datepicker-next w-7 h-7 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-600 transition cursor-pointer">
                        <i class="fas fa-chevron-right text-[10px]"></i>
                    </button>
                </div>
                
                <div class="grid grid-cols-7 gap-1 text-center font-bold text-[10px] text-gray-400 uppercase mb-2">
                    <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
                </div>
                
                <div class="datepicker-days grid grid-cols-7 gap-1 text-center font-medium"></div>

                <div class="flex items-center justify-between pt-3 mt-3 border-t border-gray-100 text-[11px]">
                    <button type="button" class="datepicker-clear text-red-500 font-bold hover:underline cursor-pointer">Hapus</button>
                    <button type="button" class="datepicker-today text-blue-800 font-bold hover:underline cursor-pointer">Hari ini</button>
                </div>
            `;

            const daysContainer = popup.querySelector('.datepicker-days');
            const prevBtn = popup.querySelector('.datepicker-prev');
            const nextBtn = popup.querySelector('.datepicker-next');
            const todayBtn = popup.querySelector('.datepicker-today');
            const clearBtn = popup.querySelector('.datepicker-clear');

            const firstDayOfMonth = new Date(viewYear, viewMonth, 1).getDay();
            const daysInMonth = new Date(viewYear, viewMonth + 1, 0).getDate();
            const daysInPrevMonth = new Date(viewYear, viewMonth, 0).getDate();

            const today = new Date();

            // Previous month fill days
            for (let i = firstDayOfMonth - 1; i >= 0; i--) {
                const dayNum = daysInPrevMonth - i;
                const cell = document.createElement('div');
                cell.className = 'datepicker-day-cell other-month';
                cell.textContent = dayNum;
                daysContainer.appendChild(cell);
            }

            // Current month days
            for (let d = 1; d <= daysInMonth; d++) {
                const cell = document.createElement('div');
                let classes = 'datepicker-day-cell';

                const isToday = today.getFullYear() === viewYear && today.getMonth() === viewMonth && today.getDate() === d;
                const isSelected = selectedDate && selectedDate.getFullYear() === viewYear && selectedDate.getMonth() === viewMonth && selectedDate.getDate() === d;

                if (isToday) classes += ' today';
                if (isSelected) classes += ' selected';

                cell.className = classes;
                cell.textContent = d;

                cell.addEventListener('click', function() {
                    selectedDate = new Date(viewYear, viewMonth, d);
                    const formattedDisplay = `${String(d).padStart(2, '0')}/${String(viewMonth + 1).padStart(2, '0')}/${viewYear}`;
                    const formattedValue = `${viewYear}-${String(viewMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;

                    displayInput.value = formattedDisplay;
                    hiddenInput.value = formattedValue;
                    hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));

                    popup.classList.add('hidden');
                });

                daysContainer.appendChild(cell);
            }

            // Next month fill days to complete 42 cells (6 rows)
            const totalCells = firstDayOfMonth + daysInMonth;
            const nextDays = (42 - totalCells) % 7;
            for (let n = 1; n <= nextDays; n++) {
                const cell = document.createElement('div');
                cell.className = 'datepicker-day-cell other-month';
                cell.textContent = n;
                daysContainer.appendChild(cell);
            }

            // Prev & Next Month Listeners
            prevBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                viewMonth--;
                if (viewMonth < 0) {
                    viewMonth = 11;
                    viewYear--;
                }
                renderCalendar();
            });

            nextBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                viewMonth++;
                if (viewMonth > 11) {
                    viewMonth = 0;
                    viewYear++;
                }
                renderCalendar();
            });

            // Today Button Listener
            todayBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                const now = new Date();
                selectedDate = now;
                viewYear = now.getFullYear();
                viewMonth = now.getMonth();

                const d = now.getDate();
                const formattedDisplay = `${String(d).padStart(2, '0')}/${String(viewMonth + 1).padStart(2, '0')}/${viewYear}`;
                const formattedValue = `${viewYear}-${String(viewMonth + 1).padStart(2, '0')}-${String(d).padStart(2, '0')}`;

                displayInput.value = formattedDisplay;
                hiddenInput.value = formattedValue;
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));

                popup.classList.add('hidden');
            });

            // Clear Button Listener
            clearBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                selectedDate = null;
                displayInput.value = '';
                hiddenInput.value = '';
                hiddenInput.dispatchEvent(new Event('change', { bubbles: true }));

                popup.classList.add('hidden');
            });
        }

        // Toggle Popup
        displayInput.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Close other open datepickers AND open custom select menus
            document.querySelectorAll('.custom-datepicker-popup').forEach(p => {
                if (p !== popup) p.classList.add('hidden');
            });
            document.querySelectorAll('.custom-select-options').forEach(selectMenu => {
                selectMenu.classList.add('hidden');
            });
            document.querySelectorAll('.custom-select-trigger i').forEach(arrow => {
                arrow.classList.remove('rotate-180');
            });

            if (popup.classList.contains('hidden')) {
                renderCalendar();
                popup.classList.remove('hidden');
            } else {
                popup.classList.add('hidden');
            }
        });
    }

    convertNativeDateInputs();

    // Click outside closes datepicker popups
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.custom-datepicker-wrapper')) {
            document.querySelectorAll('.custom-datepicker-popup').forEach(popup => {
                popup.classList.add('hidden');
            });
        }
    });

});
