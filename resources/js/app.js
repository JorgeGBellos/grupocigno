const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const MAX_MANAGED_VIDEOS = 2;

const registerManagedVideos = () => {
    const videos = new Set();

    const reconcile = () => {
        const candidates = [...videos]
            .filter((video) => video.dataset.shouldPlay === '1')
            .sort((a, b) => a.compareDocumentPosition(b) & Node.DOCUMENT_POSITION_FOLLOWING ? -1 : 1);

        candidates.forEach((video, index) => {
            if (index < MAX_MANAGED_VIDEOS && ! prefersReducedMotion()) {
                if (video.paused) {
                    video.play().catch(() => {});
                }

                return;
            }

            if (! video.paused) {
                video.pause();
            }
        });
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            const video = entry.target;

            if (entry.isIntersecting && entry.intersectionRatio >= 0.3) {
                video.dataset.shouldPlay = '1';
            } else {
                video.dataset.shouldPlay = '0';

                if (! video.paused) {
                    video.pause();
                }
            }
        });

        reconcile();
    }, {
        threshold: [0, 0.3, 0.6],
        rootMargin: '0px',
    });

    const observe = (video) => {
        if (! (video instanceof HTMLVideoElement) || videos.has(video)) {
            return;
        }

        video.removeAttribute('autoplay');
        video.preload = video.preload === 'auto' ? 'metadata' : video.preload;
        video.dataset.shouldPlay = '0';
        videos.add(video);
        observer.observe(video);

        const rect = video.getBoundingClientRect();
        const visible = rect.bottom > 0 && rect.top < window.innerHeight;

        if (visible) {
            video.dataset.shouldPlay = '1';
            reconcile();
        }
    };

    document.querySelectorAll('video[data-managed]').forEach(observe);

    const mutationObserver = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (! (node instanceof HTMLElement)) {
                    return;
                }

                if (node.matches?.('video[data-managed]')) {
                    observe(node);
                }

                node.querySelectorAll?.('video[data-managed]').forEach(observe);
            });
        });
    });

    mutationObserver.observe(document.documentElement, { childList: true, subtree: true });
};

