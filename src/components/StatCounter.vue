<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const props = defineProps({
  value: { type: [Number, String], default: 0 },
  suffix: { type: String, default: '' },
});

const display = ref(0);
const el = ref(null);
let observer = null;

const target = Number(String(props.value).replace(/[^0-9.]/g, '')) || 0;

function animate() {
  const reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (reduce) {
    display.value = target;
    return;
  }
  const duration = 1400;
  const start = performance.now();
  const step = (now) => {
    const p = Math.min((now - start) / duration, 1);
    display.value = Math.round(target * (1 - Math.pow(1 - p, 3)));
    if (p < 1) requestAnimationFrame(step);
  };
  requestAnimationFrame(step);
}

onMounted(() => {
  observer = new IntersectionObserver(
    (entries) => {
      if (entries[0].isIntersecting) {
        animate();
        observer.disconnect();
      }
    },
    { threshold: 0.4 },
  );
  if (el.value) observer.observe(el.value);
});

onUnmounted(() => observer?.disconnect());
</script>

<template>
  <span ref="el">{{ display.toLocaleString('vi-VN') }}{{ suffix }}</span>
</template>
