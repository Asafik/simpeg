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
            displayInput.className = 'custom-datepicker-input w-full bg-gray-50 border border-gray-200 text-xs text-gray-800 rounded-lg pl-3 pr-9 py-2.5 cursor-pointer focus:outline-none focus:ring-2 focus:ring-blue-800/20 font-medium';

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
        let viewMode = 'days'; // 'days', 'months', 'years'

        function renderCalendar() {
            if (viewMode === 'months') {
                renderMonthsView();
                return;
            }

            if (viewMode === 'years') {
                renderYearsView();
                return;
            }

            // Standard Days View
            popup.innerHTML = `
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100 gap-1">
                    <button type="button" class="datepicker-prev w-7 h-7 rounded-lg hover:bg-gray-100 flex items-center justify-center text-gray-600 transition cursor-pointer">
                        <i class="fas fa-chevron-left text-[10px]"></i>
                    </button>
                    
                    <div class="flex items-center gap-1.5 font-extrabold text-xs">
                        <button type="button" class="btn-toggle-month hover:bg-blue-50 text-blue-900 px-2 py-1 rounded-lg transition flex items-center gap-1 cursor-pointer">
                            <span>${monthNames[viewMonth]}</span>
                            <i class="fas fa-chevron-down text-[9px] text-blue-600"></i>
                        </button>
                        
                        <button type="button" class="btn-toggle-year hover:bg-blue-50 text-blue-900 px-2 py-1 rounded-lg transition flex items-center gap-1 cursor-pointer">
                            <span>${viewYear}</span>
                            <i class="fas fa-chevron-down text-[9px] text-blue-600"></i>
                        </button>
                    </div>

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
            const monthToggleBtn = popup.querySelector('.btn-toggle-month');
            const yearToggleBtn = popup.querySelector('.btn-toggle-year');

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

            // Toggle Month Grid View
            monthToggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                viewMode = 'months';
                renderCalendar();
            });

            // Toggle Year Grid View
            yearToggleBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                viewMode = 'years';
                renderCalendar();
            });

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

        // Custom 12-Month Grid Selection View
        function renderMonthsView() {
            popup.innerHTML = `
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                    <span class="font-extrabold text-gray-800 text-xs">Pilih Bulan (${viewYear})</span>
                    <button type="button" class="btn-close-mode text-gray-400 hover:text-gray-800 p-1 cursor-pointer">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="grid grid-cols-3 gap-2 py-1">
                    ${monthNames.map((m, idx) => `
                        <button type="button" data-month="${idx}" class="month-card-item py-2.5 px-2 rounded-xl text-center font-bold text-xs transition cursor-pointer ${idx === viewMonth ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'bg-gray-50 text-gray-700 hover:bg-blue-50 hover:text-blue-800'}">
                            ${m}
                        </button>
                    `).join('')}
                </div>
            `;

            popup.querySelector('.btn-close-mode').addEventListener('click', function(e) {
                e.stopPropagation();
                viewMode = 'days';
                renderCalendar();
            });

            popup.querySelectorAll('.month-card-item').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    viewMonth = parseInt(this.getAttribute('data-month'));
                    viewMode = 'days';
                    renderCalendar();
                });
            });
        }

        // Custom Year Grid Selection View (1950 - 2026)
        function renderYearsView() {
            const currentYear = new Date().getFullYear();
            const years = [];
            for (let y = currentYear; y >= 1950; y--) {
                years.push(y);
            }

            popup.innerHTML = `
                <div class="flex items-center justify-between pb-3 mb-3 border-b border-gray-100">
                    <span class="font-extrabold text-gray-800 text-xs">Pilih Tahun Kelahiran</span>
                    <button type="button" class="btn-close-mode text-gray-400 hover:text-gray-800 p-1 cursor-pointer">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <div class="grid grid-cols-4 gap-1.5 max-h-52 overflow-y-auto pr-1 py-1 custom-scrollbar">
                    ${years.map(y => `
                        <button type="button" data-year="${y}" class="year-card-item py-2 px-1 rounded-lg text-center font-bold text-xs transition cursor-pointer ${y === viewYear ? 'bg-blue-800 text-white shadow-md shadow-blue-900/30' : 'bg-gray-50 text-gray-700 hover:bg-blue-50 hover:text-blue-800'}">
                            ${y}
                        </button>
                    `).join('')}
                </div>
            `;

            popup.querySelector('.btn-close-mode').addEventListener('click', function(e) {
                e.stopPropagation();
                viewMode = 'days';
                renderCalendar();
            });

            popup.querySelectorAll('.year-card-item').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    viewYear = parseInt(this.getAttribute('data-year'));
                    viewMode = 'days';
                    renderCalendar();
                });
            });

            // Auto-scroll to selected year inside popup
            setTimeout(() => {
                const activeYearBtn = popup.querySelector(`.year-card-item[data-year="${viewYear}"]`);
                if (activeYearBtn) {
                    activeYearBtn.scrollIntoView({ block: 'center', behavior: 'smooth' });
                }
            }, 50);
        }

        // Toggle Popup
        displayInput.addEventListener('click', function(e) {
            e.stopPropagation();
            
            // Close other open datepickers
            document.querySelectorAll('.custom-datepicker-popup').forEach(p => {
                if (p !== popup) p.classList.add('hidden');
            });

            viewMode = 'days';
            renderCalendar();
            popup.classList.toggle('hidden');
        });

        // Close on click outside
        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) {
                popup.classList.add('hidden');
            }
        });
    }

    // Initialize all date inputs
    convertNativeDateInputs();

    // Export to global scope
    window.convertNativeDateInputs = convertNativeDateInputs;
});
