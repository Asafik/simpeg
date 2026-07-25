/* ===== SIMPEG-SP INTERACTIVE CALENDAR WIDGET JS ===== */
document.addEventListener('DOMContentLoaded', function() {

    const calendarMonthYear = document.getElementById('calendarMonthYear');
    const calendarDaysGrid = document.getElementById('calendarDaysGrid');
    const prevMonthBtn = document.getElementById('prevMonth');
    const nextMonthBtn = document.getElementById('nextMonth');

    if (calendarMonthYear && calendarDaysGrid) {
        let currentDate = new Date(2026, 6, 25); // July 25, 2026

        const fullMonthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        function renderCalendar() {
            const year = currentDate.getFullYear();
            const month = currentDate.getMonth();

            calendarMonthYear.textContent = `${fullMonthNames[month]} ${year}`;
            calendarDaysGrid.innerHTML = '';

            const firstDayIndex = new Date(year, month, 1).getDay();
            const lastDate = new Date(year, month + 1, 0).getDate();
            const prevLastDate = new Date(year, month, 0).getDate();

            // Previous month padding days
            for (let x = firstDayIndex; x > 0; x--) {
                const dayDiv = document.createElement('div');
                dayDiv.className = 'py-1 text-gray-300 text-[11px]';
                dayDiv.textContent = prevLastDate - x + 1;
                calendarDaysGrid.appendChild(dayDiv);
            }

            // Current month days
            for (let i = 1; i <= lastDate; i++) {
                const dayDiv = document.createElement('div');
                const isToday = (i === 25 && month === 6 && year === 2026);
                const hasEvent = (i === 25 || i === 28);

                if (isToday) {
                    dayDiv.className = 'py-1 font-bold text-white bg-blue-800 rounded-lg shadow-sm shadow-blue-900/30 cursor-pointer flex flex-col items-center justify-center relative';
                } else if (hasEvent) {
                    dayDiv.className = 'py-1 font-semibold text-blue-800 bg-blue-900/10 rounded-lg cursor-pointer flex flex-col items-center justify-center hover:bg-blue-900/20 transition';
                } else {
                    dayDiv.className = 'py-1 hover:bg-gray-100 rounded-lg cursor-pointer transition';
                }

                dayDiv.textContent = i;
                calendarDaysGrid.appendChild(dayDiv);
            }
        }

        renderCalendar();

        if (prevMonthBtn && nextMonthBtn) {
            prevMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            nextMonthBtn.addEventListener('click', () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });
        }
    }

});
