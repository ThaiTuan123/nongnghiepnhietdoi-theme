<script setup>
import { computed, ref, watch, onMounted, onBeforeUnmount, nextTick } from 'vue';

const props = defineProps({
  // [{ image, thumb, title, category, excerpt, url, price, meta }]
  slides: { type: Array, default: () => [] },
  interval: { type: Number, default: 5000 },
});

const current = ref(0);
const paused = ref(false);
const entered = ref(false);
let timer = null;

const total = computed(() => props.slides.length);
const active = computed(() => props.slides[current.value] || null);

/** Hai slide kế tiếp (vòng) để hiện card teaser góc phải. */
const teasers = computed(() => {
  if (total.value < 2) return [];
  const out = [];
  for (let n = 1; n <= Math.min(2, total.value - 1); n++) {
    const i = (current.value + n) % total.value;
    out.push({ ...props.slides[i], index: i });
  }
  return out;
});

function clearTimer() {
  if (timer) {
    clearTimeout(timer);
    timer = null;
  }
}

function schedule() {
  clearTimer();
  if (paused.value || total.value <= 1) return;
  timer = setTimeout(next, props.interval);
}

function next() {
  if (total.value <= 1) return;
  current.value = (current.value + 1) % total.value;
}

function prev() {
  if (total.value <= 1) return;
  current.value = (current.value - 1 + total.value) % total.value;
}

function goTo(i) {
  if (i < 0 || i >= total.value) return;
  current.value = i;
}

function onEnter() {
  paused.value = true;
  clearTimer();
}

function onLeave() {
  paused.value = false;
  schedule();
}

watch(current, () => schedule());

onMounted(() => {
  requestAnimationFrame(() => {
    requestAnimationFrame(() => {
      entered.value = true;
    });
  });
  nextTick(schedule);
});

onBeforeUnmount(clearTimer);
</script>

