<template>
  <div>
      <router-view class="p-6 " v-slot="{ Component }">
          <transition name="fade" mode="out-in" >
              <component :is="Component" />
          </transition>
      </router-view>
  </div>
</template>

<script>
export default {
    name: 'app'
}
</script>


<style>
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

</style>
