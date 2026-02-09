<template>
    <div id="app" class="app-wrapper">
        <div class="container">
            <router-view></router-view>
        </div>
    </div>
</template>

<script setup lang="ts">
// خالی
</script>

<style scoped>
.app-wrapper {
    direction: rtl;
    font-family: 'Tahoma', 'Vazir', sans-serif;
    min-height: 100vh;
    background-color: #f0f0e5;
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 20px 0;
}
.container {
    background-color: #ffffff;
    padding: 20px;
    border-radius: 8px;
    width: 90%;
    max-width: 1000px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
}
</style>