<template>
  <div
    class="lx-feat relative h-full w-full overflow-hidden bg-neutral-900"
    :class="{ 'is-entered': entered }"
    @mouseenter="onEnter"
    @mouseleave="onLeave"
  >
    <!-- Background slides -->
    <div
      v-for="(slide, i) in slides"
      :key="'bg-' + i"
      class="lx-feat-bg absolute inset-0 transition-opacity duration-[1100ms] ease-out"
      :class="i === current ? 'opacity-100' : 'opacity-0'"
      aria-hidden="true"
    >
      <img
        v-if="slide.image"
        class="lx-feat-img h-full w-full object-cover"
        :class="i === current ? 'is-active' : ''"
        :src="slide.image"
        :alt="slide.title || ''"
        :fetchpriority="i === 0 ? 'high' : 'auto'"
      />
      <div
        v-else
        class="h-full w-full bg-gradient-to-br from-brand-900 via-brand-700 to-brand-500"
      ></div>
    </div>

    <!-- Overlay -->
    <div
      class="lx-feat-overlay pointer-events-none absolute inset-0 bg-gradient-to-r from-black/75 via-black/45 to-black/25"
    ></div>
    <div
      class="lx-feat-overlay lx-feat-overlay--late pointer-events-none absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-black/30"
    ></div>

    <!-- Main copy (left) -->
    <div class="relative z-10 flex h-full flex-col justify-center px-5 py-16 sm:px-8 md:px-12 lg:max-w-[58%] lg:px-16 xl:px-20">
      <transition name="lx-feat-fade" mode="out-in" appear>
        <div :key="current" class="max-w-xl">
          <p
            v-if="active?.category"
            class="lx-feat-line mb-3 text-xs font-medium uppercase tracking-[0.18em] text-white/80"
            style="--d: 0"
          >
            {{ active.category }}
          </p>
          <h2
            class="lx-feat-line text-2xl font-bold leading-tight text-white sm:text-3xl md:text-4xl lg:text-5xl"
            style="--d: 1"
          >
            {{ active?.title }}
          </h2>
          <p
            v-if="active?.excerpt"
            class="lx-feat-line mt-3 line-clamp-3 text-sm leading-relaxed text-white/80 sm:mt-4 sm:text-base"
            style="--d: 2"
          >
            {{ active.excerpt }}
          </p>
          <div
            v-if="active?.price || active?.meta"
            class="lx-feat-line mt-4 flex flex-wrap items-center gap-3 text-sm text-white/75"
            style="--d: 3"
          >
            <span
              v-if="active.price"
              class="rounded-full bg-brand px-3 py-1 text-xs font-semibold text-white"
            >
              {{ active.price }}
            </span>
            <span v-if="active.meta">{{ active.meta }}</span>
          </div>
          <a
            v-if="active?.url"
            :href="active.url"
            class="lx-feat-line mt-6 inline-flex items-center justify-center rounded-full border border-white/80 px-6 py-2.5 text-xs font-semibold uppercase tracking-[0.14em] text-white transition hover:bg-white hover:text-neutral-900 sm:mt-8 sm:px-8 sm:py-3 sm:text-sm"
            style="--d: 4"
          >
            Xem thêm
          </a>
        </div>
      </transition>
    </div>

    <!-- Prev / Next -->
    <div
      v-if="total > 1"
      class="absolute left-3 right-3 top-1/2 z-20 flex -translate-y-1/2 justify-between sm:left-5 sm:right-5"
    >
      <button
        type="button"
        class="lx-feat-nav lx-feat-nav--prev flex h-10 w-10 items-center justify-center rounded-full border border-white/30 bg-black/30 text-white backdrop-blur-sm transition hover:border-white hover:bg-white/15 sm:h-12 sm:w-12"
        aria-label="Slide trước"
        @click="prev"
      >
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
        </svg>
      </button>
      <button
        type="button"
        class="lx-feat-nav lx-feat-nav--next flex h-10 w-10 items-center justify-center rounded-full border border-white/30 bg-black/30 text-white backdrop-blur-sm transition hover:border-white hover:bg-white/15 sm:h-12 sm:w-12"
        aria-label="Slide sau"
        @click="next"
      >
        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
      </button>
    </div>

    <!-- Teaser cards (bottom-right, tablet+) -->
    <div
      v-if="teasers.length"
      class="absolute bottom-6 right-6 z-20 hidden max-w-none gap-3 md:flex"
    >
      <div
        v-for="(card, ti) in teasers"
        :key="'teaser-slot-' + ti"
        class="lx-feat-teaser group flex w-52 shrink-0 flex-col overflow-hidden rounded-xl bg-white text-left shadow-xl ring-1 ring-black/5 transition hover:-translate-y-0.5 hover:shadow-2xl hover:ring-brand/30 md:w-56"
        :style="{ '--t': ti }"
      >
        <button
          type="button"
          class="block w-full overflow-hidden bg-neutral-100 text-left"
          :aria-label="'Xem slide: ' + card.title"
          @click="goTo(card.index)"
        >
          <div class="aspect-[16/10] w-full overflow-hidden">
            <img
              v-if="card.thumb || card.image"
              class="h-full w-full object-cover transition duration-700 group-hover:scale-105"
              :src="card.thumb || card.image"
              :alt="card.title || ''"
              loading="lazy"
            />
          </div>
        </button>
        <div class="flex flex-1 flex-col gap-1.5 p-3 sm:p-3.5">
          <button
            type="button"
            class="text-left"
            @click="goTo(card.index)"
          >
            <span
              v-if="card.category"
              class="mb-1.5 block text-[10px] font-semibold uppercase tracking-[0.14em] text-brand"
            >
              {{ card.category }}
            </span>
            <span class="line-clamp-2 text-xs font-bold leading-snug text-neutral-900 sm:text-sm">
              {{ card.title }}
            </span>
          </button>
          <a
            v-if="card.url"
            :href="card.url"
            class="mt-auto pt-1 text-[10px] font-semibold uppercase tracking-[0.12em] text-brand transition hover:text-brand-700 sm:text-[11px]"
          >
            Xem thêm →
          </a>
        </div>
      </div>
    </div>

    <!-- Progress dots (mobile / fallback) -->
    <div
      v-if="total > 1"
      class="lx-feat-dots absolute bottom-4 left-1/2 z-20 flex -translate-x-1/2 gap-1.5 lg:hidden"
    >
      <button
        v-for="(_, i) in slides"
        :key="'dot-' + i"
        type="button"
        class="h-1.5 rounded-full transition-all"
        :class="i === current ? 'w-6 bg-brand' : 'w-1.5 bg-white/40'"
        :aria-label="'Slide ' + (i + 1)"
        :aria-current="i === current ? 'true' : 'undefined'"
        @click="goTo(i)"
      />
    </div>
  </div>
