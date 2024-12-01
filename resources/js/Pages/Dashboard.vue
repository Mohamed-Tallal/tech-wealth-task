<script setup>
import { ref } from 'vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import Swal from 'sweetalert2';
import axios from 'axios';

const text = ref('');
const handleSubmit = async () => {
    if (text.value.trim() === '') {
        Swal.fire({
            title: "Alert of Validation",
            text: "You must enter a value to analyze it",
            icon: "warning"
        });
    } else {
        try {
            const response = await axios.post('/analyze', {
                text: text.value,
            });
            const matches_pattern = response.data.matches_pattern ==  true ? "success" : 'error';
            Swal.fire({
                title: "Check pattern result",
                html: `Reversed text: ${response.data.reversed_text}. <br>Matches pattern: ${response.data.matches_pattern ? 'Yes' : 'No'}.`,
                icon: matches_pattern
            });
            text.value = '';
        } catch (error) {
            if (error.response && error.response.status === 422) {
                const errors = error.response.data.errors.text;
                Swal.fire({
                    title: "Validation Error",
                    text: errors.join(", "),
                    icon: "error"
                });
            } else {
                console.error('Error:', error.response?.data || error);
                Swal.fire({
                    title: "Error",
                    text: "An unexpected error occurred.",
                    icon: "error"
                });
            }
        }
    }
};
</script>

<template>
    <Head title="Pattern Analysis" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Pattern Analysis
            </h2>
        </template>

        <div class="py-12 flex justify-center items-center">
            <div class="flex justify-center items-center p-20 bg-white shadow-sm rounded-lg">
                <div class="flex items-center space-x-4">
                    <textarea
                        v-model="text"
                        placeholder="Enter text to check pattern"
                        class="p-4 w-96 h-40 border border-gray-300 rounded-md resize-none"
                    ></textarea>

                    <button
                        @click="handleSubmit"
                        class="p-2 bg-blue-500 text-white rounded-md hover:bg-blue-700">
                        Analyze Text
                    </button>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
