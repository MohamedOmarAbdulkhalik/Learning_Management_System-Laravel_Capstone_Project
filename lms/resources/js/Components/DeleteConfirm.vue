<template>
    <div v-if="show" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-40">
        <div class="bg-white p-4 rounded">
        <h3 class="font-bold">Confirm</h3>
        <p>Are you sure you want to delete?</p>
        <div class="mt-4">
            <button @click="confirm" class="btn">Yes</button>
            <button @click="close" class="btn">Cancel</button>
        </div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['show'],
    methods: {
        confirm() { this.$emit('confirmed') },
        close() { this.$emit('close') }
    }
}
</script>