const registerPeekCarousel = (Alpine) => {
    Alpine.data('peekCarousel', (count, options = {}) => ({
        count,
        align: options.align === 'start' ? 'start' : 'center',
        pos: count,
        step: 0,
        base: 0,
        progress: 0,
        dragging: false,
        moved: false,
        pointerId: null,
        originX: 0,
        originPos: 0,
        lastX: 0,
        lastAt: 0,
        velocity: 0,
        tween: null,
        frame: null,
        inView: false,
        sectionObserver: null,
        mediaKey: null,

        init() {
            this.measure();
            this.render(true);

            const observer = new ResizeObserver(() => {
                this.measure();
                this.render();
            });

            observer.observe(this.$refs.viewport);

            this.sectionObserver = new IntersectionObserver(([entry]) => {
                this.inView = Boolean(entry?.isIntersecting);

                if (! this.inView) {
                    this.mediaKey = null;
                    this.pauseVideos();
                } else {
                    this.syncMedia(true);
                }
            }, { threshold: 0.2 });

            this.sectionObserver.observe(this.$refs.viewport);
        },

        measure() {
            const slide = this.$refs.track?.firstElementChild;

            if (! slide) {
                return;
            }

            const width = slide.getBoundingClientRect().width;
            const gap = Number.parseFloat(getComputedStyle(this.$refs.track).columnGap) || 0;

            this.step = width + gap;
            this.base = this.align === 'start'
                ? 0
                : (this.$refs.viewport.clientWidth - width) / 2;
        },

        // Keeps the visible slide inside the middle copy so the loop never runs out of neighbours.
        normalize() {
            if (! this.count) {
                return;
            }

            let shift = 0;

            while (this.pos + shift >= this.count * 2) {
                shift -= this.count;
            }

            while (this.pos + shift < this.count) {
                shift += this.count;
            }

            if (shift === 0) {
                return;
            }

            this.pos += shift;
            this.originPos += shift;

            if (this.tween) {
                this.tween.from += shift;
                this.tween.to += shift;
            }
        },

        render(syncMedia = false) {
            if (! this.step) {
                return;
            }

            this.normalize();

            this.$refs.track.style.transform = `translate3d(${this.base - this.pos * this.step}px, 0, 0)`;

            const offset = ((this.pos - this.count) % this.count + this.count) % this.count;

            this.progress = ((offset + 1) / this.count) * 100;

            if (syncMedia) {
                this.syncMedia();
            }
        },

        pauseVideos() {
            this.$refs.track?.querySelectorAll('video[data-carousel-video]').forEach((video) => {
                if (! video.paused) {
                    video.pause();
                }
            });
        },

        playableIndexes() {
            const positions = [this.pos];

            if (this.tween) {
                positions.push(this.tween.from, this.tween.to);
            }

            const indexes = new Set();

            positions.forEach((position) => {
                const from = Math.floor(position);
                const to = Math.ceil(position);
                const active = Math.round(position);

                indexes.add(from);
                indexes.add(to);
                indexes.add(active);

                // Keep peek neighbours alive so the next slide never flashes a poster.
                if (this.align === 'start') {
                    indexes.add(active + 1);
                    indexes.add(to + 1);
                } else {
                    indexes.add(active - 1);
                    indexes.add(active + 1);
                }
            });

            return indexes;
        },

        syncMedia(force = false) {
            const slides = this.$refs.track?.children;

            if (! slides?.length || ! this.count) {
                return;
            }

            if (! this.inView || prefersReducedMotion()) {
                this.mediaKey = 'paused';
                this.pauseVideos();

                return;
            }

            const playable = this.playableIndexes();
            const mediaKey = [...playable].sort((a, b) => a - b).join(',');

            if (! force && mediaKey === this.mediaKey) {
                return;
            }

            this.mediaKey = mediaKey;

            for (let index = 0; index < slides.length; index += 1) {
                const video = slides[index].querySelector('video[data-carousel-video]');

                if (! video) {
                    continue;
                }

                if (playable.has(index)) {
                    if (video.paused) {
                        video.play().catch(() => {});
                    }

                    continue;
                }

                if (! video.paused) {
                    video.pause();
                }
            }
        },

        loop() {
            this.frame = requestAnimationFrame(() => {
                if (! this.tween) {
                    this.frame = null;

                    return;
                }

                const { from, to, start, duration } = this.tween;
                const elapsed = duration <= 0 ? 1 : Math.min((performance.now() - start) / duration, 1);
                const eased = 1 - Math.pow(1 - elapsed, 3);

                this.pos = from + (to - from) * eased;
                // Warm neighbouring videos while animating, but not on every identical key.
                this.render(true);

                if (elapsed >= 1) {
                    this.tween = null;
                    this.frame = null;
                    this.syncMedia(true);

                    return;
                }

                this.loop();
            });
        },

        animateTo(target) {
            const distance = Math.abs(target - this.pos);
            const duration = prefersReducedMotion() ? 0 : Math.min(240 + distance * 320, 760);

            this.tween = { from: this.pos, to: target, start: performance.now(), duration };
            // Warm origin + destination videos before the tween starts.
            this.syncMedia(true);

            if (! this.frame) {
                this.loop();
            }
        },

        stop() {
            this.tween = null;

            if (this.frame) {
                cancelAnimationFrame(this.frame);
                this.frame = null;
            }
        },

        start(event) {
            if (event.pointerType === 'mouse' && event.button !== 0) {
                return;
            }

            if (! this.step) {
                this.measure();
            }

            this.stop();

            this.dragging = true;
            this.moved = false;
            this.pointerId = event.pointerId;
            this.originX = event.clientX;
            this.originPos = this.pos;
            this.lastX = event.clientX;
            this.lastAt = performance.now();
            this.velocity = 0;

            this.$refs.viewport.setPointerCapture(event.pointerId);
        },

        move(event) {
            if (! this.dragging || event.pointerId !== this.pointerId || ! this.step) {
                return;
            }

            const travel = event.clientX - this.originX;

            if (Math.abs(travel) > 4) {
                this.moved = true;
            }

            const now = performance.now();
            const elapsed = now - this.lastAt;

            if (elapsed > 0) {
                const instant = -(event.clientX - this.lastX) / this.step / elapsed;

                this.velocity = this.velocity * 0.7 + instant * 0.3;
                this.lastX = event.clientX;
                this.lastAt = now;
            }

            this.pos = this.originPos - travel / this.step;
            this.render(true);
        },

        end(event) {
            if (! this.dragging) {
                return;
            }

            this.dragging = false;

            if (this.$refs.viewport.hasPointerCapture(event.pointerId)) {
                this.$refs.viewport.releasePointerCapture(event.pointerId);
            }

            const nearest = Math.round(this.pos);
            const projected = Math.round(this.pos + this.velocity * 140);

            this.animateTo(Math.max(nearest - 2, Math.min(nearest + 2, projected)));
        },

        prev() {
            this.animateTo(Math.round(this.pos) - 1);
        },

        next() {
            this.animateTo(Math.round(this.pos) + 1);
        },
    }));
};

