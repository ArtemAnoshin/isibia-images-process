<template>
  <div>
    <Transition name="toast-slide">
        <div
            v-if="isToastVisible"
            class="dev-notice-toast"
        >
            <div class="toast-header">
                <div class="toast-header-left">
                    <div class="toast-icon">
                    <i class="fas fa-flask"></i>
                    </div>
                    <span class="toast-title">Сайт в разработке</span>
                </div>
                <button
                    class="toast-close"
                    @click="dismiss"
                    title="Закрыть"
                >
                    <i class="fas fa-times"></i>
                </button>
            </div>

            <div class="toast-body">
                <p>
                    <i class="fas fa-circle"></i>
                    Сайт находится в состоянии разработки, основной функционал работает, но возможны ошибки.
                </p>
                <p>
                    <i class="fas fa-circle"></i>
                    Информация о пользователе (Уникальный идентификатор сессии) хранится в cookie.
                </p>
                <p>
                    <i class="fas fa-circle"></i>
                    Изображения обрабатываются и хранятся на сервере, вы можете удалить их при необходимости.
                </p>
                <p>
                    <i class="fas fa-circle"></i>
                    Если вы продолжаете использовать сайт, значит вы согласны с этими особенностями.
                </p>
                <p class="email-line">
                    <i class="fas fa-envelope"></i>
                    Если вы хотите оставить отзыв или пожелания, то пишите автору на почту
                    <a
                    :href="`mailto:${contactEmail}`"
                    class="toast-email"
                    >{{ contactEmail }}</a>
                </p>
            </div>
      </div>
    </Transition>

    <Transition name="btn-fade">
        <button
            v-if="isReopenButtonVisible"
            class="notice-reopen-btn"
            @click="reopen"
            title="Информация о сайте"
        >
            <i class="fas fa-info"></i>
        </button>
    </Transition>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const COOKIE_NAME = 'dev_notice_dismissed';
const COOKIE_DAYS = 365;

const props = defineProps({
  contactEmail: {
    type: String || null,
    default: '',
  },
});

const isToastVisible = ref(false);
const isReopenButtonVisible = ref(false);

// --- Хелперы cookie ---
function setCookie(name, value, days) {
  const date = new Date();
  date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/;SameSite=Lax`;
}

function getCookie(name) {
  const match = document.cookie.match(new RegExp(`(^| )${name}=([^;]+)`));
  return match ? match[2] : null;
}

function deleteCookie(name) {
  document.cookie = `${name}=;expires=Thu, 01 Jan 1970 00:00:00 UTC;path=/;SameSite=Lax`;
}

// --- Действия ---
function dismiss() {
  setCookie(COOKIE_NAME, 'true', COOKIE_DAYS);
  isToastVisible.value = false;
  isReopenButtonVisible.value = true;
}

function reopen() {
  deleteCookie(COOKIE_NAME);
  isToastVisible.value = true;
  isReopenButtonVisible.value = false;
}

onMounted(() => {
  const dismissed = getCookie(COOKIE_NAME);
  if (dismissed === 'true') {
    isReopenButtonVisible.value = true;
  } else {
    isToastVisible.value = true;
  }
});
</script>

<style scoped>
/* ========== ТОСТ ========== */
.dev-notice-toast {
    position: fixed;
    bottom: 24px;
    left: 50%;
    transform: translateX(-50%);
    width: 90%;
    max-width: 640px;
    background: rgba(22, 22, 40, 0.85);
    backdrop-filter: blur(24px);
    -webkit-backdrop-filter: blur(24px);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 20px;
    padding: 20px 24px;
    box-shadow:
        0 24px 48px rgba(0, 0, 0, 0.6),
        inset 0 0 0 1px rgba(255, 255, 255, 0.05);
    z-index: 9999;
    color: #e0dcec;
}

/* Заголовок */
.toast-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 12px;
    margin-bottom: 14px;
}

.toast-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.toast-icon {
    width: 38px;
    height: 38px;
    background: rgba(255, 180, 40, 0.15);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffb82e;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.toast-title {
    font-weight: 600;
    font-size: 1rem;
    color: #fff;
    letter-spacing: -0.2px;
}

.toast-close {
    background: rgba(255, 255, 255, 0.06);
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 10px;
    color: #aaa;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
    flex-shrink: 0;
    font-size: 0.9rem;
}

.toast-close:hover {
    background: rgba(255, 255, 255, 0.15);
    color: #fff;
}

/* Тело */
.toast-body {
    font-size: 0.88rem;
    line-height: 1.6;
    color: #c5c0d8;
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.toast-body p {
    display: flex;
    align-items: flex-start;
    gap: 8px;
    margin: 0;
}

.toast-body p i {
    color: #7c4dff;
    font-size: 0.7rem;
    margin-top: 4px;
    flex-shrink: 0;
    width: 14px;
    text-align: center;
}

.email-line i {
    color: #b794ff !important;
    font-size: 0.8rem !important;
}

.toast-email {
    color: #b794ff;
    text-decoration: none;
    font-weight: 500;
    border-bottom: 1px dashed rgba(180, 148, 255, 0.4);
    transition: all 0.2s;
}

.toast-email:hover {
    color: #d4c4ff;
    border-bottom-color: #d4c4ff;
}

/* ========== КНОПКА ПОВТОРА ========== */
.notice-reopen-btn {
    position: fixed;
    bottom: 24px;
    right: 24px;
    width: 46px;
    height: 46px;
    border-radius: 16px;
    background: rgba(30, 30, 55, 0.75);
    backdrop-filter: blur(16px);
    -webkit-backdrop-filter: blur(16px);
    border: 1px solid rgba(255, 255, 255, 0.15);
    color: #c5b8ff;
    font-size: 1.2rem;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9998;
    transition: all 0.25s ease;
    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.5);
}

.notice-reopen-btn:hover {
    background: rgba(80, 60, 180, 0.5);
    border-color: rgba(180, 150, 255, 0.5);
    box-shadow: 0 8px 28px rgba(100, 70, 220, 0.4);
    color: #fff;
    transform: scale(1.05);
}

.notice-reopen-btn:active {
    transform: scale(0.95);
}

/* ========== АНИМАЦИИ ========== */
.toast-slide-enter-active {
    transition: all 0.5s cubic-bezier(0.22, 0.61, 0.36, 1);
}
.toast-slide-leave-active {
    transition: all 0.4s ease;
}
.toast-slide-enter-from {
    opacity: 0;
    transform: translateX(-50%) translateY(60px);
}
.toast-slide-leave-to {
    opacity: 0;
    transform: translateX(-50%) translateY(60px);
}

.btn-fade-enter-active {
    transition: all 0.3s ease;
}
.btn-fade-leave-active {
    transition: all 0.2s ease;
}
.btn-fade-enter-from,
.btn-fade-leave-to {
    opacity: 0;
    transform: scale(0.7);
}

/* ========== АДАПТИВ ========== */
@media (max-width: 500px) {
    .dev-notice-toast {
        bottom: 12px;
        padding: 16px;
        border-radius: 16px;
        width: 95%;
    }
    .toast-body {
        font-size: 0.82rem;
    }
    .notice-reopen-btn {
        bottom: 12px;
        right: 12px;
        width: 40px;
        height: 40px;
        border-radius: 14px;
    }
}
</style>
