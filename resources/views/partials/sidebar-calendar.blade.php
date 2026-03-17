<!-- Right Sidebar (Calendar) -->
        <div class="calendar-sidebar-container">
            <style>
                .calendar-sidebar-container {
                    width: 100%;
                }
                @media (min-width: 1201px) {
                    .calendar-sidebar-container {
                        position: relative; /* Stretches naturally with parent grid */
                    }
                }

                .calendar-sidebar {
                    padding: 1.75rem;
                    width: 100%;
                    max-width: none;
                    min-height: 600px;
                    display: flex;
                    flex-direction: column;
                    align-items: stretch;
                    background: var(--card-bg);
                    border: 1px solid var(--card-border);
                    border-radius: 24px;
                }

                .calendar-sidebar:hover {
                    transform: none !important;
                    box-shadow: none !important;
                }

                .calendar-sidebar::before {
                    display: none !important;
                }

                .calendar-header {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 2rem;
                    flex-shrink: 0;
                }

                .calendar-header h3 {
                    color: var(--primary-text-heading);
                    font-size: 1.5rem;
                    font-weight: 800;
                    margin: 0;
                }

                .calendar-nav {
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                }

                .calendar-month-label {
                    font-size: 1rem;
                    font-weight: 800;
                    color: var(--text-main);
                    min-width: 130px;
                    text-align: center;
                    text-transform: uppercase;
                }

                .calendar-nav-btn {
                    background: var(--bg-alt);
                    border: 1px solid var(--card-border);
                    color: var(--text-main);
                    width: 36px;
                    height: 36px;
                    border-radius: 10px;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 1.1rem;
                    transition: all 0.2s ease;
                }

                .calendar-nav-btn:hover {
                    background: var(--primary-color);
                    color: #fff;
                }

                .calendar-weekdays {
                    display: grid;
                    grid-template-columns: repeat(7, 1fr);
                    gap: 8px;
                    margin-bottom: 8px;
                }

                .calendar-weekday {
                    text-align: center;
                    font-size: 0.75rem;
                    font-weight: 800;
                    color: var(--text-muted);
                    text-transform: uppercase;
                    letter-spacing: 0.05em;
                }

                .calendar-grid {
                    display: grid;
                    grid-template-columns: repeat(7, 1fr);
                    gap: 8px;
                    flex: 1;
                    min-height: 350px;
                }

                .calendar-day {
                    background: var(--bg-alt);
                    border: 1px solid var(--card-border);
                    border-radius: 12px;
                    padding: 0.8rem;
                    cursor: pointer;
                    display: flex;
                    flex-direction: column;
                    min-height: 95px;
                    transition: all 0.2s ease;
                }

                .calendar-day:hover {
                    border-color: var(--primary-color);
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0,0,0,0.05);
                }

                .calendar-day.today {
                    border-color: var(--primary-color);
                    background: rgba(30, 58, 138, 0.05);
                }

                .calendar-day.other-month {
                    opacity: 0.3;
                }

                .calendar-day-number {
                    font-size: 0.9rem;
                    font-weight: 800;
                    margin-bottom: 4px;
                }

                .calendar-event-dots {
                    display: flex;
                    flex-wrap: wrap;
                    gap: 3px;
                    margin-top: auto;
                    min-height: 8px;
                }

                .calendar-event-dot {
                    width: 7px;
                    height: 7px;
                    border-radius: 50%;
                    flex-shrink: 0;
                }

                .calendar-add-btn {
                    margin-top: 1.5rem;
                    padding: 0.8rem;
                    border: 2px dashed var(--card-border);
                    border-radius: 14px;
                    background: transparent;
                    color: var(--text-muted);
                    font-weight: 700;
                    cursor: pointer;
                    font-size: 0.9rem;
                    transition: all 0.2s ease;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 0.4rem;
                }

                .calendar-add-btn:hover {
                    border-color: var(--primary-color);
                    color: var(--primary-color);
                    background: rgba(30, 58, 138, 0.04);
                }

                /* Modal Styles */
                .cal-modal-overlay {
                    position: fixed;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: rgba(0, 0, 0, 0.5);
                    backdrop-filter: blur(8px);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    z-index: 1000;
                    opacity: 0;
                    visibility: hidden;
                    transition: all 0.3s ease;
                }
                .cal-modal-overlay.active { opacity: 1; visibility: visible; }
                .cal-modal {
                    background: var(--bg-main);
                    border: 1px solid var(--card-border);
                    border-radius: 20px;
                    padding: 2rem;
                    width: 90%;
                    max-width: 420px;
                    box-shadow: 0 25px 60px rgba(0, 0, 0, 0.15);
                    transform: translateY(20px) scale(0.97);
                    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                }
                .cal-modal-overlay.active .cal-modal { transform: translateY(0) scale(1); }
                .cal-modal h3 { color: var(--primary-text-heading); margin-bottom: 1.25rem; font-weight: 800; }
                .cal-modal-field { margin-bottom: 1.25rem; }
                .cal-modal-field label { display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); margin-bottom: 0.5rem; }
                .cal-modal-field input, .cal-modal-field textarea {
                    width: 100%; padding: 0.8rem 1rem; border: 1px solid var(--card-border); border-radius: 12px;
                    background: var(--input-bg); color: var(--text-main); font-family: inherit; font-size: 0.95rem; outline: none;
                }
                .cal-color-picker { display: flex; gap: 0.6rem; flex-wrap: wrap; }
                .cal-color-option { width: 32px; height: 32px; border-radius: 50%; border: 3px solid transparent; cursor: pointer; transition: transform 0.2s; }
                .cal-color-option:hover { transform: scale(1.15); }
                .cal-color-option.selected { border-color: var(--text-main); }
                .cal-modal-actions { display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; }
                
                .cal-btn { padding: 0.75rem 1.75rem; border-radius: 12px; font-weight: 800; cursor: pointer; border: none; transition: all 0.2s; }
                .cal-btn-primary { background: var(--primary-color); color: #fff; box-shadow: 0 4px 12px rgba(30,58,138,0.2); }
                .cal-btn-secondary { background: var(--bg-alt); color: var(--text-muted); border: 1px solid var(--card-border); }

                /* Day Popup */
                .cal-day-popup {
                    position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5);
                    backdrop-filter: blur(8px); display: flex; justify-content: center; align-items: center;
                    z-index: 1000; opacity: 0; visibility: hidden; transition: all 0.3s ease;
                }
                .cal-day-popup.active { opacity: 1; visibility: visible; }
                .cal-day-popup-card {
                    background: var(--bg-main); border: 1px solid var(--card-border); border-radius: 24px;
                    padding: 2rem; width: 95%; max-width: 450px; box-shadow: 0 25px 60px rgba(0, 0, 0, 0.2);
                    max-height: 85vh; display: flex; flex-direction: column;
                }
                .cal-day-popup-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; }
                .cal-day-popup-header h4 { font-size: 1.25rem; font-weight: 800; color: var(--primary-text-heading); margin: 0; }
                .cal-day-popup-close { background: var(--bg-alt); border: 1px solid var(--card-border); width: 36px; height: 36px; border-radius: 10px; cursor: pointer; font-size: 1.2rem; display: flex; align-items: center; justify-content: center; transition: all 0.2s; }
                .cal-day-popup-close:hover { background: #ef4444; color: #fff; border-color: #ef4444; }
                
                #cal-day-popup-events { flex: 1; overflow-y: auto; margin-bottom: 1.5rem; padding-right: 0.5rem; }
                .cal-event-item { background: var(--bg-alt); border: 1px solid var(--card-border); border-radius: 16px; padding: 1.25rem; margin-bottom: 1rem; }
                .cal-event-item-header { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.5rem; }
                .cal-event-item-dot { width: 10px; height: 10px; border-radius: 50%; }
                .cal-event-item-title { font-weight: 800; color: var(--text-main); font-size: 1rem; }
                .cal-event-item-time { font-size: 0.8rem; color: var(--text-muted); margin-left: auto; font-weight: 700; }
                .cal-event-item-desc { font-size: 0.85rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1rem; padding-left: 1.4rem; }
                .cal-event-item-actions { display: flex; gap: 0.75rem; padding-left: 1.4rem; }
                .cal-event-action-btn { padding: 0.4rem 0.8rem; border-radius: 8px; font-weight: 700; font-size: 0.75rem; border: none; cursor: pointer; transition: all 0.2s; }
                .cal-event-edit-btn { background: rgba(59, 130, 246, 0.1); color: var(--primary-color); }
                .cal-event-edit-btn:hover { background: var(--primary-color); color: #fff; }
                .cal-event-delete-btn { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
                .cal-event-delete-btn:hover { background: #ef4444; color: #fff; }

                .cal-day-popup-add-btn {
                    width: 100%;
                    padding: 1rem;
                    margin-top: 0.5rem;
                    border: 2px dashed var(--card-border);
                    border-radius: 16px;
                    background: transparent;
                    color: var(--text-muted);
                    font-size: 0.9rem;
                    font-weight: 800;
                    cursor: pointer;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    gap: 0.5rem;
                    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                }

                .cal-day-popup-add-btn:hover {
                    background: rgba(30, 58, 138, 0.04);
                    border-color: var(--primary-color);
                    color: var(--primary-color);
                    transform: translateY(-2px);
                }

                .cal-no-events {
                    text-align: center;
                    padding: 3rem 1rem;
                    color: var(--text-muted);
                    font-weight: 600;
                    font-size: 0.95rem;
                    opacity: 0.7;
                }

                /* Custom Datepicker Dropdown */
                .datepicker-dropdown {
                    position: absolute;
                    top: 100%;
                    left: 0;
                    width: 100%;
                    margin-top: 10px;
                    background: rgba(15, 23, 42, 0.95);
                    backdrop-filter: blur(12px);
                    border: 1px solid var(--card-border);
                    border-radius: 16px;
                    padding: 1.25rem;
                    z-index: 1050;
                    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
                    opacity: 0;
                    visibility: hidden;
                    transform: translateY(10px);
                    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                }
                .datepicker-dropdown.active, .timepicker-dropdown.active {
                    opacity: 1;
                    visibility: visible;
                    transform: translateY(0);
                }
                .dp-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; }
                .dp-month { font-weight: 800; font-size: 0.85rem; color: #fff; text-transform: uppercase; }
                .dp-nav { display: flex; gap: 0.5rem; }
                .dp-nav-btn { background: rgba(255,255,255,0.05); border: none; color: #fff; width: 28px; height: 28px; border-radius: 8px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; }
                .dp-nav-btn:hover { background: var(--primary-color); }
                .dp-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 4px; }
                .dp-weekday { text-align: center; font-size: 0.65rem; font-weight: 800; color: var(--text-muted); padding: 5px 0; }
                .dp-day { 
                    text-align: center; padding: 8px 0; font-size: 0.8rem; font-weight: 700; border-radius: 8px; cursor: pointer; color: var(--text-muted); transition: all 0.2s;
                }
                .dp-day:hover { background: rgba(255,255,255,0.05); color: #fff; }
                .dp-day.current { color: #fff; }
                .dp-day.selected { background: var(--primary-color); color: #fff; }
                .dp-day.today { color: var(--primary-color); position: relative; }
                .dp-day.today::after { content: ''; position: absolute; bottom: 4px; left: 50%; transform: translateX(-50%); width: 4px; height: 4px; border-radius: 50%; background: var(--primary-color); }

                /* Custom Timepicker */
                .timepicker-dropdown {
                    position: absolute;
                    top: 100%;
                    left: 0;
                    width: 100%;
                    margin-top: 10px;
                    background: rgba(15, 23, 42, 0.95);
                    backdrop-filter: blur(12px);
                    border: 1px solid var(--card-border);
                    border-radius: 16px;
                    padding: 1rem;
                    z-index: 1050;
                    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
                    opacity: 0;
                    visibility: hidden;
                    transform: translateY(10px);
                    transition: all 0.3s cubic-bezier(0.16, 1, 0.3, 1);
                    display: flex;
                    gap: 0.5rem;
                }
                .tp-col {
                    flex: 1;
                    max-height: 200px;
                    overflow-y: auto;
                    display: flex;
                    flex-direction: column;
                    padding-right: 4px;
                }
                .tp-col::-webkit-scrollbar { width: 4px; }
                .tp-col::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
                .tp-opt {
                    padding: 0.6rem;
                    text-align: center;
                    font-size: 0.85rem;
                    font-weight: 700;
                    color: var(--text-muted);
                    cursor: pointer;
                    border-radius: 8px;
                    transition: all 0.2s;
                }
                .tp-opt:hover { background: rgba(255,255,255,0.05); color: #fff; }
                .tp-opt.selected { background: var(--primary-color); color: #fff; }

                /* Delete Confirm */
                .cal-confirm-overlay {
                    position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.6);
                    backdrop-filter: blur(8px); display: flex; justify-content: center; align-items: center;
                    z-index: 1100; opacity: 0; visibility: hidden; transition: all 0.3s ease;
                }
                .cal-confirm-overlay.active { opacity: 1; visibility: visible; }
                .cal-confirm-card {
                    background: var(--bg-main); border: 1px solid var(--card-border); border-radius: 20px;
                    padding: 2.25rem; width: 90%; max-width: 360px; text-align: center;
                }
                .cal-confirm-card h4 { color: var(--text-main); font-size: 1.25rem; font-weight: 800; margin-bottom: 1rem; }
                .cal-btn-danger { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
                .cal-btn-danger:hover { background: #ef4444; color: #fff; }
            </style>

            <div class="card calendar-sidebar">
                <!-- Calendar Header -->
                <div class="calendar-header">
                    <h3>Calendar</h3>
                    <div class="calendar-nav">
                        <button class="calendar-nav-btn" id="cal-prev" title="Previous month">‹</button>
                        <span class="calendar-month-label" id="cal-month-label"></span>
                        <button class="calendar-nav-btn" id="cal-next" title="Next month">›</button>
                    </div>
                </div>

                <!-- Weekday Headers -->
                <div class="calendar-weekdays">
                    <div class="calendar-weekday">Sun</div>
                    <div class="calendar-weekday">Mon</div>
                    <div class="calendar-weekday">Tue</div>
                    <div class="calendar-weekday">Wed</div>
                    <div class="calendar-weekday">Thu</div>
                    <div class="calendar-weekday">Fri</div>
                    <div class="calendar-weekday">Sat</div>
                </div>

                <!-- Calendar Grid -->
                <div class="calendar-grid" id="cal-grid"></div>

                <!-- Add Event Button -->
                <button class="calendar-add-btn" id="cal-add-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add Event
                </button>
            </div>
        </div>

        <!-- Create / Edit Event Modal -->
        <div class="cal-modal-overlay" id="cal-event-modal">
            <div class="cal-modal">
                <h3 id="cal-modal-title">New Event</h3>
                <div class="cal-modal-field">
                    <label for="cal-input-title">Title</label>
                    <input type="text" id="cal-input-title" placeholder="Event title" maxlength="255">
                </div>
                <div class="cal-modal-field">
                    <label for="cal-input-desc">Description</label>
                    <textarea id="cal-input-desc" placeholder="Optional description" rows="2"></textarea>
                </div>
                <div class="cal-modal-field" style="position: relative;">
                    <label for="cal-input-date">Date</label>
                    <input type="text" id="cal-input-date" placeholder="Select date" readonly style="cursor: pointer;">
                    <div class="datepicker-dropdown" id="cal-datepicker">
                        <div class="dp-header">
                            <div class="dp-month" id="dp-month-label">March 2026</div>
                            <div class="dp-nav">
                                <button type="button" class="dp-nav-btn" id="dp-prev">←</button>
                                <button type="button" class="dp-nav-btn" id="dp-next">→</button>
                            </div>
                        </div>
                        <div class="dp-grid">
                            <div class="dp-weekday">Su</div>
                            <div class="dp-weekday">Mo</div>
                            <div class="dp-weekday">Tu</div>
                            <div class="dp-weekday">We</div>
                            <div class="dp-weekday">Th</div>
                            <div class="dp-weekday">Fr</div>
                            <div class="dp-weekday">Sa</div>
                        </div>
                        <div class="dp-grid" id="dp-days"></div>
                    </div>
                </div>
                <div class="cal-modal-field" style="position: relative;">
                    <label for="cal-input-time">Time</label>
                    <input type="text" id="cal-input-time" placeholder="Select time" readonly style="cursor: pointer;">
                    <div class="timepicker-dropdown" id="cal-timepicker">
                        <div class="tp-col" id="tp-hours"></div>
                        <div class="tp-col" id="tp-mins"></div>
                        <div class="tp-col" id="tp-ampm">
                            <div class="tp-opt" data-val="AM">AM</div>
                            <div class="tp-opt" data-val="PM">PM</div>
                        </div>
                    </div>
                </div>
                <div class="cal-modal-field">
                    <label>Color</label>
                    <div class="cal-color-picker" id="cal-color-picker">
                        <div class="cal-color-option selected" data-color="#3b82f6" style="background: #3b82f6;" title="Blue"></div>
                        <div class="cal-color-option" data-color="#1e3a8a" style="background: #1e3a8a;" title="Navy"></div>
                        <div class="cal-color-option" data-color="#f59e0b" style="background: #f59e0b;" title="Gold"></div>
                        <div class="cal-color-option" data-color="#10b981" style="background: #10b981;" title="Green"></div>
                        <div class="cal-color-option" data-color="#8b5cf6" style="background: #8b5cf6;" title="Purple"></div>
                        <div class="cal-color-option" data-color="#ef4444" style="background: #ef4444;" title="Red"></div>
                        <div class="cal-color-option" data-color="#ec4899" style="background: #ec4899;" title="Pink"></div>
                        <div class="cal-color-option" data-color="#0ea5e9" style="background: #0ea5e9;" title="Cyan"></div>
                    </div>
                </div>
                <div class="cal-modal-actions">
                    <button class="cal-btn cal-btn-secondary" id="cal-modal-cancel">Cancel</button>
                    <button class="cal-btn cal-btn-primary" id="cal-modal-save">Save</button>
                </div>
            </div>
        </div>

        <!-- Day Events Popup -->
        <div class="cal-day-popup" id="cal-day-popup">
            <div class="cal-day-popup-card">
                <div class="cal-day-popup-header">
                    <h4 id="cal-day-popup-title"></h4>
                    <button class="cal-day-popup-close" id="cal-day-popup-close">×</button>
                </div>
                <div id="cal-day-popup-events"></div>
                <button class="cal-day-popup-add-btn" id="cal-day-popup-add">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                    Add event on this day
                </button>
            </div>
        </div>

        <!-- Delete Confirmation -->
        <div class="cal-confirm-overlay" id="cal-confirm-delete">
            <div class="cal-confirm-card">
                <h4>Delete Event?</h4>
                <p>This action cannot be undone.</p>
                <div class="cal-confirm-actions">
                    <button class="cal-btn cal-btn-secondary" id="cal-confirm-no">Cancel</button>
                    <button class="cal-btn cal-btn-danger" id="cal-confirm-yes">Delete</button>
                </div>
            </div>
        </div>

    </main>

<!-- Calendar Script -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const CSRF = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const MONTHS = ['January','February','March','April','May','June','July','August','September','October','November','December'];

        let currentMonth = new Date().getMonth();
        let currentYear = new Date().getFullYear();
        let eventsCache = {};        // { 'YYYY-MM-DD': [event, ...] }
        let editingEventId = null;   // null = create mode, id = edit mode
        let deletingEventId = null;
        let selectedColor = '#3b82f6';
        let activeDayPopupDate = null;

        // DOM refs
        const grid = document.getElementById('cal-grid');
        const monthLabel = document.getElementById('cal-month-label');
        const prevBtn = document.getElementById('cal-prev');
        const nextBtn = document.getElementById('cal-next');
        const addBtn = document.getElementById('cal-add-btn');

        const eventModal = document.getElementById('cal-event-modal');
        const modalTitle = document.getElementById('cal-modal-title');
        const inputTitle = document.getElementById('cal-input-title');
        const inputDesc = document.getElementById('cal-input-desc');
        const inputDate = document.getElementById('cal-input-date');
        const inputTime = document.getElementById('cal-input-time');
        const colorPicker = document.getElementById('cal-color-picker');
        const modalCancel = document.getElementById('cal-modal-cancel');
        const modalSave = document.getElementById('cal-modal-save');

        const dayPopup = document.getElementById('cal-day-popup');
        const dayPopupTitle = document.getElementById('cal-day-popup-title');
        const dayPopupEvents = document.getElementById('cal-day-popup-events');
        const dayPopupClose = document.getElementById('cal-day-popup-close');
        const dayPopupAdd = document.getElementById('cal-day-popup-add');

        const confirmOverlay = document.getElementById('cal-confirm-delete');
        const confirmYes = document.getElementById('cal-confirm-yes');
        const confirmNo = document.getElementById('cal-confirm-no');

        // ── Helpers ──
        function pad(n) { return n < 10 ? '0' + n : '' + n; }

        function dateKey(y, m, d) { return `${y}-${pad(m + 1)}-${pad(d)}`; }

        function formatTime(t) {
            if (!t) return '';
            const [h, m] = t.split(':');
            const hr = parseInt(h);
            const ampm = hr >= 12 ? 'PM' : 'AM';
            const h12 = hr % 12 || 12;
            return `${h12}:${m} ${ampm}`;
        }

        function formatDateNice(dateStr) {
            const d = new Date(dateStr + 'T00:00:00');
            return `${MONTHS[d.getMonth()]} ${d.getDate()}, ${d.getFullYear()}`;
        }

        // ── Fetch Events ──
        async function fetchEvents() {
            try {
                const res = await fetch(`{{ route('dashboard.events') }}?month=${currentMonth + 1}&year=${currentYear}`, {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await res.json();
                eventsCache = {};
                data.forEach(ev => {
                    const key = ev.event_date;
                    if (!eventsCache[key]) eventsCache[key] = [];
                    eventsCache[key].push(ev);
                });
                renderGrid();
            } catch (err) {
                console.error('Failed to fetch events:', err);
            }
        }

        // ── Render Calendar Grid ──
        function renderGrid() {
            monthLabel.textContent = `${MONTHS[currentMonth]} ${currentYear}`;
            grid.innerHTML = '';

            const firstDay = new Date(currentYear, currentMonth, 1).getDay();
            const daysInMonth = new Date(currentYear, currentMonth + 1, 0).getDate();
            const daysInPrev = new Date(currentYear, currentMonth, 0).getDate();

            const today = new Date();
            const todayKey = dateKey(today.getFullYear(), today.getMonth(), today.getDate());

            // Previous month trailing days
            for (let i = firstDay - 1; i >= 0; i--) {
                const d = daysInPrev - i;
                const cell = createDayCell(d, true, null);
                grid.appendChild(cell);
            }

            // Current month days
            for (let d = 1; d <= daysInMonth; d++) {
                const key = dateKey(currentYear, currentMonth, d);
                const isToday = key === todayKey;
                const cell = createDayCell(d, false, key, isToday);
                grid.appendChild(cell);
            }

            // Next month leading days
            const totalCells = firstDay + daysInMonth;
            const remaining = totalCells % 7 === 0 ? 0 : 7 - (totalCells % 7);
            for (let d = 1; d <= remaining; d++) {
                const cell = createDayCell(d, true, null);
                grid.appendChild(cell);
            }
        }

        function createDayCell(dayNum, isOther, dateKeyStr, isToday = false) {
            const cell = document.createElement('div');
            cell.className = 'calendar-day';
            if (isOther) cell.classList.add('other-month');
            if (isToday) cell.classList.add('today');

            const num = document.createElement('div');
            num.className = 'calendar-day-number';
            num.textContent = dayNum;
            cell.appendChild(num);

            if (dateKeyStr && eventsCache[dateKeyStr]) {
                const dots = document.createElement('div');
                dots.className = 'calendar-event-dots';
                eventsCache[dateKeyStr].forEach(ev => {
                    const dot = document.createElement('div');
                    dot.className = 'calendar-event-dot';
                    dot.style.background = ev.color || '#3b82f6';
                    dots.appendChild(dot);
                });
                cell.appendChild(dots);
            }

            if (!isOther && dateKeyStr) {
                cell.addEventListener('click', () => openDayPopup(dateKeyStr));
            }

            return cell;
        }

        // ── Month Navigation ──
        prevBtn.addEventListener('click', () => {
            currentMonth--;
            if (currentMonth < 0) { currentMonth = 11; currentYear--; }
            fetchEvents();
        });

        nextBtn.addEventListener('click', () => {
            currentMonth++;
            if (currentMonth > 11) { currentMonth = 0; currentYear++; }
            fetchEvents();
        });

        // ── Add Event Button ──
        addBtn.addEventListener('click', () => {
            openEventModal(null, dateKey(currentYear, currentMonth, new Date().getDate() <= new Date(currentYear, currentMonth + 1, 0).getDate() ? new Date().getDate() : 1));
        });

        // ── Event Modal ──
        function openEventModal(event, prefillDate) {
            editingEventId = event ? event.id : null;
            modalTitle.textContent = event ? 'Edit Event' : 'New Event';

            inputTitle.value = event ? event.title : '';
            inputDesc.value = event ? (event.description || '') : '';
            inputDate.value = event ? event.event_date : (prefillDate || '');
            
            // Set Time display and internal selection
            if (event && event.event_time) {
                const [h24, m] = event.event_time.split(':');
                let h = parseInt(h24);
                selAP = h >= 12 ? 'PM' : 'AM';
                h = h % 12 || 12;
                selHr = pad(h);
                selMin = m.substring(0, 2);
                inputTime.value = `${selHr}:${selMin} ${selAP}`;
            } else {
                selHr = "09"; selMin = "00"; selAP = "AM";
                inputTime.value = "09:00 AM";
            }
            
            selectedColor = event ? (event.color || '#3b82f6') : '#3b82f6';
            
            colorPicker.querySelectorAll('.cal-color-option').forEach(el => {
                el.classList.toggle('selected', el.dataset.color === selectedColor);
            });

            eventModal.classList.add('active');
            setTimeout(() => inputTitle.focus(), 100);
        }

        function closeEventModal() {
            eventModal.classList.remove('active');
            editingEventId = null;
        }

        modalCancel.addEventListener('click', closeEventModal);
        eventModal.addEventListener('click', (e) => { if (e.target === eventModal) closeEventModal(); });

        // Color picker
        colorPicker.addEventListener('click', (e) => {
            const opt = e.target.closest('.cal-color-option');
            if (!opt) return;
            selectedColor = opt.dataset.color;
            colorPicker.querySelectorAll('.cal-color-option').forEach(el => {
                el.classList.toggle('selected', el === opt);
            });
        });

        // Save event
        modalSave.addEventListener('click', async () => {
            const title = inputTitle.value.trim();
            if (!title) { inputTitle.focus(); return; }
            const dateVal = inputDate.value;
            if (!dateVal) { inputDate.focus(); return; }

            // Convert display time (12h) to 24h format for backend
            let finalTime = null;
            if (inputTime.value) {
                let [h, mAP] = inputTime.value.split(':');
                let [m, ap] = mAP.split(' ');
                let hr = parseInt(h);
                if (ap === 'PM' && hr < 12) hr += 12;
                if (ap === 'AM' && hr === 12) hr = 0;
                finalTime = `${pad(hr)}:${m}`;
            }

            const payload = {
                title: title,
                description: inputDesc.value.trim() || null,
                event_date: dateVal,
                event_time: finalTime,
                color: selectedColor,
            };

            try {
                let url, method;
                if (editingEventId) {
                    url = `{{ url('/dashboard/events') }}/${editingEventId}`;
                    method = 'PUT';
                } else {
                    url = `{{ route('dashboard.events.store') }}`;
                    method = 'POST';
                }

                const res = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(payload),
                });

                if (!res.ok) throw new Error('Save failed');

                closeEventModal();
                await fetchEvents();

                // Refresh day popup if open
                if (activeDayPopupDate) {
                    openDayPopup(activeDayPopupDate);
                }
            } catch (err) {
                console.error('Error saving event:', err);
                alert('Failed to save event. Please try again.');
            }
        });

        // ── Day Events Popup ──
        function openDayPopup(dateKeyStr) {
            activeDayPopupDate = dateKeyStr;
            const events = eventsCache[dateKeyStr] || [];
            dayPopupTitle.textContent = formatDateNice(dateKeyStr);

            if (events.length === 0) {
                dayPopupEvents.innerHTML = '<div class="cal-no-events">No events on this day</div>';
            } else {
                dayPopupEvents.innerHTML = events.map(ev => {
                    const isGoogle = ev.source === 'google';
                    return `
                        <div class="cal-event-item">
                            <div class="cal-event-item-header">
                                <div class="cal-event-item-dot" style="background: ${ev.color || '#3b82f6'}"></div>
                                <span class="cal-event-item-title">${escHtml(ev.title)}</span>
                                ${ev.event_time ? `<span class="cal-event-item-time">${formatTime(ev.event_time)}</span>` : ''}
                            </div>
                            ${ev.description ? `<div class="cal-event-item-desc">${escHtml(ev.description)}</div>` : ''}
                            <div class="cal-event-item-actions">
                                ${isGoogle ? `
                                    <a href="${ev.htmlLink}" target="_blank" class="cal-event-action-btn" style="text-decoration: none; background: #4285F4; color: white;">View in Google Calendar</a>
                                ` : `
                                    <button class="cal-event-action-btn cal-event-edit-btn" data-id="${ev.id}">Edit</button>
                                    <button class="cal-event-action-btn cal-event-delete-btn" data-id="${ev.id}">Delete</button>
                                `}
                            </div>
                        </div>
                    `;
                }).join('');
            }

            dayPopup.classList.add('active');
        }

        function closeDayPopup() {
            dayPopup.classList.remove('active');
            activeDayPopupDate = null;
        }

        dayPopupClose.addEventListener('click', closeDayPopup);
        dayPopup.addEventListener('click', (e) => { if (e.target === dayPopup) closeDayPopup(); });

        // Add event from day popup
        dayPopupAdd.addEventListener('click', () => {
            const dateStr = activeDayPopupDate;
            closeDayPopup();
            openEventModal(null, dateStr);
        });

        // Edit / Delete from day popup
        dayPopupEvents.addEventListener('click', (e) => {
            const editBtn = e.target.closest('.cal-event-edit-btn');
            const deleteBtn = e.target.closest('.cal-event-delete-btn');

            if (editBtn) {
                const evId = editBtn.dataset.id;
                const ev = findEventById(evId);
                if (ev) {
                    closeDayPopup();
                    openEventModal(ev, null);
                }
            }

            if (deleteBtn) {
                deletingEventId = deleteBtn.dataset.id;
                confirmOverlay.classList.add('active');
            }
        });

        function findEventById(id) {
            const idStr = String(id);
            for (const key in eventsCache) {
                const found = eventsCache[key].find(e => String(e.id) === idStr);
                if (found) return found;
            }
            return null;
        }

        function escHtml(str) {
            const div = document.createElement('div');
            div.textContent = str;
            return div.innerHTML;
        }

        // ── Delete Confirmation ──
        confirmNo.addEventListener('click', () => {
            confirmOverlay.classList.remove('active');
            deletingEventId = null;
        });

        confirmOverlay.addEventListener('click', (e) => {
            if (e.target === confirmOverlay) {
                confirmOverlay.classList.remove('active');
                deletingEventId = null;
            }
        });

        confirmYes.addEventListener('click', async () => {
            if (!deletingEventId) return;
            try {
                const res = await fetch(`{{ url('/dashboard/events') }}/${deletingEventId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': CSRF,
                        'Accept': 'application/json',
                    },
                });
                if (!res.ok) throw new Error('Delete failed');

                confirmOverlay.classList.remove('active');
                deletingEventId = null;
                await fetchEvents();

                // Refresh day popup if still open
                if (activeDayPopupDate) {
                    openDayPopup(activeDayPopupDate);
                }
            } catch (err) {
                console.error('Error deleting event:', err);
                alert('Failed to delete event. Please try again.');
            }
        });

        // ── Custom Datepicker Logic ──
        let dpMonth = new Date().getMonth();
        let dpYear = new Date().getFullYear();
        const dpInput = document.getElementById('cal-input-date');
        const dpDropdown = document.getElementById('cal-datepicker');
        const dpMonthLabel = document.getElementById('dp-month-label');
        const dpDaysGrid = document.getElementById('dp-days');
        const dpPrev = document.getElementById('dp-prev');
        const dpNext = document.getElementById('dp-next');

        dpInput.addEventListener('click', (e) => {
            e.stopPropagation();
            dpDropdown.classList.toggle('active');
            if (dpDropdown.classList.contains('active')) {
                // Set dp to currently selected date in input if valid
                if (dpInput.value) {
                    const d = new Date(dpInput.value + 'T00:00:00');
                    dpMonth = d.getMonth();
                    dpYear = d.getFullYear();
                }
                renderDP();
            }
        });

        document.addEventListener('click', (e) => {
            if (!dpDropdown.contains(e.target) && e.target !== dpInput) {
                dpDropdown.classList.remove('active');
            }
        });

        function renderDP() {
            dpMonthLabel.textContent = `${MONTHS[dpMonth]} ${dpYear}`;
            dpDaysGrid.innerHTML = '';

            const firstDay = new Date(dpYear, dpMonth, 1).getDay();
            const daysInMonth = new Date(dpYear, dpMonth + 1, 0).getDate();
            const today = new Date();
            const selectedStr = dpInput.value;

            // Empty cells for first week
            for (let i = 0; i < firstDay; i++) {
                const empty = document.createElement('div');
                dpDaysGrid.appendChild(empty);
            }

            for (let d = 1; d <= daysInMonth; d++) {
                const dayEl = document.createElement('div');
                dayEl.className = 'dp-day current';
                dayEl.textContent = d;

                const dayKeyStr = dateKey(dpYear, dpMonth, d);
                if (dayKeyStr === selectedStr) dayEl.classList.add('selected');
                if (dayKeyStr === dateKey(today.getFullYear(), today.getMonth(), today.getDate())) dayEl.classList.add('today');

                dayEl.addEventListener('click', () => {
                    dpInput.value = dayKeyStr;
                    dpDropdown.classList.remove('active');
                });

                dpDaysGrid.appendChild(dayEl);
            }
        }

        dpPrev.addEventListener('click', (e) => {
            e.stopPropagation();
            dpMonth--;
            if (dpMonth < 0) { dpMonth = 11; dpYear--; }
            renderDP();
        });

        dpNext.addEventListener('click', (e) => {
            e.stopPropagation();
            dpMonth++;
            if (dpMonth > 11) { dpMonth = 0; dpYear++; }
            renderDP();
        });

        // ── Custom Timepicker Logic ──
        const tpInput = document.getElementById('cal-input-time');
        const tpDropdown = document.getElementById('cal-timepicker');
        const tpHours = document.getElementById('tp-hours');
        const tpMins = document.getElementById('tp-mins');
        const tpAmPm = document.getElementById('tp-ampm');

        let selHr = "09", selMin = "00", selAP = "AM";

        tpInput.addEventListener('click', (e) => {
            e.stopPropagation();
            tpDropdown.classList.toggle('active');
            if (tpDropdown.classList.contains('active')) renderTP();
        });

        document.addEventListener('click', (e) => {
            if (!tpDropdown.contains(e.target) && e.target !== tpInput) {
                tpDropdown.classList.remove('active');
            }
        });

        function renderTP() {
            // Parse current value if exists
            if (tpInput.value) {
                const match = tpInput.value.match(/(\d+):(\d+)\s(AM|PM)/);
                if (match) { selHr = match[1]; selMin = match[2]; selAP = match[3]; }
            }

            tpHours.innerHTML = '';
            for (let i = 1; i <= 12; i++) {
                const val = pad(i);
                const opt = document.createElement('div');
                opt.className = `tp-opt ${selHr === val ? 'selected' : ''}`;
                opt.textContent = val;
                opt.onclick = () => { selHr = val; updateTP(); renderTP(); };
                tpHours.appendChild(opt);
            }

            tpMins.innerHTML = '';
            for (let i = 0; i < 60; i += 5) {
                const val = pad(i);
                const opt = document.createElement('div');
                opt.className = `tp-opt ${selMin === val ? 'selected' : ''}`;
                opt.textContent = val;
                opt.onclick = () => { selMin = val; updateTP(); renderTP(); };
                tpMins.appendChild(opt);
            }

            tpAmPm.querySelectorAll('.tp-opt').forEach(opt => {
                opt.classList.toggle('selected', opt.dataset.val === selAP);
                opt.onclick = () => { selAP = opt.dataset.val; updateTP(); renderTP(); };
            });
        }

        function updateTP() {
            tpInput.value = `${selHr}:${selMin} ${selAP}`;
        }

        // Modified Save logic to handle time conversion back to HH:MM (24h)
        const originalModalSave = modalSave.onclick; // wait, it's an addEventListener
        // I need to intercept the payload. 
        // Actually, the backend might handle "09:00 AM" if I change the input value, but it expects "HH:MM".
        // Let's modify the actual Save Event listener in the file.

        // ── Init ──
        fetchEvents();
    });
    </script>
