<template>
    <div>
        <div v-if="loading" class="loading-container">
            <div class="spinner"></div>
            <p>لطفا صبر کنید...</p>
        </div>

        <div v-else-if="activity">
            <h1 class="title-3">جزئیات فعالیت شماره {{ activity.id }}</h1>
            <br>
            <hr>
            <br>
            <p><strong>نوع:</strong> {{ parseType(activity.type) }}</p>
            <p><strong>کاربر:</strong> {{ activity.actor }}</p>
            <p><strong>هدف:</strong> {{ activity.target }}</p>
            <p><strong>زمان:</strong> {{ activity.timestamp }}</p>

            <p><strong>جزئیات:</strong></p>
            <ul>
                <li v-for="(value, key) in parseMetadata(activity.metadata)" :key="key">
                    <span class="bold-text">
                                                    {{ key }}
                        </span>
                    :
                    <span>
                                                    {{ value }}
                        </span>
                </li>
            </ul>

            <button class="back-button" @click="goBack">بازگشت به لیست</button>
        </div>

        <div v-else>
            <p>فعالیتی با این شناسه یافت نشد.</p>
            <button class="back-button" @click="goBack">بازگشت به لیست</button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()
const activityId = Number(route.params.id)
const baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'

const activity = ref<any>(null)
const loading = ref(false)

const parseMetadata = (metadata: string) => {
    try {
        return JSON.parse(metadata)
    } catch {
        return { info: metadata }
    }
}

const typeMap: Record<string, string> = {
    task_created: 'ایجاد تسک',
    comment_added: 'ثبت نظر',
}

const parseType = (type: string) => {
    return typeMap[type] || type
}

const fetchActivity = async () => {
    loading.value = true
    try {
        const res = await axios.get(`${baseURL}/api/activities/${activityId}`)
        if (res.data.success && res.data.data) {
            activity.value = res.data.data
        }
    } catch (error) {
        console.error('Error fetching activity:', error)
    } finally {
        loading.value = false
    }
}

const goBack = () => {
    router.push('/activities')
}

onMounted(() => {
    fetchActivity()
})
</script>

<style scoped>
.loading-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    margin: 20px 0;
}

.spinner {
    border: 4px solid #f3f3f3;
    border-top: 4px solid #3498db;
    border-radius: 50%;
    width: 36px;
    height: 36px;
    animation: spin 1s linear infinite;
    margin-bottom: 8px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.back-button {
    margin-top: 20px;
    padding: 6px 12px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.back-button:hover {
    background-color: #2c80b4;
}
.bold-text{
    padding-right:15px;
    font-weight: bold!important;

}
</style>
