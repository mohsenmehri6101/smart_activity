<template>
    <div>
        <h1 class="title-3">ایجاد فعالیت جدید</h1>
        <br>
        <hr>
        <br>

        <div v-if="loading" class="loading-container">
            <div class="spinner"></div>
            <p>لطفا صبر کنید...</p>
        </div>

        <form v-else @submit.prevent="submitActivity" class="form-container">
            <div class="form-group">
                <label>نوع فعالیت</label>
                <select v-model="form.type" required>
                    <option value="" disabled>انتخاب نوع</option>
                    <option value="task_created">ایجاد تسک</option>
                    <option value="comment_added">ثبت نظر</option>
                </select>
            </div>

            <div class="form-group">
                <label>کاربر</label>
                <input type="text" v-model="form.actor" placeholder="نام کاربر" required />
            </div>

            <div class="form-group">
                <label>هدف</label>
                <input type="text" v-model="form.target" placeholder="هدف فعالیت" required />
            </div>

            <div class="form-group">
                <label>زمان</label>
                <input type="datetime-local" v-model="form.timestamp" required />
            </div>

            <div class="form-group">
                <label>جزئیات (metadata)</label>
                <textarea v-model="form.metadata" placeholder='{"key":"value"}'></textarea>
            </div>

            <button type="submit" class="submit-button">ثبت فعالیت</button>
            <button type="button" class="back-button" @click="goBack">بازگشت</button>
        </form>

        <div v-if="successMessage" class="success-message">
            {{ successMessage }}
        </div>

        <div v-if="errorMessage" class="error-message">
            {{ errorMessage }}
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()
const baseURL = import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000'

const form = ref({
    type: '',
    actor: '',
    target: '',
    timestamp: '',
    metadata: ''
})

const loading = ref(false)
const successMessage = ref('')
const errorMessage = ref('')

const submitActivity = async () => {
    loading.value = true
    successMessage.value = ''
    errorMessage.value = ''

    try {
        const payload = {
            ...form.value,
            metadata: form.value.metadata ? JSON.parse(form.value.metadata) : null
        }

        const res = await axios.post(`${baseURL}/api/activities`, payload)

        if (res.status === 201) {
            successMessage.value = 'فعالیت با موفقیت ایجاد شد!'
            form.value = { type: '', actor: '', target: '', timestamp: '', metadata: '' }
        }
    } catch (err: any) {
        console.error(err)
        errorMessage.value = 'خطا در ایجاد فعالیت. لطفا دوباره تلاش کنید.'
    } finally {
        loading.value = false
    }
}

const goBack = () => {
    router.push('/activities')
}
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

.form-container {
    display: flex;
    flex-direction: column;
    gap: 12px;
    max-width: 400px;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 6px 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
}

.submit-button {
    padding: 6px 12px;
    background-color: #3498db;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.submit-button:hover {
    background-color: #2c80b4;
}

.back-button {
    padding: 6px 12px;
    margin-top: 5px;
    background-color: #ccc;
    color: black;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.success-message {
    margin-top: 15px;
    color: green;
    font-weight: bold;
}

.error-message {
    margin-top: 15px;
    color: red;
    font-weight: bold;
}
</style>