</template>

<style scoped>
/* ── First-load stage ── */
.lx-feat-img {
  transform: scale(1.14);
  transition: transform 6.5s cubic-bezier(0.22, 1, 0.36, 1);
}
.lx-feat.is-entered .lx-feat-img.is-active {
  transform: scale(1);
}
.lx-feat-img:not(.is-active) {
  transform: scale(1.08);
  transition: transform 1.1s ease;
}

.lx-feat-overlay {
  opacity: 0;
  transition: opacity 1.1s ease 0.15s;
}
.lx-feat-overlay--late {
  transition-delay: 0.35s;
}
.lx-feat.is-entered .lx-feat-overlay {
  opacity: 1;
}

.lx-feat-nav {
  opacity: 0;
  transition:
    opacity 0.7s cubic-bezier(0.22, 1, 0.36, 1),
    transform 0.7s cubic-bezier(0.22, 1, 0.36, 1),
    border-color 0.2s ease,
    background-color 0.2s ease;
}
.lx-feat-nav--prev {
  transform: translateX(-28px);
  transition-delay: 0.55s;
}
.lx-feat-nav--next {
  transform: translateX(28px);
  transition-delay: 0.65s;
}
.lx-feat.is-entered .lx-feat-nav {
  opacity: 1;
  transform: none;
}

.lx-feat-teaser {
  opacity: 0;
  transform: translateY(36px);
  transition:
    opacity 0.8s cubic-bezier(0.22, 1, 0.36, 1),
    transform 0.8s cubic-bezier(0.22, 1, 0.36, 1),
    box-shadow 0.25s ease,
    ring-color 0.25s ease;
  transition-delay: calc(0.85s + var(--t, 0) * 0.12s);
}
.lx-feat.is-entered .lx-feat-teaser {
  opacity: 1;
  transform: none;
}

.lx-feat-dots {
  opacity: 0;
  transform: translate(-50%, 12px);
  transition:
    opacity 0.6s ease 0.9s,
    transform 0.6s cubic-bezier(0.22, 1, 0.36, 1) 0.9s;
}
.lx-feat.is-entered .lx-feat-dots {
  opacity: 1;
  transform: translate(-50%, 0);
}

/* ── Copy: first load + slide change ── */
.lx-feat-fade-enter-active {
  transition: opacity 0.35s ease;
}
.lx-feat-fade-leave-active {
  transition: opacity 0.28s ease, transform 0.28s ease;
}
.lx-feat-fade-enter-from {
  opacity: 0;
}
.lx-feat-fade-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}

.lx-feat-fade-enter-active .lx-feat-line {
  animation: lx-feat-line-in 0.85s cubic-bezier(0.22, 1, 0.36, 1) both;
  animation-delay: calc(0.12s + var(--d, 0) * 0.1s);
}

@keyframes lx-feat-line-in {
  from {
    opacity: 0;
    transform: translateY(28px);
    filter: blur(4px);
  }
  to {
    opacity: 1;
    transform: none;
    filter: blur(0);
  }
}

@media (prefers-reduced-motion: reduce) {
  .lx-feat-img,
  .lx-feat-overlay,
  .lx-feat-nav,
  .lx-feat-teaser,
  .lx-feat-dots,
  .lx-feat-fade-enter-active,
  .lx-feat-fade-leave-active {
    transition: none !important;
  }
  .lx-feat-fade-enter-active .lx-feat-line {
    animation: none !important;
  }
  .lx-feat-img,
  .lx-feat-overlay,
  .lx-feat-nav,
  .lx-feat-teaser,
  .lx-feat-dots {
    opacity: 1 !important;
    transform: none !important;
  }
}
</style>
