<template>
    <div>
        <h1 class="title-3">لیست فعالیت‌ها</h1>
        <br>
        <hr>
        <br>

        <!-- فیلتر -->
        <div class="filters">
            <input
                v-model="filters.type"
                placeholder="فیلتر بر اساس نوع"
                @input="fetchActivities"
            />
            <input
                v-model="filters.actor"
                placeholder="فیلتر بر اساس کاربر"
                @input="fetchActivities"
            />
        </div>

        <br>

        <!-- اطلاعات صفحه -->
        <div v-if="!loading" class="page-info">
            صفحه {{ pagination.current_page }} از {{ pagination.last_page }} -
            مجموع فعالیت‌ها: {{ pagination.total }}
        </div>

        <!-- لودینگ -->
        <div v-if="loading" class="loading-container">
            <div class="spinner"></div>
            <p>لطفا صبر کنید...</p>
        </div>

        <!-- جدول -->
        <table v-if="!loading" class="table table-hover">
            <thead>
            <tr>
                <th>شناسه</th>
                <th>نوع</th>
                <th>کاربر</th>
                <th>هدف</th>
                <th>زمان</th>
                <th>جزئیات</th>
                <th>عملیات</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="activity in activities" :key="activity.id">
                <td>{{ activity.id }}</td>
                <td>{{ parseType(activity.type) }}</td>
                <td>{{ activity.actor }}</td>
                <td>{{ activity.target }}</td>
                <td>{{ activity.timestamp }}</td>
                <td>
                    <div v-for="(value, key) in parseMetadata(activity.metadata)" :key="key">
                        <span class="bold-text">
                                                    {{ key }}
                        </span>
                        :
                        <span>
                                                    {{ value }}
                        </span>
                    </div>
                </td>
                <td>
                    <RouterLink :to="`/activities/${activity.id}`">مشاهده</RouterLink>
                </td>
            </tr>
            </tbody>
        </table>

        <!-- Pagination -->
        <div v-if="!loading && pagination.last_page > 1" class="pagination">
            <button
                :disabled="pagination.current_page === 1"
                @click="changePage(pagination.current_page - 1)"
            >
                قبلی
            </button>
            <button
                :disabled="pagination.current_page === pagination.last_page"
                @click="changePage(pagination.current_page + 1)"
            >
                بعدی
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref, reactive, onMounted } from 'vue'
import { RouterLink } from 'vue-router'
import axios from 'axios'

const baseURL = import.meta.env.APP_URL || 'http://localhost:8000'

const activities = ref([])
const loading = ref(false)
const pagination = reactive({
    total: 0,
    per_page: 15,
    current_page: 1,
    last_page: 1,
})
const filters = reactive({
    type: '',
    actor: '',
})

const typeMap: Record<string, string> = {
    task_created: 'ایجاد تسک',
    comment_added: 'ثبت نظر',
}

const parseType = (type: string) => {
    return typeMap[type] || type
}


// Fetch data from API
const fetchActivities = async (page = 1) => {
    loading.value = true
    try {
        const params = {
            page,
            type: filters.type || undefined,
            actor: filters.actor || undefined,
        }

        const res = await axios.get(`${baseURL}/api/activities`, { params })
        const data = res.data.data

        activities.value = data.items
        pagination.total = data.meta.total
        pagination.per_page = data.meta.per_page
        pagination.current_page = data.meta.current_page
        pagination.last_page = data.meta.last_page
    } catch (error) {
        console.error('خطا در دریافت فعالیت‌ها:', error)
    } finally {
        loading.value = false
    }
}

const parseMetadata = (metadata: string) => {
    try {
        return JSON.parse(metadata)
    } catch {
        return { info: metadata }
    }
}


// تغییر صفحه
const changePage = (page: number) => {
    if (page < 1 || page > pagination.last_page) return
    fetchActivities(page)
}

// Initial fetch
onMounted(() => fetchActivities())
</script>

<style scoped>
/* Spinner ساده */
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

.filters {
    display: flex;
    gap: 10px;
}

.filters input {
    padding: 6px 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.page-info {
    margin-bottom: 10px;
    font-weight: bold;
}

.pagination {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}

.pagination button {
    padding: 5px 10px;
    border: none;
    background-color: #3498db;
    color: white;
    border-radius: 4px;
    cursor: pointer;
}

.pagination button:disabled {
    background-color: #ccc;
    cursor: not-allowed;
}
.bold-text{
    font-weight: bold!important;
}
</style>
