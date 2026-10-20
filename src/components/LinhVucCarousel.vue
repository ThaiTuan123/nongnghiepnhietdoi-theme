<script setup>
import { ref, computed, onMounted, onBeforeUnmount } from 'vue';

const props = defineProps({
  // Danh mục lĩnh vực: { image, alt, title, description, url }
  items: { type: Array, default: () => [] },
  // Thời gian tự chuyển (ms).
  interval: { type: Number, default: 5000 },
});

const track = ref(null);
let timer = null;
let resizeObserver = null;

const hasNav = computed(() => props.items.length > 1);

function step() {
  const el = track.value;
  if (!el) return 0;
  const card = el.querySelector('[data-card]');
  if (!card) return el.clientWidth;
  const gap = parseFloat(getComputedStyle(el).columnGap || '0') || 0;
  return card.offsetWidth + gap;
}

function atEnd() {
  const el = track.value;
  if (!el) return true;
  return el.scrollLeft + el.clientWidth >= el.scrollWidth - 2;
}

function atStart() {
  const el = track.value;
  return el ? el.scrollLeft <= 2 : true;
}

function next() {
  const el = track.value;
  if (!el) return;
  if (atEnd()) {
    el.scrollTo({ left: 0, behavior: 'smooth' });
  } else {
    el.scrollBy({ left: step(), behavior: 'smooth' });
  }
}

function prev() {
  const el = track.value;
  if (!el) return;
  if (atStart()) {
    el.scrollTo({ left: el.scrollWidth, behavior: 'smooth' });
  } else {
    el.scrollBy({ left: -step(), behavior: 'smooth' });
  }
}

function startAuto() {
  stopAuto();
  if (!hasNav.value) return;
  timer = setInterval(next, props.interval);
}

function stopAuto() {
  if (timer) {
    clearInterval(timer);
    timer = null;
  }
}

onMounted(() => {
  startAuto();
});

onBeforeUnmount(() => {
  stopAuto();
  if (resizeObserver) resizeObserver.disconnect();
});
</script>

<template>
  <div
    class="relative"
    @mouseenter="stopAuto"
    @mouseleave="startAuto"
    @focusin="stopAuto"
    @focusout="startAuto"
  >
    <div
      ref="track"
      class="lx-track flex snap-x snap-mandatory gap-5 overflow-x-auto scroll-smooth pb-4"
    >
      <component
        :is="item.url ? 'a' : 'div'"
        v-for="(item, i) in items"
        :key="i"
        :href="item.url || undefined"
        data-card
        class="group relative flex w-[88%] shrink-0 snap-start flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-black/5 transition-all duration-500 hover:-translate-y-1 hover:shadow-xl focus-visible:-translate-y-1 sm:w-[52%] lg:w-[47%] xl:w-[40%]"
      >
        <span
          class="pointer-events-none absolute inset-0 z-0 origin-top scale-y-0 bg-brand transition-transform duration-700 ease-out group-hover:scale-y-100 group-focus-visible:scale-y-100"
          aria-hidden="true"
        ></span>
        <span
          class="absolute inset-x-0 top-0 z-10 h-1.5 bg-brand transition-colors duration-500 group-hover:bg-white/70"
        ></span>
        <div class="relative z-10 p-4 pt-6">
          <div class="overflow-hidden rounded-xl bg-neutral-100">
            <img
              v-if="item.image"
              :src="item.image"
              :alt="item.alt || item.title || ''"
              class="aspect-[4/3] w-full object-cover transition-transform duration-700 group-hover:scale-105"
              loading="lazy"
            />
          </div>
          <h3
            class="mt-5 text-xl font-bold leading-snug text-neutral-900 transition-colors duration-500 group-hover:text-white"
          >
            {{ item.title }}
          </h3>
          <p
            v-if="item.description"
            class="mt-2 text-sm leading-relaxed text-neutral-500 transition-colors duration-500 group-hover:text-white/85"
          >
            {{ item.description }}
          </p>
        </div>
      </component>
    </div>

    <template v-if="hasNav">
      <button
        type="button"
        class="lx-nav-btn absolute left-0 top-[38%] z-20 flex h-11 w-11 -translate-x-1/2 -translate-y-1/2 items-center justify-center rounded-full bg-white text-brand shadow-lg ring-1 ring-black/5 transition hover:bg-brand hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-brand"
        aria-label="Mục trước"
        @click="prev"
      >
        <svg
          class="h-5 w-5"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.2"
          stroke-linecap="round"
          stroke-linejoin="round"
          aria-hidden="true"
        >
          <path d="M15 18l-6-6 6-6" />
        </svg>
      </button>
      <button
        type="button"
        class="lx-nav-btn absolute right-0 top-[38%] z-20 flex h-11 w-11 -translate-y-1/2 translate-x-1/2 items-center justify-center rounded-full bg-white text-brand shadow-lg ring-1 ring-black/5 transition hover:bg-brand hover:text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-brand"
        aria-label="Mục kế tiếp"
        @click="next"
      >
        <svg
          class="h-5 w-5"
          viewBox="0 0 24 24"
          fill="none"
          stroke="currentColor"
          stroke-width="2.2"
          stroke-linecap="round"
          stroke-linejoin="round"
          aria-hidden="true"
        >
          <path d="M9 18l6-6-6-6" />
        </svg>
      </button>
    </template>
  </div>
</template>

<style scoped>
.lx-track {
  scrollbar-width: none;
  -ms-overflow-style: none;
}
.lx-track::-webkit-scrollbar {
  display: none;
}

/* Sóng lan quanh nút điều hướng để người dùng biết bấm được */
.lx-nav-btn::before,
.lx-nav-btn::after {
  content: '';
  position: absolute;
  inset: 0;
  z-index: -1;
  border-radius: 9999px;
  border: 2px solid var(--brand, #856a3d);
  animation: lx-nav-ripple 3.4s cubic-bezier(0.22, 0.61, 0.36, 1) infinite;
}
.lx-nav-btn::after {
  animation-delay: 1.7s;
}
.lx-nav-btn:hover::before,
.lx-nav-btn:hover::after {
  animation-play-state: paused;
  opacity: 0;
}

@keyframes lx-nav-ripple {
  0% {
    transform: scale(1);
    opacity: 0.55;
  }
  70% {
    opacity: 0;
  }
  100% {
    transform: scale(2.1);
    opacity: 0;
  }
}

@media (prefers-reduced-motion: reduce) {
  .lx-nav-btn::before,
  .lx-nav-btn::after {
    animation: none;
  }
}
</style>
