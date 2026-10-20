<script setup>
import { ref, watch, onMounted, onBeforeUnmount, nextTick } from 'vue';

const props = defineProps({
  // Danh sách slide: { type: 'image' | 'video', src, thumb, poster, alt }
  slides: { type: Array, default: () => [] },
  // Thời gian tự chuyển với mỗi ảnh (ms).
  interval: { type: Number, default: 5000 },
  // Ẩn chữ hero khi đang phát video. Trang chủ giữ chữ luôn hiện.
  hideCopyOnVideo: { type: Boolean, default: true },
  // Lớp gradient phủ lên media. Để trống thì dùng gradient mặc định.
  overlayClass: { type: String, default: '' },
});

const current = ref(0);
const root = ref(null);
const videoEls = {};
let timer = null;

const isSingle = () => props.slides.length <= 1;
const isCurrentVideo = () => props.slides[current.value]?.type === 'video';

function setVideoRef(el, i) {
  if (el) videoEls[i] = el;
}

function clearTimer() {
  if (timer) {
    clearTimeout(timer);
    timer = null;
  }
}

/** Ẩn title/desc/CTA khi đang xem video — tránh che media. */
function syncHeroCopy() {
  if (!props.hideCopyOnVideo) return;
  const copy = root.value?.closest('[data-section="hero"]')?.querySelector('[data-hero-copy]');
  if (!copy) return;
  copy.classList.toggle('hidden', isCurrentVideo());
}

function next() {
  if (isSingle()) return;
  current.value = (current.value + 1) % props.slides.length;
}

function goTo(i) {
  if (i < 0 || i >= props.slides.length) return;
  if (i === current.value) {
    // Bấm lại slide đang xem: khởi động lại (hữu ích với video).
    activate();
    return;
  }
  current.value = i;
}

// Video đã phát xong -> chuyển slide kế tiếp (chỉ khi vẫn đang là slide hiện tại).
function onEnded(i) {
  if (i === current.value) next();
}

function activate() {
  clearTimer();
  syncHeroCopy();

  // Dừng & tua lại mọi video không phải slide hiện tại.
  Object.keys(videoEls).forEach((key) => {
    const idx = Number(key);
    const v = videoEls[idx];
    if (!v) return;
    if (idx !== current.value) {
      try {
        v.pause();
        v.currentTime = 0;
      } catch {
        /* noop */
      }
    }
  });

  const slide = props.slides[current.value];
  if (!slide) return;

  if (slide.type === 'video') {
    const v = videoEls[current.value];
    if (v) {
      try {
        v.currentTime = 0;
      } catch {
        /* noop */
      }
      const p = v.play();
      if (p && typeof p.catch === 'function') {
        // Trình duyệt chặn autoplay -> chuyển bằng bộ đếm giờ để không kẹt slide.
        p.catch(() => {
          timer = setTimeout(next, props.interval);
        });
      }
    } else {
      timer = setTimeout(next, props.interval);
    }
  } else {
    // Ảnh: tự chuyển sau `interval`.
    timer = setTimeout(next, props.interval);
  }
}

watch(current, () => activate());

onMounted(() => {
  nextTick(activate);
});

onBeforeUnmount(clearTimer);
</script>

<template>
  <div ref="root" class="absolute inset-0 h-full w-full overflow-hidden">
    <!-- Các lớp media -->
    <div
      v-for="(slide, i) in slides"
      :key="i"
      class="absolute inset-0 transition-opacity duration-[1200ms] ease-out"
      :class="i === current ? 'opacity-100' : 'opacity-0'"
    >
      <video
        v-if="slide.type === 'video'"
        :ref="(el) => setVideoRef(el, i)"
        class="h-full w-full object-cover"
        :src="slide.src"
        :poster="slide.poster || ''"
        muted
        playsinline
        preload="auto"
        :loop="isSingle()"
        @ended="onEnded(i)"
        @error="onEnded(i)"
      ></video>
      <img
        v-else
        class="h-full w-full object-cover"
        :src="slide.src"
        :alt="slide.alt || ''"
        :fetchpriority="i === 0 ? 'high' : 'auto'"
      />
    </div>

    <!-- Gradient: nhẹ hơn khi video (không cần nền cho chữ) -->
    <div
      class="pointer-events-none absolute inset-0 transition-opacity duration-700"
      :class="[
        overlayClass || 'bg-gradient-to-b from-black/45 via-black/25 to-black/60',
        !overlayClass && isCurrentVideo() ? 'opacity-30' : 'opacity-100',
      ]"
    ></div>

    <!-- Điều hướng thumbnail (góc dưới) -->
    <div
      v-if="slides.length > 1"
      class="absolute bottom-[5.5rem] right-4 z-20 flex max-w-[calc(100%-2rem)] gap-2 sm:right-8 sm:gap-3"
    >
      <button
        v-for="(slide, i) in slides"
        :key="i"
        type="button"
        class="group relative h-12 w-[4.5rem] shrink-0 overflow-hidden rounded-xl ring-2 ring-offset-1 ring-offset-black/20 transition-all duration-300 sm:h-[4.5rem] sm:w-24 sm:ring-offset-2"
        :class="
          i === current
            ? 'scale-105 opacity-100 ring-white'
            : 'opacity-70 ring-white/40 hover:opacity-100'
        "
        :aria-label="`Chuyển tới slide ${i + 1}`"
        :aria-current="i === current ? 'true' : 'false'"
        @click="goTo(i)"
      >
        <img
          v-if="slide.thumb || slide.poster || slide.type !== 'video'"
          class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-110"
          :src="slide.thumb || slide.poster || slide.src"
          :alt="slide.alt || ''"
        />
        <span v-else class="absolute inset-0 bg-neutral-800"></span>
        <span
          v-if="slide.type === 'video'"
          class="absolute inset-0 flex items-center justify-center bg-black/25"
        >
          <svg
            class="h-3.5 w-3.5 text-white drop-shadow sm:h-5 sm:w-5"
            viewBox="0 0 24 24"
            fill="currentColor"
            aria-hidden="true"
          >
            <path d="M8 5v14l11-7z" />
          </svg>
        </span>
      </button>
    </div>
  </div>
</template>
