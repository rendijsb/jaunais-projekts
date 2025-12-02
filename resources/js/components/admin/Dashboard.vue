<template>
    <DashboardLayout :user-email="userEmail">
        <PropertiesList />
    </DashboardLayout>
</template>

<script setup>
import DashboardLayout from './DashboardLayout.vue';
import PropertiesList from './PropertiesList.vue';

const props = defineProps({
    userEmail: {
        type: String,
        default: 'admin@example.com'
    }
});
</script>