const registerBookingBar = (Alpine) => {
    Alpine.data('bookingBar', ({ locale, labels, limits, hotels, old = {}, lockHotel = false }) => ({
        locale,
        labels,
        limits,
        hotels,
        lockHotel,
        panel: null,
        clientError: '',
        today: '',
        maxCheckin: '',
        checkin: '',
        checkout: '',
        hotel: old.hotel || hotels[0]?.value || 'cigno-mejorada',
        rooms: Number(old.rooms) || 1,
        adults: Number(old.adults) || 2,
        promotionCode: old.promotion_code || '',
        calendarMonth: '',
        roomGuests: [{ adults: Number(old.adults) || 2 }],

        init() {
            const today = new Date();
            today.setHours(0, 0, 0, 0);

            const start = new Date(today);
            start.setDate(start.getDate() + 1);

            const end = new Date(start);
            end.setDate(end.getDate() + 2);

            const maxCheckin = new Date(today);
            maxCheckin.setDate(maxCheckin.getDate() + limits.maxAdvanceDays);

            this.today = this.toIso(today);
            this.maxCheckin = this.toIso(maxCheckin);
            this.checkin = old.checkin || this.toIso(start);
            this.checkout = old.checkout || this.toIso(end);
            this.calendarMonth = this.checkin.slice(0, 7);

            const roomCount = Math.max(1, Number(old.rooms) || 1);
            this.roomGuests = Array.from({ length: roomCount }, () => ({
                adults: Number(old.adults) || 2,
            }));

            this.syncGuestFields();

            this.$watch('checkin', () => {
                if (this.checkout && this.checkout <= this.checkin) {
                    this.checkout = this.minCheckout;
                }

                if (this.checkout && this.checkout > this.maxCheckout) {
                    this.checkout = this.maxCheckout;
                }
            });
        },

        openPanel(name) {
            if (name === 'where' && this.lockHotel) {
                return;
            }

            this.panel = this.panel === name ? null : name;

            if (this.panel === 'when') {
                this.calendarMonth = (this.checkin || this.today).slice(0, 7);
            }
        },

        selectHotel(value) {
            this.hotel = value;
            this.panel = null;
        },

        applyGuests() {
            this.syncGuestFields();
            this.panel = null;
        },

        addRoom() {
            if (this.roomGuests.length >= this.limits.maxRooms) {
                return;
            }

            this.roomGuests.push({ adults: 2 });
        },

        syncGuestFields() {
            this.rooms = this.roomGuests.length;
            this.adults = this.roomGuests[0]?.adults || 1;
        },

        toIso(date) {
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${date.getFullYear()}-${month}-${day}`;
        },

        formatDate(iso) {
            if (! iso) {
                return '';
            }

            return new Intl.DateTimeFormat(this.locale, {
                weekday: 'short',
                month: 'short',
                day: 'numeric',
            }).format(new Date(`${iso}T00:00:00`));
        },

        formatCompactDate(iso) {
            if (! iso) {
                return '';
            }

            const date = new Date(`${iso}T00:00:00`);
            const month = new Intl.DateTimeFormat(this.locale, { month: 'short' })
                .format(date)
                .replace(/\./g, '')
                .toUpperCase();

            return `${month} ${date.getDate()}`;
        },

        get minCheckout() {
            if (! this.checkin) {
                return this.today;
            }

            const next = new Date(`${this.checkin}T00:00:00`);
            next.setDate(next.getDate() + 1);

            return this.toIso(next);
        },

        get maxCheckout() {
            if (! this.checkin) {
                return this.maxCheckin;
            }

            const max = new Date(`${this.checkin}T00:00:00`);
            max.setDate(max.getDate() + this.limits.maxNights);

            return this.toIso(max);
        },

        get nights() {
            if (! this.checkin || ! this.checkout) {
                return 0;
            }

            const start = new Date(`${this.checkin}T00:00:00`);
            const end = new Date(`${this.checkout}T00:00:00`);

            return Math.max(0, Math.round((end - start) / (1000 * 60 * 60 * 24)));
        },

        get dateLabel() {
            return `${this.formatDate(this.checkin)} - ${this.formatDate(this.checkout)}`;
        },

        get compactDateLabel() {
            return `${this.formatCompactDate(this.checkin)} - ${this.formatCompactDate(this.checkout)}`;
        },

        get totalGuests() {
            return this.roomGuests.reduce((total, room) => total + room.adults, 0);
        },

        get hotelLabel() {
            return this.hotels.find((option) => option.value === this.hotel)?.label || '';
        },

        get guestLabel() {
            const people = this.roomGuests.reduce((total, room) => total + room.adults, 0);
            const peopleLabel = people === 1
                ? this.labels.people_one
                : this.labels.people_other.replace(':count', people);
            const roomsLabel = this.roomGuests.length === 1
                ? this.labels.rooms_one
                : this.labels.rooms_other.replace(':count', this.roomGuests.length);

            return `${peopleLabel} · ${roomsLabel}`;
        },

        get calendarMonthLabel() {
            return this.monthLabel(this.calendarMonth);
        },

        get calendarMonths() {
            const [year, month] = this.calendarMonth.split('-').map(Number);
            const next = new Date(year, month, 1);

            return [
                this.calendarMonth,
                `${next.getFullYear()}-${String(next.getMonth() + 1).padStart(2, '0')}`,
            ];
        },

        get calendarWeekdays() {
            const formatter = new Intl.DateTimeFormat(this.locale, { weekday: 'short' });

            // Local noon avoids timezone shifting Sunday → Saturday.
            return Array.from({ length: 7 }, (_, index) => (
                formatter.format(new Date(2023, 0, 1 + index, 12, 0, 0)).replace('.', '').toUpperCase()
            ));
        },

        get calendarDays() {
            return this.daysForMonth(this.calendarMonth);
        },

        monthLabel(monthKey) {
            const [year, month] = monthKey.split('-').map(Number);

            return new Intl.DateTimeFormat(this.locale, {
                month: 'long',
                year: 'numeric',
            }).format(new Date(year, month - 1, 1)).toUpperCase();
        },

        daysForMonth(monthKey) {
            const [year, month] = monthKey.split('-').map(Number);
            const firstDay = new Date(year, month - 1, 1);
            const startOffset = firstDay.getDay();
            const daysInMonth = new Date(year, month, 0).getDate();
            const cells = [];

            for (let i = 0; i < startOffset; i += 1) {
                cells.push({ empty: true, key: `${monthKey}-empty-${i}` });
            }

            for (let day = 1; day <= daysInMonth; day += 1) {
                const date = new Date(year, month - 1, day);
                const iso = this.toIso(date);
                cells.push({
                    empty: false,
                    key: iso,
                    iso,
                    day,
                    disabled: iso < this.today || iso > this.maxCheckin,
                    state: this.dateState(iso),
                });
            }

            return cells;
        },

        dateState(iso) {
            if (! this.checkin) {
                return null;
            }

            if (this.checkout) {
                if (iso === this.checkin || iso === this.checkout) {
                    return 'edge';
                }

                if (iso > this.checkin && iso < this.checkout) {
                    return 'between';
                }

                return null;
            }

            return iso === this.checkin ? 'edge' : null;
        },

        prevMonth() {
            const [year, month] = this.calendarMonth.split('-').map(Number);
            const date = new Date(year, month - 2, 1);
            this.calendarMonth = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
        },

        nextMonth() {
            const [year, month] = this.calendarMonth.split('-').map(Number);
            const date = new Date(year, month, 1);
            this.calendarMonth = `${date.getFullYear()}-${String(date.getMonth() + 1).padStart(2, '0')}`;
        },

        selectCalendarDay(iso) {
            if (iso < this.today || iso > this.maxCheckin) {
                return;
            }

            if (! this.checkin || (this.checkin && this.checkout)) {
                this.checkin = iso;
                this.checkout = '';

                return;
            }

            if (iso <= this.checkin) {
                this.checkin = iso;
                this.checkout = '';

                return;
            }

            const maxCheckout = this.maxCheckout;
            this.checkout = iso > maxCheckout ? maxCheckout : iso;

            if (this.checkout && window.matchMedia('(max-width: 1023px)').matches) {
                this.panel = null;
            }
        },

        onSubmit(event) {
            this.syncGuestFields();
            this.clientError = '';

            if (! this.checkin || ! this.checkout) {
                this.clientError = this.labels.validation.dates_required;
                event.preventDefault();

                return;
            }

            if (this.checkin < this.today) {
                this.clientError = this.labels.validation.checkin_past;
                event.preventDefault();

                return;
            }

            if (this.checkin > this.maxCheckin) {
                this.clientError = this.labels.validation.checkin_too_far;
                event.preventDefault();

                return;
            }

            if (this.checkout <= this.checkin) {
                this.clientError = this.labels.validation.checkout_before_checkin;
                event.preventDefault();

                return;
            }

            if (this.nights > this.limits.maxNights) {
                this.clientError = this.labels.validation.max_nights;
                event.preventDefault();

                return;
            }

            const totalGuests = this.roomGuests.reduce((total, room) => total + room.adults, 0);

            if (totalGuests > this.limits.maxTotalGuests) {
                this.clientError = this.labels.validation.max_guests;
                event.preventDefault();

                return;
            }

            if (this.promotionCode && ! /^[A-Za-z0-9_-]+$/.test(this.promotionCode)) {
                this.clientError = this.labels.validation.promotion_invalid;
                event.preventDefault();
            }
        },
    }));
};

const registerShopProductCarousel = (Alpine) => {
    Alpine.data('shopProductCarousel', (products) => ({
        products,
        index: 0,
        dragging: false,
        moved: false,
        pointerId: null,
        originX: 0,
        lastX: 0,
        lastAt: 0,
        velocity: 0,

        get current() {
            return this.products[this.index] || this.products[0];
        },

        get progress() {
            if (! this.products.length) {
                return 0;
            }

            return ((this.index + 1) / this.products.length) * 100;
        },

        start(event) {
            if (event.pointerType === 'mouse' && event.button !== 0) {
                return;
            }

            this.dragging = true;
            this.moved = false;
            this.pointerId = event.pointerId;
            this.originX = event.clientX;
            this.lastX = event.clientX;
            this.lastAt = performance.now();
            this.velocity = 0;

            event.currentTarget.setPointerCapture(event.pointerId);
        },

        move(event) {
            if (! this.dragging || event.pointerId !== this.pointerId) {
                return;
            }

            const travel = event.clientX - this.originX;

            if (Math.abs(travel) > 8) {
                this.moved = true;
            }

            const now = performance.now();
            const elapsed = now - this.lastAt;

            if (elapsed > 0) {
                this.velocity = (event.clientX - this.lastX) / elapsed;
                this.lastX = event.clientX;
                this.lastAt = now;
            }
        },

        end(event) {
            if (! this.dragging) {
                return;
            }

            this.dragging = false;

            if (event.currentTarget.hasPointerCapture?.(event.pointerId)) {
                event.currentTarget.releasePointerCapture(event.pointerId);
            }

            const travel = event.clientX - this.originX;
            const flick = Math.abs(this.velocity) > 0.4;

            if (travel < -48 || (flick && this.velocity < 0)) {
                this.next();
            } else if (travel > 48 || (flick && this.velocity > 0)) {
                this.prev();
            }
        },

        prev() {
            this.index = (this.index - 1 + this.products.length) % this.products.length;
        },

        next() {
            this.index = (this.index + 1) % this.products.length;
        },
    }));
};

const registerHoverVideo = (Alpine) => {
    Alpine.data('hoverVideo', () => ({
        active: false,
        loaded: false,

        start() {
            if (prefersReducedMotion()) {
                return;
            }

            const video = this.$refs.video;

            if (! (video instanceof HTMLVideoElement)) {
                return;
            }

            if (! this.loaded) {
                const src = video.dataset.src;

                if (! src) {
                    return;
                }

                video.src = src;
                this.loaded = true;
                video.load();
            }

            this.active = true;
            video.play().catch(() => {});
        },

        stop() {
            const video = this.$refs.video;

            this.active = false;

            if (! (video instanceof HTMLVideoElement) || video.paused) {
                return;
            }

            video.pause();
        },
    }));
};

if (window.Alpine) {
    registerPeekCarousel(window.Alpine);
    registerBookingBar(window.Alpine);
    registerShopProductCarousel(window.Alpine);
    registerHoverVideo(window.Alpine);
} else {
    document.addEventListener('alpine:init', () => {
        registerPeekCarousel(window.Alpine);
        registerBookingBar(window.Alpine);
        registerShopProductCarousel(window.Alpine);
        registerHoverVideo(window.Alpine);
    });
}

const bootManagedVideos = () => registerManagedVideos();

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', bootManagedVideos);
} else {
    bootManagedVideos();
}
